<?php

namespace app\models;

use Flight;

class alimentationModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Récupérer la liste complète des aliments disponibles en stock
    public function getAllAliments() {
        $stmt = $this->db->query("SELECT * FROM alimentation");
        return $stmt->fetchAll();
    }

    // Vérifier la quantité en stock pour un aliment spécifique
    public function getStockByAlimentId() {
        $stmt = $this->db->prepare("SELECT * FROM stock_alimentation");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Ajouter un nouvel aliment dans le stock
    public function addStock($id_alimentation, $qtt, $prix_unite, $date_achat) {
        $stmt = $this->db->prepare("INSERT INTO stock_alimentation (id_alimentation, qtt, prix_unite, date_achat) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_alimentation, $qtt, $prix_unite, $date_achat]);
    }

    // Mettre à jour la quantité d'un aliment en stock
    public function updateStock($id_alimentation, $qtt) {
        $stmt = $this->db->prepare("UPDATE stock_alimentation SET qtt = ? WHERE id_alimentation = ?");
        return $stmt->execute([$qtt, $id_alimentation]);
    }

    // Supprimer un aliment du stock
    public function deleteStock($id_alimentation) {
        $stmt = $this->db->prepare("DELETE FROM stock_alimentation WHERE id_alimentation = ?");
        return $stmt->execute([$id_alimentation]);
    }

    // Acheter une alimentation et l'ajouter au stock
    public function acheterAlimentation($id_alimentation, $qtt, $prix_unite) {
        $date_achat = date('Y-m-d');
        return $this->addStock($id_alimentation, $qtt, $prix_unite, $date_achat);
    }

    public function getMappedAlimentation()
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM alimentation");
        $stmt->execute();
        $alim = array();
        if($result = $stmt->fetchAll())
        {
            foreach ($result as $row) {
                $alim[$row['id']] = $row['nom']; 
            }
        }
        return $alim;
    }

    public function getAllAlimentation()
    {
        $stmt = $this->db->prepare("SELECT id, nom FROM alimentation");
        $stmt->execute();
        $alim = []; 
    
        if ($result = $stmt->fetchAll()) 
        {
            foreach ($result as $row) {
                $alim[] = [ 
                    'id' => $row['id'],
                    'nom' => $row['nom']
                ];
            }
        }
        return $alim; 
    }
    

    public function insererAlim($id_alimentation, $qtt, $date_achat, $prix_unite)
    {
        $stmt = $this->db->prepare("insert into stock_alimentation (id_alimentation, qtt, date_achat, prix_unite) values(
            ".$id_alimentation.",
            ".$qtt.",
            ".$date_achat.",
            ".$prix_unite."
        )");

        $stmt->execute();
    }

    public function insererCategAlim($nom, $pourcentage_gain)
    {
        $stmt = $this->db->prepare("insert into alimentation (nom, pourcentage_gain) values(
            ".$nom.",
            ".$gain.",
        )");

        $stmt->execute();

    }

    public function lierAlimAnimal($id_alimentation, $id_categorie_animal)
    {
        $stmt = $this->db->prepare("insert into categorie_alimentation (id_alimentation, id_categorie_animal) values(
            ".$id_alimentation.",
            ".$id_categorie_animal.",
        )");

        $stmt->execute(); 
    }
}
