<?php

namespace app\controllers;

use app\models\FinanceModel;


use Flight;

class FinanceController {

    public function home()
    {
        Flight::render("page", ['view' => 'insert-capital']);
    }

    public function insererCapital()
    {
        $finM = new FinanceModel(Flight::db());
        $finM->insererDepot($_GET["montant"], $_GET["date"]);

        Flight::redirect("animals");
    }
}