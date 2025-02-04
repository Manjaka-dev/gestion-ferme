<?php

namespace app\controllers;
use app\models\alimentationModel;
use app\models\CategorieAnimalModel;

use Flight;

class alimentationController {
    public function __construct() {
    }

    // Récupérer tous les aliments
    public function getAllAliments() {
        $alimModel = new alimentationModel(Flight::db());
        $aliments = $alimModel->getAllAliments();
        Flight::render('aliments', ['aliments' => $aliments]);
    }

    // Récupérer le stock d'un aliment spécifique
    public function getStock() {
        $alimModel = new alimentationModel(Flight::db());
        $stock = $alimModel->getStockByAlimentId();
        $alim = $alimModel->getMappedAlimentation();
        Flight::render('page', [ 'view' => 'list-stock', 'stock' => $stock ,'alim' => $alim]);
    }

    public function getRestock()
    {
        $alimModel = new alimentationModel(Flight::db());
        $alim = $alimModel->getAllAlimentation();
        Flight::render('page', [ 'view' => 'acheter-alim','alim' => $alim]);
    }

    // Ajouter un aliment au stock
    public function addStock() {
        $alimModel = new alimentationModel(Flight::db());
        $data = Flight::request()->data;
        $success = $alimModel->addStock($data->id_alimentation, $data->qtt, $data->prix_unite, $data->date_achat);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Mettre à jour le stock d'un aliment
    public function updateStock() {
        $alimModel = new alimentationModel(Flight::db());
        $data = Flight::request()->data;
        $success = $alimModel->updateStock($data->id_alimentation, $data->qtt);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Supprimer un aliment du stock
    public function deleteStock($id) {
        $alimModel = new alimentationModel(Flight::db());
        $success = $alimModel->deleteStock($id);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Acheter une alimentation
    public function acheterAlimentation() {
        $alimModel = new alimentationModel(Flight::db());
        $data = Flight::request()->data;
        $success = $alimModel->acheterAlimentation($data->id_alimentation, $data->qtt, $data->prix_unite);
        Flight::render('achat', ['success' => $success]);
    }

    public function insererAlim()
    {
        $alimModel = new alimentationModel(Flight::db());
        $alimModel->insererAlim($_POST["id_alimentation"], $_POST["qtt"], $_POST["date_achat"], $_POST["prix_unite"]);
        Flight::redirect("voirStock");
    }

    public function goToFormAlim()
    {
        $catAnim = new CategorieAnimalModel(Flight::db());
        $categorie = $catAnim->getAll();
        Flight::render('page',['view' => 'insert-alim','categorie' => $catAnim]);
    }

    public function nouvelAlim()
    {
        $alimModel = new alimentationModel(Flight::db());
        $alimModel->insererCategAlim($_POST["nom"], $_POST["pourcentage"]);
        Flight::redirect("lierAlim");
    }

    public function lierAlimAnimal()
    {
        $alimModel = new alimentationModel(Flight::db());
        $alimModel->lierAlimAnimal($_POST["id_alimentation"], $_POST["qtt"], $_POST["date_achat"], $_POST["prix_unite"]);
        Flight::redirect("voirStock");
    }
}
