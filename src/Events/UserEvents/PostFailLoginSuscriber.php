<?php

namespace App\Events\UserEvents;

use Predis\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class PostFailLoginSuscriber implements EventSubscriberInterface
{
    public const MAX_LOGIN_FAILURE_ATTEMPTS = 5;

    private const PRIORIY = 10;

    private const LOGIN_ROUTE = 'user.login'; // Ma route de login

    private $router;

    private $logger;

    /**
     * @var ClientInterface
     */
    private $redis;

    private $template;

    /**
     * @var int|null
     */
    private $status_code;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(RouterInterface $router, LoggerInterface $logger, $sncRedisDefault, \Twig_Environment $twig)
    {
        $this->router = $router;

        $this->logger = $logger;

        $this->redis = $sncRedisDefault;

        $this->twig = $twig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['checkLoginBan', self::PRIORIY],
        ];
    }

    public function checkLoginBan(GetResponseEvent $event)
    {
        $requestEvent = $event->getRequest();

        // Only post routes, first check is for typehint on $this->router
        if (!$this->router instanceof Router || !$requestEvent->isMethod(Request::METHOD_POST)) {
            return;
        }

        // Only for the login check route
        $route = $this->router->matchRequest($requestEvent)['_route'] ?? '';
        if (self::LOGIN_ROUTE !== $route) {
            return;
        }

        $email = $requestEvent->get('app_login')['email'];

        $key = FailLoginSuscriber::KEY_PREFIX.$email;

        if ((int) $this->redis->get($key) >= (self::MAX_LOGIN_FAILURE_ATTEMPTS - 1)) {
            $this->logger->critical(sprintf('Le compte %s a été banni à cause %d échecs de connexion.', $email, self::MAX_LOGIN_FAILURE_ATTEMPTS));

            // throw new HttpException(Response::HTTP_TOO_MANY_REQUESTS);
            // return twig's template

            $this->status_code = Response::HTTP_TOO_MANY_REQUESTS;

            $time_left_secondes = $this->redis->ttl($key);

            $time_left = $time_left_secondes / 60;

            try {
                $this->template = $this->twig->render('errors/error429.html.twig', [
                    'status_code' => $this->status_code,
                    'time_left' => round($time_left),
                ]);
            } catch (\Twig_Error_Loader $e) {
            } catch (\Twig_Error_Runtime $e) {
            } catch (\Twig_Error_Syntax $e) {
            }

            $response = new Response($this->template, $this->status_code);

            $event->setResponse($response);
        }
    }
}
