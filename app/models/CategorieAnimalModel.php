<?php
namespace app\Models;

use Flight;

final class CategorieAnimalModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM categorie_animal";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertCateg(
            $nom, 
            $poid_min,
            $poid_max,
            $taux_perte_poid,
            $prix_de_vente,
            $nb_jour_sans_manger
        )
    {
        $stmt = $this->db->prepare("
            INSERT INTO categorie_animal (nom,poid_min, poid_max, taux_perte_poid, prix_de_vente, nb_jour_sans_manger)
            VALUES (
                '".$nom."',
                ".$poid_min.",
                ".$poid_max.",
                ".$taux_perte_poid.",
                ".$prix_de_vente.",
                ".$nb_jour_sans_manger."
            )
        ");
        $stmt->execute();
    }

    public function updateCateg(
        $id,
        $nom, 
        $poid_min,
        $poid_max,
        $taux_perte_poid,
        $prix_de_vente,
        $nb_jour_sans_manger
    )
    {
        $stmt = $this->db->prepare("
            UPDATE categorie_animal SET 
                nom = '".$nom."',
                poid_min = ".$poid_min.",
                poid_max = ".$poid_max.",
                taux_perte_poid = ".$taux_perte_poid.",
                prix_de_vente = ".$prix_de_vente.",
                nb_jour_sans_manger = ".$nb_jour_sans_manger." WHERE id = ".$id."
            ");
        $stmt->execute();
    }
}
