<?php
namespace app\controllers;

use app\models\CategorieAnimalModel;

use Flight;

class CategorieAnimalController 
{

    public function goToListCateg()
    {
        $categorie = $this->getAll();
        Flight::render('page', ['view' => 'list-categ', 'categorie' => $categorie]);
    }

    public function getAll()
    {
        $catM = new CategorieAnimalModel(Flight::db());
        return $catM->getAll();
    }

    public function goToCateg()
    {
        Flight::render('page',['view' => 'insert-categ']);
    }

    public function insertCateg()
    {
        $catM = new CategorieAnimalModel(Flight::db());
        $catM->insertCateg(
            $_POST["nom"], 
            $_POST["poid_min"],
            $_POST["poid_max"],
            $_POST["taux_perte_poid"],
            $_POST["prix_de_vente"],
            $_POST["nb_jour_sans_manger"]
        );

        Flight::redirect("animals");
    }

    public function updateCateg()
    {
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $poid_min = $_POST["poid_min"];
        $poid_max = $_POST["poid_max"];
        $taux_perte_poid = $_POST["taux_perte_poid"];
        $prix_vente = $_POST["prix_de_vente"];
        $nb_jour_sans_manger = $_POST["nb_jour_sans_manger"];

        $catM = new CategorieAnimalModel(Flight::db());
        for($i = 0; $i < count($id); $i++)
        {
            $catM->updateCateg(
                $nom[$i], 
                $poid_min[$i],
                $poid_max[$i],
                $taux_perte_poid[$i],
                $prix_de_vente[$i],
                $nb_jour_sans_manger[$i]
            );
        }

        Flight::redirect("listCateg");
    }
}