<?php

use app\controllers\ApiExampleController;
use app\controllers\TransactionController;
use app\controllers\alimentationController;
use app\controllers\GestionElevageController;
use app\controllers\GestionAnimalController;
use flight\Engine;
use flight\net\Router;

$TransactionController = new TransactionController();
$GestionAnimalController = new GestionAnimalController();


$router->get('/animals', [$GestionAnimalController,'getListAnimal']);
$router->get('/details', [$GestionAnimalController, 'getAnimalSpec']);
$router->get('/venteAnimal', [$TransactionController, 'nouvelleVente']);

$alimentation_Controller = new alimentationController();
$router->get('/', [$alimentation_Controller, 'getStock']);
$router->get('/voirStock', [$alimentation_Controller, 'getStock']);


$router->group('/alimentation', function() use ($router) {
	$alimentation_Controller = new alimentationController();
	$router->get('/voirStock', [$alimentation_Controller, 'getStock']);
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

$router->group('/GestiionElevage', function() use ($router) {
	$GestionElevage_Controller = new GestionElevageController();
	$router->get('/SituationElevage', [$GestionElevage_Controller, 'getSituationElevage']);
	$router->post('/SituationElevage', [$GestionElevage_Controller, 'getSituationElevage']);
	$router->get('/HistoriqueTransa', [$GestionElevage_Controller, 'getHistoriqueTransa']);
	$router->post('/HistoriqueTransa', [$GestionElevage_Controller, 'getHistoriqueTransa']);
});
