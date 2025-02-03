<?php

use app\controllers\ApiExampleController;
use app\controllers\alimentationController;
use flight\Engine;
use flight\net\Router;
//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$router->group('/alimentation', function() use ($router, $app) {
	$alimentation_Controller = new alimentationController();
	$router->get('/voirStock', [$alimentation_Controller, 'getStock']);
	$router->post('/voirStock', [$alimentation_Controller, 'getStock']);
	$router->get('/achatAlimentation', [$alimentation_Controller, 'acheterAlimentation']);
	$router->post('/achatAlimentation', [$alimentation_Controller, 'acheterAlimentation']);
	$router->get('/listeAlliments', [$alimentation_Controller, 'getAllAliments']);
	$router->post('/listeAlliments', [$alimentation_Controller, 'getAllAliments']);
	$router->get('/ajoutStock', [$alimentation_Controller, 'addStock']);
	$router->post('/ajoutStock', [$alimentation_Controller, 'addStock']);
	$router->get('/modifierStock', [$alimentation_Controller, 'updateStock']);
	$router->post('/modifierStock', [$alimentation_Controller, 'updateStock']);
	$router->get('/supprimerStock', [$alimentation_Controller, 'deleteStock']);
	$router->post('/supprimerStock', [$alimentation_Controller, 'deleteStock']);
});


//$router->get('/', \app\controllers\WelcomeController::class.'->home'); 

$router->get('/hello-world/@name', function($name) {
	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
});

$router->group('/api', function() use ($router, $app) {
	$Api_Example_Controller = new ApiExampleController($app);
	$router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
	$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
	$router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
});
