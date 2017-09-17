<?php

$rows = 10;
$cols = 50;

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Contact form</title>
    </head>
    <body>
    	<form method='post' action='http://odinuv.cz/form_test.php'>
    		<ul>
    			<li>
    				<label>E-mail address:
    					<input type='email' name='email'>
    				</label>
    			</li>
    			<li>
    				<label>Message for us:
    					<textarea name='message' cols='$cols' rows='$rows'></textarea>
    				</label>
    			</li>
    		</ul>
    		<button type='submit' name='contactButton' value='contact'>Contact Us</button>
    	</form>
	</body>
</html>";
