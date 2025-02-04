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
            'date' => $date,
            'view'  => 'situation-elevage'
        ];

        Flight::render('page', $data);
    }

    public function getSituationElevageJson() {
        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

        $gestionElevageModel = new GestionElevageModel(Flight::db());

        $situationElevage = $gestionElevageModel->getSituationElevage($date);
        
        $ventes = $gestionElevageModel->getVentesElevage($date);
        
        $depenses = $gestionElevageModel->getDepensesElevage($date);

        $gains = $gestionElevageModel->getGainsElevage($date);

        $conclusion = $gestionElevageModel->getConclusionElevage($date);

        // Créer un tableau des données à renvoyer
        $data = [
            'situationElevage' => $situationElevage,
            'ventes' => $ventes,
            'depenses' => $depenses,
            'gains' => $gains,
            'conclusion' => $conclusion,
            'date' => $date
        ];

        // Renvoyer les données au format JSON
        Flight::json($data);
    }
 

     // Fonction pour obtenir l'historique des transactions
     public function getHistoriqueTransa() {
        $gestionElevageModel = new GestionElevageModel(Flight::db());

        $historiqueTransactions = $gestionElevageModel->getHistoriqueTransactions();

        $data = [
            'historiqueTransactions' => $historiqueTransactions,
            'view' => 'historique-transactions'
        ];
        Flight::render('page', $data);
    }
}
