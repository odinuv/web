<?php

require 'latte.php';

$latte = new Latte\Engine();
$tplVars = [];
$latte->render('login-form.latte', $tplVars);
