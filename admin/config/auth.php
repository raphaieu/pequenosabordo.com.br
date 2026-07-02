<?php

return [
    'username' => $_ENV['ADMIN_USER'] ?? getenv('ADMIN_USER') ?: 'priscila',
    'password' => $_ENV['ADMIN_PASS'] ?? getenv('ADMIN_PASS') ?: 'p1m3nt4',
];

