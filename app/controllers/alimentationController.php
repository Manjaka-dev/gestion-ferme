<?php

namespace app\controllers;
use app\models\alimentationModel;

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
}
