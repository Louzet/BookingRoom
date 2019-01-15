<?php

namespace App\Events\UserEvents;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class UserSuscriber implements EventSubscriberInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    use LoggerAwareTrait;

    /**
     * MembreSuscriber constructor.
     * @param ObjectManager $manager
     * @param LoggerInterface $logger
     */
    public function __construct(ObjectManager $manager, LoggerInterface $logger)
    {
        $this->manager = $manager;

        $this->setLogger($logger);

    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onUserInteractiveLogin',
        ];
    }

    public function onUserInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if($user instanceof User)
        {
            $user->setDerniereConnexion();

            $this->manager->persist($user);

            $this->manager->flush();

            /*$this->logger->notice(sprintf('derniere connexion mise à jour pour: %s', $user->getEmail()));*/
            /*$this->logger->notice('derniere connexion mise à jour pour: {email}', ['email' => $user->getEmail()]);*/

            $this->logger->log('EMERGENCY', 'Nouveau test pour {email}', ['email' => $user->getEmail()]);
        }
    }

}