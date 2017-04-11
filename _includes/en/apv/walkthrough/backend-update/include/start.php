<?php

require 'latte.php';
$latte = new Latte\Engine;

try {
    $db = new PDO('pgsql:host=dbhost;dbname=apv', 'apv', 'apv');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("I cannot connect to database: " . $e->getMessage());
}

$tplVars['pageTitle'] = 'My First Application';
