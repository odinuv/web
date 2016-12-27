<?php
if(!empty($_COOKIE['firstVisit'])) {
	//actually this is remembered by visitor's browser
	echo 'Your first visit we remember: ' .
	     date("j.n.Y H:i:s", $_COOKIE['firstVisit']);
} else {
	echo 'You were never here before...';
}
