<?php

use app\controllers\ApiExampleController;
use app\controllers\alimentationController;
use flight\Engine;
use flight\net\Router;


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

