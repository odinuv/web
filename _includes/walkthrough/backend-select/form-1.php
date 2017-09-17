<?php

require 'latte.php';
$latte = new Latte\Engine;
$tplVars['pageTitle'] = 'Form example';
$tplVars['postData'] = var_export($_POST);

$latte->render('form-1.latte', $tplVars);
