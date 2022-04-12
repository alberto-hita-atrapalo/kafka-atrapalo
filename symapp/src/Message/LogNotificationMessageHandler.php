<?php

namespace App\Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogNotificationMessageHandler implements MessageHandlerInterface
{
    public function __invoke(LogNotification $message)
    {
        // ... do some work - like sending an SMS message!
    }
}
