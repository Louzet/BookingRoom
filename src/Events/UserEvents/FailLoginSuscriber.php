<?php

namespace App\Events\UserEvents;

use Predis\ClientInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class FailLoginSuscriber implements EventSubscriberInterface
{
    public const FAIL_TTL_HOUR = 1;

    public const KEY_PREFIX = 'login_failure_';

    /**
     * @var ClientInterface
     */
    protected $redis;
    protected $request;

    public function __construct(RequestStack $requestStack, $sncRedisDefault)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->redis = $sncRedisDefault;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
        ];
    }

    /**
     * Client IP shouldn't be empty but better to test. We don't need the event as we
     * don't use the username that caused the failure. If you want it, pass the
     * argument "AuthenticationFailureEvent" to this function like below.
     *
     * @param AuthenticationFailureEvent $authenticationFailureEvent
     */
    public function onAuthenticationFailure(AuthenticationFailureEvent $authenticationFailureEvent): void
    {
        $email = $this->request->get('app_login')['email'];
        if (!$email) {
            $message_error = $authenticationFailureEvent->getAuthenticationException();
        }

        $key = self::KEY_PREFIX.$email;

        $this->redis->incr($key); // increment the failed login counter for this ip

        $this->redis->expire($key, self::FAIL_TTL_HOUR * 3600); // refresh the cache key TTL
    }
}
