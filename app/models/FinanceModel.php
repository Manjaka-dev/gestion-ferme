<?php
namespace app\models;
use app\models\GestionElevageModel;
use Flight;

class FinanceModel 
{
    private $db;

    public function __construct($db) 
    {
        $this->db = $db;
    }

    public function getPremierDepot() {
        $stmt = $this->db->prepare("
            SELECT montantDepot 
            FROM depot 
            ORDER BY dateDepot ASC, id ASC 
            LIMIT 1
        ");
        $stmt->execute();
        $result = $stmt->fetch();
    
        return $result ? $result['montantDepot'] : 0;
    }
    
    public function insererDepot($montant, $date) {
        $stmt = $this->db->prepare("
            INSERT INTO depot (montantDepot, dateDepot) 
            VALUES (:montant, :date)
        ");
        return $stmt->execute([
            ':montant' => $montant,
            ':date' => $date
        ]);
    }

    public function getSolde($date)
    {
        $gestionEl = new GestionElevageModel(Flight::db());
        $ventes = $gestionEl->getVentesElevage($date);
        $totalPrixDeVente = $ventes["total_ventes"];
        $totalDepenses = $gestionEl->getDepensesElevage($date);
        $totalAchat= $gestionEl->getTotalAchat($date);
        $capital = $this->getPremierDepot();

        return $capital + $totalPrixDeVente - ($totalDepenses["total_depenses"] + $totalAchat);
    }
}