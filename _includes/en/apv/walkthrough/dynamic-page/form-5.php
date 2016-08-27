<?php 

// Logged User
$currentUser = [
    'firstName' => 'John',
    'lastName' => 'Doe',
    'email' => 'john.doe@example.com',
    'yearOfBirth' => 1996,
];
/*
// Not Logged User
$currentUser = [
    'firstName' => '',
    'lastName' => '',
    'email' => '',
    'yearOfBirth' => '',
];
*/
$rows = 10;
$cols = 50;
$pageTitle = "Contact form";
$currentYear = date('Y');
if ($currentUser['firstName'] != '') {
    $message = "Hello,\nI'd like to know more about your product &lt;ProductName&gt;\n\nBest Regards,\n" . 
        $currentUser['firstName'] . ' ' . $currentUser['lastName'];
} else {
    $message = "Hello,\nI'd like to know more about your product &lt;ProductName&gt;\n\nBest Regards,\n&lt;YourName&gt;";
}
$years = [];
for ($year = 1916; $year < $currentYear; $year++) {
    $years[] = $year;
}

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>$pageTitle</title>
    </head>
    <body>
        <h1>$pageTitle</h1>";   
        if ($currentUser['firstName'] != '') {
            echo "<h2>Hello " . $currentUser['firstName'] . " " . $currentUser['lastName'] . "</h2>";
        }
        echo "
    	<form method='post' action='todo'>
    		<ul>
    			<li>
    				<label>First name:
    					<input type='text' name='firstName' value='" . $currentUser['firstName'] . "'>
    				</label>
    			</li>
                <li>
                    <label>Last name:
                        <input type='text' name='lastName' value='" . $currentUser['lastName'] . "'>
                    </label>
                </li>
                <li>
                    <label>E-mail address:
                        <input type='email' name='email' value='" . $currentUser['email'] . "'>
                    </label>
                </li>                
                <li>
                    <label>Year of birth:
                        <select name='year'>";
                        foreach ($years as $year) {
                            if ($currentUser['yearOfBirth'] == $year) {
                                echo "<option selected value='$year'>$year</option>";
                            } else {
                                echo "<option value='$year'>$year</option>";
                            }
                        }
                        echo "
                        </select>
                    </label>
                </li>
    			<li>
    				<label>Message for us:
    					<textarea name='message' cols='$cols' rows='$rows'>$message</textarea>
    				</label>
    			</li>
    		</ul>
    		<button type='submit' name='contactButton' value='contact'>Contact Us</button>
    	</form>
	</body>
</html>";
