<?php
$app->get('/persons[/{page:[0-9]+}]', function(Request $request, Response $response, $args) {
	$pageLimit = 10;
	try {
		$page = !empty($args['page']) ? $args['page'] : 0;
		//select persons with limit and offset
		$stmt = $this->db->prepare('
			SELECT * FROM person 
			ORDER BY last_name, first_name
			LIMIT :pl OFFSET :of
		');
		$stmt->bindValue(':pl', $pageLimit);
		$stmt->bindValue(':of', $page * $pageLimit);
		$stmt->execute();
		//calculate how much rows is in the database
		$stmtCnt = $this->db->query('SELECT COUNT(*) AS cnt FROM person');
		$pageInfo = $stmtCnt->fetch();
		//copy values to template
		$tplVars['pCount'] = ceil($pageInfo['cnt'] / $pageLimit);
		$tplVars['pLimit'] = $pageLimit;
		$tplVars['pCurr'] = $page;
		$tplVars['persons'] = $stmt->fetchAll();
		return $this->view->render($response, 'persons-list.latte', $tplVars);
	} catch (PDOException $e) {
		$this->logger->error($e->getMessage());
	}
})->setName('persons');