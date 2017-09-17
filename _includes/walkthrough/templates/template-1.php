<?php

require 'latte.php';

$latte = new Latte\Engine();
$templateVariables['pageTitle'] = 'Template engine sample';
$latte->render('template-1.latte', $templateVariables);
