<?php

namespace app\controllers;

use app\models\GestionElevageModel;
use Flight;

class GestionElevageController {

    // Fonction pour obtenir la situation de l'élevage
    public function getSituationElevage() {
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

        $gestionElevageModel = new GestionElevageModel(Flight::db());

        $situationElevage = $gestionElevageModel->getSituationElevage($date);
        
        $ventes = $gestionElevageModel->getVentesElevage($date);
        
        $depenses = $gestionElevageModel->getDepensesElevage($date);

        $gains = $gestionElevageModel->getGainsElevage($date);

        $conclusion = $gestionElevageModel->getConclusionElevage($date);

        $data = [
            'situationElevage' => $situationElevage,
            'ventes' => $ventes,
            'depenses' => $depenses,
            'gains' => $gains,
            'conclusion' => $conclusion,
            'date' => $date
        ];

        Flight::render('situation-elevage', $data);
    }

     // Fonction pour obtenir l'historique des transactions
     public function getHistoriqueTransa() {
        $gestionElevageModel = new GestionElevageModel(Flight::db());

        $historiqueTransactions = $gestionElevageModel->getHistoriqueTransactions();

        $data = [
            'historiqueTransactions' => $historiqueTransactions
        ];
        Flight::render('historique-transactions', $data);
    }
}
