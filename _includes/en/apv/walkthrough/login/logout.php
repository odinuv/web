<?php
//we have to include start.php because of session_start()
require 'include/start.php';
session_destroy();
//redirect somewhere or display logout message
header("Location: person-list.php");