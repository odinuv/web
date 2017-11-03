<?php

$route->get('/persons', function (Request $request, Response $response, $args) {
    $queryParams = $request->getQueryParams();

    $keyword = '';
    $message = '';
    $persons = [];
    try {
        if (!empty($queryParams['keyword'])) {
            $keyword = $queryParams['keyword'];
            $parts = explode(' ', $keyword);
            if (count($parts) == 1) {
                $stmt = $this->db->prepare('
                    SELECT first_name, last_name, nickname, AGE(birth_day) FROM person
                    WHERE (first_name ILIKE :keyword) OR (last_name ILIKE :keyword) 
                    ORDER BY last_name, first_name
                ');
                $stmt->bindValue('keyword', '%' . $parts[0] . '%');
                $stmt->execute();
                $persons = $stmt->fetchAll();
            } elseif (count($parts) == 2) {
                $stmt = $this->db->prepare('
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
        $this->logger->error($e->getMessage());
        exit("I cannot execute the query: " . $e->getMessage());
    }

    $tplVars['search'] = $keyword;
    $tplVars['persons'] = $persons;
    $tplVars['message'] = $message;
    $this->view->render($response, 'persons-list.latte', $tplVars);
});