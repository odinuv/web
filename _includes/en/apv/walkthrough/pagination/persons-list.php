<?php
require 'include/start.php';

$pageLimit = 10;

try {
	$page = !empty($_GET['page']) ? intval($_GET['page']) : 0;
	//select persons with limit and offset
	$stmt = $db->prepare('
		SELECT * FROM person 
		ORDER BY last_name, first_name
		LIMIT :pl OFFSET :of
	');
	$stmt->bindValue(':pl', $pageLimit);
	$stmt->bindValue(':of', $page * $pageLimit);
	$stmt->execute();
	//calculate how much rows is in the database
	$stmtCnt = $db->query('SELECT COUNT(*) AS cnt FROM person');
	$pageInfo = $stmtCnt->fetch();
	//copy values to template
	$tplVars['pCount'] = ceil($pageInfo['cnt'] / $pageLimit);
	$tplVars['pLimit'] = $pageLimit;
	$tplVars['pCurr'] = $page;
} catch (PDOException $e) {
	exit("I cannot execute the query: " . $e->getMessage());
}
$tplVars['pageTitle'] = 'Persons List';
$tplVars['persons'] = $stmt->fetchAll();
$latte->render('templates/persons-list.latte', $tplVars);
