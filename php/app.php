<?php

require __DIR__ . "/vendor/autoload.php";

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new Slim\App;

require __DIR__ . "/config/dependencies.php";
require __DIR__ . "/config/middleware.php";

$app->get("/", function ($request, $response, $arguments) {
	$toBeHashed = getenv('BASE_URL') . "/merchant/api/ver1/txn/req";
	echo $toBeHashed;
	return $response->write($this->view->render("index"));
});

$app->get("/hello/{name}", function ($request, $response, $arguments) {
	return $response->write($this->view->render("hello", $arguments));
});

$app->get("/hi/{name}", function ($request, $response, $arguments) {
	$route = $request->getAttribute('route');
	$x = $route->getArgument('name');
	
	echo generateOrderId($x);
});

function generateOrderId($order_id)
{
	$mc_id = substr($order_id, 4, 8);
    $order_id = str_split(substr($order_id, 0, 4), 1);
	$indexToCheck = count($order_id)-1;
	$keepChecking = true; 
	$incrementNextIndex = false;

	while ($keepChecking) {
		$c = $order_id[$indexToCheck]; 
		if ($c == 'Z') {
			$incrementNextIndex = true;
			$keepChecking = true;
		}


		if ($c == '9')
			$c = 'A';
		else if ($c == 'Z')
			$c = '0';
		else
			$c++;

		$order_id[$indexToCheck] = $c; 

		if ($incrementNextIndex && $indexToCheck != 0) {
			$indexToCheck--;
			$incrementNextIndex = false;
		} else {
			$keepChecking = false;
		}

		
	}
	
	$order_id =  implode('', $order_id);
	return str_pad($order_id, 4, '0', STR_PAD_LEFT) . $mc_id;
}

$app->run();
