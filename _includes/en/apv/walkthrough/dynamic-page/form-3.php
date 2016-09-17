<?php 

$rows = 10;
$cols = 50;
$message = "Hello,\nI'd like to know more about your product &lt;ProductName&gt;\n\nBest Regards,\n&lt;YourName&gt;";
$pageTitle = "Contact form";

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>$pageTitle</title>
    </head>
    <body>
        <h1>$pageTitle</h1>
    	<form method='post' action='http://odinuv.cz/en/form_test.php'>
    		<ul>
    			<li>
    				<label>E-mail address:
    					<input type='email' name='email'>
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
