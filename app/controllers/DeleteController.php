<?php

namespace app\controllers;

use app\models\DeleteModel;


use Flight;

class DeleteController {

    public function reset()
    {
        $deleteMode = new DeleteModel(Flight::db());
        $result = $deleteMode->deleteAll();
        Flight::render("page", ['view' => 'list-animal']);
    }

}
?>