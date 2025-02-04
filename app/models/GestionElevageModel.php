<?php

namespace app\models;

use Flight;

class GestionElevageModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtenir la situation des animaux à une date donnée
    public function getSituationElevage($date) {
        $stmt = $this->db->prepare("
            SELECT 
                a.id, 
                a.nom, 
                ca.nom AS categorie, 
                a.poid_de_base,
                a.photo,
                (SELECT sa.id_status 
                 FROM status_animal sa 
                 WHERE sa.id_animal = a.id AND sa.date_status <= ? 
                 ORDER BY sa.date_status DESC LIMIT 1) AS dernier_status,
                (SELECT SUM(al.pourcentage_gain * aa.quantite / 100) 
                 FROM animal_alimentation aa
                 JOIN categorie_alimentation caa ON aa.id_animal = a.id 
                 JOIN alimentation al ON caa.id_alimentation = al.id
                 WHERE aa.date_alimentation <= ? AND caa.id_categorie_animal = a.id_categorie) AS gain_poid
            FROM animal a
            JOIN categorie_animal ca ON a.id_categorie = ca.id
        ");
        $stmt->execute([$date, $date]);
        return $stmt->fetchAll();
    }

    // Obtenir les ventes de l'élevage à une date donnée
    public function getVentesElevage($date) {
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) AS nombre_ventes,
                SUM(ca.prix_de_vente) AS total_ventes
            FROM transaction_animal ta
            JOIN animal a ON ta.id_animal = a.id
            JOIN categorie_animal ca ON a.id_categorie = ca.id
            WHERE ta.date_transaction <= ?
        ");
        $stmt->execute([$date]);
        return $stmt->fetch();
    }

    // Obtenir les dépenses de l'élevage à une date donnée
    public function getDepensesElevage($date) {
        $stmt = $this->db->prepare("
            SELECT 
                SUM(sa.qtt * sa.prix_unite) AS total_depenses
            FROM stock_alimentation sa
            WHERE sa.date_achat <= ?
        ");
        $stmt->execute([$date]);
        return $stmt->fetch();
    }

    public function getTotalAchat($date) {
        $stmt = $this->db->prepare("  
            SELECT SUM(ca.prix_de_vente) AS total_achats 
            FROM transaction_animal ta
            JOIN animal a ON ta.id_animal = a.id
            JOIN categorie_animal ca ON a.id_categorie = ca.id
            WHERE ta.type = 0 AND ta.date_transaction <= ?
        ");
        $stmt->execute([$date]);
        
        $result = $stmt->fetch();
        return $result['total_achats'] ?? 0; // Retourne 0 si aucun achat trouvé
    }

    // Obtenir les gains de l'élevage à une date donnée
    public function getGainsElevage($date) {
        $stmt = $this->db->prepare("
            SELECT 
                SUM(al.pourcentage_gain * aa.quantite / 100) AS total_gains
            FROM animal_alimentation aa
            JOIN animal a ON aa.id_animal = a.id
            JOIN categorie_alimentation caa ON a.id_categorie = caa.id_categorie_animal
            JOIN alimentation al ON caa.id_alimentation = al.id
            WHERE aa.date_alimentation <= ?
        ");
        $stmt->execute([$date]);
        return $stmt->fetch()['total_gains'];
    }    

    // Obtenir une conclusion sur la rentabilité de l'élevage
    public function getConclusionElevage($date) {
        $ventes = $this->getVentesElevage($date);
        $depenses = $this->getDepensesElevage($date);
        $gains = $this->getGainsElevage($date);

        $total_ventes = $ventes['total_ventes'];
        $total_depenses = $depenses['total_depenses'];
        $total_gains = $gains;

        // Calculer si l'élevage est rentable ou non
        $rentabilite = ($total_ventes + $total_gains) - $total_depenses;

        // Retourner une conclusion basée sur la rentabilité
        if ($rentabilite > 0) {
            return "L'élevage est rentable avec un bénéfice de " . $rentabilite . "€.";
        } else {
            return "L'élevage n'est pas rentable, une perte de " . abs($rentabilite) . "€ a été enregistrée.";
        }
    }

    // Obtenir l'historique des transactions pour un éleveur à une date donnée
    public function getHistoriqueTransactions() {
        $stmt = $this->db->prepare("
            SELECT 
                ta.id AS transaction_id,
                a.nom AS animal_nom,
                ca.nom AS categorie_animal,
                ta.type AS transaction_type,
                ta.date_transaction,
                a.poid_de_base,
                CASE
                    WHEN ta.type = 1 THEN ca.prix_de_vente  -- Si c'est une vente, le montant est le prix de vente
                    ELSE 0  -- Pour d'autres types de transaction, mettre le montant à 0 (ou autre logique si nécessaire)
                END AS montant_transaction
            FROM transaction_animal ta
            JOIN animal a ON ta.id_animal = a.id
            JOIN categorie_animal ca ON a.id_categorie = ca.id
            WHERE ta.date_transaction <= NOW() 
            ORDER BY ta.date_transaction DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }    
    
}

?>