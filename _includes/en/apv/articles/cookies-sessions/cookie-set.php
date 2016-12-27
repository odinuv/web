<?php
if(empty($_COOKIE['firstVisit'])) {
	setcookie('firstVisit', time());
}
