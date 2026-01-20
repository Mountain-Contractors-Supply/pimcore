<?php

namespace App\EventListener;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(method: 'onLoginSuccess')]
final class AuthenticationLoginListener implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param LoginSuccessEvent $event
     * @return void
     */
    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        //TODO: Add login logic like migrating carts and things
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }
}
