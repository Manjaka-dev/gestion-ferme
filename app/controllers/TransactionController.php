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
        Flight::render('page', ['view' => 'list-stock']);
    }

}