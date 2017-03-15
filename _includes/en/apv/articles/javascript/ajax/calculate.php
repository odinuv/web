<?php
if(isset($_GET["a"]) && isset($_GET["b"])) {
    //read inputs
	$res = intval($_GET["a"]) + intval($_GET["b"]);
	//set correct content type of response
	header("Content-Type: application/json");
	//send data as JSON
	echo json_encode(["result" => $res]);
} else {
    //something is wrong
	http_response_code(400);
}

