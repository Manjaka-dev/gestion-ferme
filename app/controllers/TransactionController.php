<?php 

namespace app\controllers;
use app\models\TransactionModel;
use Flight;

class TransactionController 
{
    public function _construct() 
    {

    }

    public function nouvelleVente()
    {
        $idAnimal = $_GET["idAnimal"];
        Flight::render('page', ['view' => 'insert-vente', 'idAnimal' => $idAnimal]);
    }

    public function validerVente()
    {
        $trM = new TransactionModel(Flight::db());
        $trM->venteAnimal($_POST["idAnimal"], $_POST["dateVente"]);

        Flight::redirect("animals");
    }

}