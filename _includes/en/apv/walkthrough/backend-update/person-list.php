<?php

require 'include/start.php';

$tplVars['pageTitle'] = 'Persons List';
if (!empty($_GET['search'])) {
    if (!empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    } else {
        $keyword = '';
    }
} else {
    $keyword = '';
}

try {
    if ($keyword) {
        $stmt = $db->prepare('
	        SELECT first_name, last_name, nickname, AGE(birth_day), id_person
	        FROM person
	        WHERE (first_name ILIKE :keyword) OR
	              (last_name ILIKE :keyword) OR
	              (nickname ILIKE :keyword)
	        ORDER BY last_name, first_name
	    ');
        $stmt->bindValue('keyword', '%' . $keyword . '%');
        $stmt->execute();
    } else {
        $stmt = $db->query('
	        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
	        ORDER BY last_name, first_name
	    ');
    }
} catch (PDOException $e) {
    exit("I cannot execute the query: " . $e->getMessage());
}

$tplVars['search'] = $keyword;
$tplVars['persons'] = $stmt->fetchAll();
$latte->render('templates/person-list.latte', $tplVars);
