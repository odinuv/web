<?php

require 'latte.php';

$latte = new Latte\Engine;

$tplVars['pageTitle'] = 'Persons List';

$latte->render('persons-dynamic-1.latte', $tplVars);
