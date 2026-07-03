<?php

namespace Patterns\Observer\Observers;

use SplObserver;

class OnboardingNotification implements SplObserver
{
    private $adminEmail;

    public function __construct($adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function update(\SplSubject $repository, ?string $event = null, $data = null): void
    {
        echo "OnboardingNotification: The notification has been emailed!\n";
    }
}