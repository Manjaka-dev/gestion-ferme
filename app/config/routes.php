<?php

use app\controllers\TransactionController;
use app\controllers\alimentationController;
use app\controllers\GestionElevageController;
use app\controllers\GestionAnimalController;
use app\controllers\FinanceController;
use app\controllers\CategorieAnimalController;
use app\controllers\DeleteController;

$TransactionController = new TransactionController();
$GestionAnimalController = new GestionAnimalController();
$FinanceContoller = new FinanceController();
$CategorieAnimalController = new CategorieAnimalController();
$Delete_Controller = new DeleteController();

$router->get('/animals', [$GestionAnimalController,'getListAnimal']);
$router->get('/details', [$GestionAnimalController, 'getAnimalSpec']);
$router->get('/venteAnimal', [$TransactionController, 'nouvelleVente']);
$router->get('/reset', [$Delete_Controller, 'reset']);

$alimentation_Controller = new alimentationController();
$router->get('/restock', [$alimentation_Controller, 'getRestock']);
$router->get('/', [$FinanceContoller, 'home']);
$router->get('/insererCapital', [$FinanceContoller, 'insererCapital']);
$router->get('/voirStock', [$alimentation_Controller, 'getStock']);
$router->post('/acheterAlim', [$alimentation_Controller, 'insererAlim']);
$router->get('/nouvelAlim', [$alimentation_Controller, 'goToFormAlim']);
$router->get('/formAnimal', [$GestionAnimalController, 'goToFormAnimal']);
$router->get('/ajoutCategAnimal', [$CategorieAnimalController, 'goToCateg']);
$router->post('/insererCateg', [$CategorieAnimalController, 'insertCateg']);
$router->get('/listCateg', [$CategorieAnimalController, 'goToListCateg']);
$router->post('/modifierCateg', [$CategorieAnimalController, 'updateCateg']);
$router->post('/ajoutAnimal', [$GestionAnimalController, 'insertAnimalWithPhoto']);
$router->get('/insererVente', [$GestionAnimalController, 'goToDateVente']);
$router->post('/insererDateVente', [$GestionAnimalController, 'updateDateVente']);


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

$router->group('/GestionElevage', function() use ($router) {
	$GestionElevage_Controller = new GestionElevageController();
	$router->get('/SituationElevage', [$GestionElevage_Controller, 'getSituationElevage']);
	$router->post('/SituationElevage', [$GestionElevage_Controller, 'getSituationElevage']);
	$router->get('/HistoriqueTransa', [$GestionElevage_Controller, 'getHistoriqueTransa']);
	$router->post('/HistoriqueTransa', [$GestionElevage_Controller, 'getHistoriqueTransa']);
	$router->get('/SituationElevageJson', [$GestionElevage_Controller, 'getSituationElevageJson']);
	$router->post('/SituationElevageJson', [$GestionElevage_Controller, 'getSituationElevageJson']);
});

$router->group('/animal', function() use ($router) {
	$gestionAnimalController = new GestionAnimalController();
	$router->get('/choix', [$gestionAnimalController, 'getFormulaireChoixanimal']);
	$router->post('/nourrir', [$gestionAnimalController, 'nourrirAnimal']);
	$router->get('/detail', [$gestionAnimalController, 'getAnimalSpec']);
	$router->get('/ajout', [$gestionAnimalController, 'getFormAjoutAnimal']);
});

