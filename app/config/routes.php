<?php

use app\controllers\TransactionController;
use app\controllers\alimentationController;
use app\controllers\GestionElevageController;
use app\controllers\GestionAnimalController;
use app\controllers\FinanceController;

$TransactionController = new TransactionController();
$GestionAnimalController = new GestionAnimalController();
$FinanceContoller = new FinanceController();

$router->get('/animals', [$GestionAnimalController,'getListAnimal']);
$router->get('/details', [$GestionAnimalController, 'getAnimalSpec']);
$router->get('/venteAnimal', [$TransactionController, 'nouvelleVente']);

$alimentation_Controller = new alimentationController();
$router->get('/restock', [$alimentation_Controller, 'getRestock']);
$router->get('/', [$FinanceContoller, 'home']);
$router->get('/insererCapital', [$FinanceContoller, 'insererCapital']);
$router->get('/voirStock', [$alimentation_Controller, 'getStock']);
$router->post('/acheterAlim', [$alimentation_Controller, 'insererAlim']);
$router->get('/nouvelAlim', [$alimentation_Controller, 'goToFormAlim']);

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

$router->group('/animal', function() use ($router) {
	$gestionAnimalController = new GestionAnimalController();
	$router->get('/choix', [$gestionAnimalController, 'getFormulaireChoixanimal']);
	$router->post('/nourrir', [$gestionAnimalController, 'nourrirAnimal']);
	$router->get('/detail', [$gestionAnimalController, 'getAnimalSpec']);
	$router->get('/ajout', [$gestionAnimalController, 'getFormAjoutAnimal']);
});

