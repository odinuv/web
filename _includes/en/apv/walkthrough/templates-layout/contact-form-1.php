<?php

require 'latte.php';

$latte = new Latte\Engine();
$currentUser = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'birth_year' => 1996,
];
/*
// Not Logged User
$currentUser = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'birth_year' => '',
];
*/
if ($currentUser['first_name']) {
    $tplVars['message'] = "Hello,\nI'd like to know more about your product <ProductName>\n\nBest Regards,\n" . 
        $currentUser['first_name'] . ' ' . $currentUser['lastName'];
} else {
    $tplVars['message'] = "Hello,\nI'd like to know more about your product <ProductName>\n\nBest Regards,\n<YourName>";
}

$tplVars['rows'] = 10;
$tplVars['cols'] = 50;
$tplVars['pageTitle'] = "Contact form";
$tplVars['currentUser'] = $currentUser;
$tplVars['years'] = [];
for ($year = 1916; $year < date('Y'); $year++) {
    $tplVars['years'][] = $year;
}

$latte->render('contact-form-1.latte', $tplVars);
