<?php

use Patterns\Observer\Observers\Logger;
use Patterns\Observer\Observers\OnboardingNotification;
use Patterns\Observer\Repositories\UserRepository;

require_once __DIR__ . "/../../vendor/autoload.php";

$repository = new UserRepository();
$repository->attach(new Logger(__DIR__ . "/log.txt"), "*");
$repository->attach(new OnboardingNotification('1@example.com'), "users:created");

// $repository->initialize(__DIR__ . "/users.csv");

$user = $repository->createUser([
    'name' => 'John Smith',
    'email' => 'john99@exmaple.com'
]);

$repository->deleteUser($user);