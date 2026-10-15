<?php

if (PHP_SAPI !== 'cli') {
    exit("Run this file from the command line only.\n");
}
require_once __DIR__ . "/../core/Database.php";

[$script, $name, $email, $phone, $gender, $password] = array_pad($argv, 6, null);
if (!$name || !$email || !$phone || !in_array($gender, ['male', 'female'], true) || strlen((string) $password) < 8) {
    exit("Usage: php database/seed_admin.php \"Name\" email phone male|female \"password(min 8)\"\n");
}

$DB = Database::getConnection();
$stmt = $DB->prepare("INSERT INTO users (role, name, email, password, phone, gender) VALUES ('admin', :n, :e, :p, :ph, :g)");
$stmt->execute(['n' => $name, 'e' => $email, 'p' => password_hash($password, PASSWORD_DEFAULT), 'ph' => $phone, 'g' => $gender]);
echo "Admin created with id " . $DB->lastInsertId() . "\n";
