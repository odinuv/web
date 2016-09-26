<?php 

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>PHP Generated page</title>
    </head>
    <body>
";

$firstName = 'John';
$lastName = 'O\'Reilly'; 

$count = 0;
$colloquialGreeting = "Hi $firstName";

$count = $count + 1;
$informalGreting = "Hello " . $firstName . " $lastName";

echo '<p>Salutation count: ' . $count . '</p>';
echo "<ul>";
echo '<li>' . $colloquialGreeting . '</li>';
echo "<li>$informalGreting</li>\n";
echo "</ul>\n";

echo "</body>\n</html>";

