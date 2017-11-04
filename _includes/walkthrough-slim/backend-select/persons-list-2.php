<?php

$route->get('/persons', function (Request $request, Response $response, $args) {
    $queryParams = $request->getQueryParams();

    if (!empty($queryParams['search'])) {
        if (!empty($queryParams['keyword'])) {
            $keyword = $queryParams['keyword'];
        } else {
            $keyword = '';
        }
    } else {
        $keyword = '';
    }

    try {
        if ($keyword) {
            $stmt = $this->db->prepare('
	        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
	        WHERE (first_name ILIKE :keyword)
	           OR (last_name ILIKE :keyword)
	           OR (nickname ILIKE :keyword)
	        ORDER BY last_name, first_name
	    ');
            $stmt->bindValue('keyword', '%' . $keyword . '%');
            $stmt->execute();
        } else {
            $stmt = $this->db->query('
	        SELECT first_name, last_name, nickname, AGE(birth_day) FROM person 
	        ORDER BY last_name, first_name
	    ');
        }
    } catch (PDOException $e) {
        $this->logger->error($e->getMessage());
        exit("I cannot execute the query: " . $e->getMessage());
    }

    $tplVars['search'] = $keyword;
    $tplVars['persons'] = $stmt->fetchAll();
    $this->view->render($response, 'persons-list.latte', $tplVars);
});