<?php

namespace App\Events\UserEvents;


use Predis\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class PostFailLoginSuscriber implements EventSubscriberInterface
{
    public const MAX_LOGIN_FAILURE_ATTEMPTS = 3;

    private const PRIORIY = 10;

    private const LOGIN_ROUTE = 'booking.login'; // Ma route de login

    private $router;

    private $logger;

    /**
     * @var ClientInterface
     */
    private $redis;
    private $container;
    /**
     * @var TwigEngine
     */
    private $twigEngine;

    public function __construct(RouterInterface $router, LoggerInterface $logger, $sncRedisDefault, TwigEngine $twigEngine)
    {
        $this->router = $router;

        $this->logger = $logger;

        $this->redis  = $sncRedisDefault;

        $this->twigEngine = $twigEngine;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['checkLoginBan', self::PRIORIY],
            KernelEvents::VIEW => 'onResponseController'
        ];
    }

    public function checkLoginBan(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // Only post routes, first check is for typehint on $this->router
        if (!$this->router instanceof Router || !$request->isMethod(Request::METHOD_POST)) {
            return;
        }

        // Only for the login check route
        $route = $this->router->matchRequest($request)['_route'] ?? '';
        if (self::LOGIN_ROUTE !== $route) {
            return;
        }

        $ip = $request->getClientIp();

        $key = FailLoginSuscriber::KEY_PREFIX.$ip;

        if ((int) $this->redis->get($key) >= self::MAX_LOGIN_FAILURE_ATTEMPTS)
        {
            $this->logger->critical(sprintf("l'IP %s a été banni à cause %d échecs de connexion.", $ip, self::MAX_LOGIN_FAILURE_ATTEMPTS));

            /*throw new HttpException(Response::HTTP_TOO_MANY_REQUESTS);*/

        }

    }


}