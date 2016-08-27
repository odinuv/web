<?php

require 'latte.php';
$latte = new Latte\Engine;

try {
    $db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("I cannot connect to database: " . $e->getMessage());
}

$tplVars['pageTitle'] = 'Persons List';

$message = '';
$persons = [];
try {
    if (!empty($_GET['keyword'])) {
        $parts = explode(' ', $_GET['keyword']);
        if (count($parts) == 1) {
            $stmt = $db->prepare('
                SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
                WHERE (first_name ILIKE :keyword) OR (last_name ILIKE :keyword) 
                ORDER BY last_name, first_name
            ');
            $stmt->bindValue('keyword', '%' . $parts[0] . '%');      
            $stmt->execute();    
            $persons = $stmt->fetchAll();
        } elseif (count($parts) == 2) {
            $stmt = $db->prepare('
                SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
                WHERE (first_name ILIKE :keyword1) AND (last_name ILIKE :keyword2) 
                ORDER BY last_name, first_name
            ');
            $stmt->bindValue('keyword1', '%' . $parts[0] . '%');
            $stmt->bindValue('keyword2', '%' . $parts[1] . '%');
            $stmt->execute(); 
            $persons = $stmt->fetchAll();
        } else {
            $message = 'Use at most two words in the search';
        }
    }
} catch (PDOException $e) {
    exit("I cannot execute the query: " . $e->getMessage());
}

$tplVars['search'] = $keyword;
$tplVars['persons'] = $persons;
$tplVars['message'] = $message;
$latte->render('persons-list-sol.latte', $tplVars);
