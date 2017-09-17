<?php

require 'include/start.php';
$tplVars['message'] = '';
$latte->render('templates/person-add.latte', $tplVars);