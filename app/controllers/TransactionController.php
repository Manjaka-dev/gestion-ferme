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
        $transactionModel = new TransactionModel(Flight::db());
        $transactionModel->venteAnimal($_GET["id"],$_GET["date"]);
        Flight::render('page', ['view' => 'list-stock']);
    }

}