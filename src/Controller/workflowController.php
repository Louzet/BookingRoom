<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

/**
 * Class workflowController.
 */
class workflowController
{
    /**
     * @var Registry
     */
    private $workflows;
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * workflowController constructor.
     *
     * @param Registry        $workflows
     * @param ObjectManager   $manager
     * @param LoggerInterface $logger
     */
    public function __construct(Registry $workflows, ObjectManager $manager, LoggerInterface $logger)
    {
        $this->workflows = $workflows;
        $this->manager = $manager;
        $this->logger = $logger;
    }

    /**
     * @param Reservation $reservation
     * @param $transition
     * @Route("/apply-transition/{reservation}/{transition}", name="apply.workflow")
     */
    public function execute(Reservation $reservation, $transition): void
    {
        $workflow = $this->workflows->get($reservation);

        if ($workflow->can($reservation, (string) $transition)) {
            try {
                $workflow->apply($reservation, (string) $transition);
                $this->manager->persist($reservation);
                $this->manager->flush();
            } catch (LogicException $logicException) {
                $this->logger->critical(sprintf(
                    'Transition %s impossible !', $transition)
                );
            }
        }
    }
}
