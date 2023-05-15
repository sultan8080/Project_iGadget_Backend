<?php

namespace App\Events;

use App\Entity\Users;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['passwordHash', EventPriorities::PRE_WRITE]
        ];
    }

    public function passwordHash(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($result instanceof Users && $method === "POST") {
            $hash = $this->userPasswordHasher->hashPassword($result, $result->getPassword());
            $result->setPassword($hash);
        }
    }
}
