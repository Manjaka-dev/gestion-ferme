<?php

namespace app\controllers;

use app\models\AnimalModel;
use Flight;

class GestionAnimalController {

    public function getAnimalSpec()  {
        $animal = new AnimalModel();

        $id = $_GET['id'];
        $animalSpec = $animal->getAnimalSpecificity($id);
        $data = [
            'animalSpec' => $animalSpec
        ];
        Flight::render('dertail-animal', $data);
    }
	
}