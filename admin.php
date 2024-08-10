<?php

use App\Controllers\AdminController;

require_once __DIR__ . "/vendor/autoload.php";

echo 'Welcome to BanguBank admin registration.' . "\n\n";

while ($option !== 0) {
    $errors = [];

    echo '0. Exit'. "\n";
    echo '1. Create an admin.' . "\n\n";
    $option = (int) readline('Enter an option: ');
    if ($option < 0 or $option > 1) {
        echo 'Invalid option!' . "\n\n";
        continue;
    }

    if ($option === 0) break;

    echo 'Please provide required info for register an admin.' . "\n\n";
    $name = (string) htmlspecialchars(trim(readline('Admin name: ')));
    $email = (string) htmlspecialchars(trim(readline('Admin email: ')));
    $password = (string) htmlspecialchars(trim(readline('Admin password: ')));
    $password2 = (string) htmlspecialchars(trim(readline('Confirm password: ')));

    // errors checking
    if (strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 chars long.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is not valid.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 chars long.';
    }
    if (!count($errors)) {
        if ($password !== $password2) {
            $errors[] = 'Confirm password did not matched.';
        }
    }

    if (count($errors)) {
        echo "\n\nPlease provide valid info!\n......................................\n";
        foreach ($errors as $error) {
            echo 'Error: ' . $error . "\n";
        }echo "\n";
        continue;
    }

    $result = (new AdminController())->store([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'handle' => explode('@', $email)[0],
    ]);

    if (!$result) {
        echo "\n" . 'User already exist.' . "\n\n";
        continue;
    }

    echo 'Admin added successfully.' . "\n\n";
    $option = 0;
}
