<?php

namespace app\controllers;

use Flight;

class alimentationController {
    public function __construct() {
        session_start();
    }

    // Récupérer tous les aliments
    public function getAllAliments() {
        $aliments = Flight::alimentationModel()->getAllAliments();
        Flight::render('aliments', ['aliments' => $aliments]);
    }

    // Récupérer le stock d'un aliment spécifique
    public function getStock($id) {
        $stock = Flight::alimentationModel()->getStockByAlimentId($id);
        Flight::render('stock', ['stock' => $stock]);
    }

    // Ajouter un aliment au stock
    public function addStock() {
        $data = Flight::request()->data;
        $success = Flight::alimentationModel()->addStock($data->id_alimentation, $data->qtt, $data->prix_unite, $data->date_achat);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Mettre à jour le stock d'un aliment
    public function updateStock() {
        $data = Flight::request()->data;
        $success = Flight::alimentationModel()->updateStock($data->id_alimentation, $data->qtt);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Supprimer un aliment du stock
    public function deleteStock($id) {
        $success = Flight::alimentationModel()->deleteStock($id);
        Flight::render('stock_update', ['success' => $success]);
    }

    // Acheter une alimentation
    public function acheterAlimentation() {
        $data = Flight::request()->data;
        $success = Flight::alimentationModel()->acheterAlimentation($data->id_alimentation, $data->qtt, $data->prix_unite);
        Flight::render('achat', ['success' => $success]);
    }
}
