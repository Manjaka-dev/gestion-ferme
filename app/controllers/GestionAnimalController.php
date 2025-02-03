<?php

namespace app\controllers;

use app\models\AnimalModel;
use Flight;

class GestionAnimalController {

    public function getAnimalSpec()  {
        $animal = new AnimalModel(Flight::db());

        $id = $_GET['id'];
        $animalSpec = $animal->getAnimalSpecificity($id);
        $data = [
            'animalSpec' => $animalSpec
        ];
        Flight::render('dertail-animal', $data);
    }

    public function getFormulaireChoixanimal()  {
        $animal = new AnimalModel(Flight::db());

        $animals = $animal->getAll();

        $data = [
            'animals' => $animals
        ];

        Flight::render('choix-animal', $data);
    }

    public function nourrirAnimal()  {
        $animal = new AnimalModel(Flight::db());

        $ids = $_POST['id'];
        $qtts = $_POST['qtt'];
        $count = 0;

        foreach ($ids as $id) {
            $qtt = $qtts[$id];
            if ($animal->nourirAnimal($id, $qtt)) {
                $count++;
            }
        }
        if ($count == count($ids)) {
            Flight::redirect('/animal/choix');
        } else {
            Flight::redirect('/animal/choix');
        }
    }
	
}