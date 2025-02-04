<?php
namespace app\models;
use app\models\GestionElevageModel;
use Flight;

class DeleteModel 
{
    private $db;

    public function __construct($db) 
    {
        $this->db = $db;
    }

    public function deleteAll() {
        try {
            $this->db->beginTransaction();
    
            // Désactiver les contraintes de clés étrangères
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
            // Liste des tables à supprimer
            $tables = [
                "status_animal",
                "categorie_alimentation",
                "stock_alimentation",
                "transaction_animal",
                "animal_alimentation",
                "depot",
                "animal",
                "alimentation",
                "status",
                "categorie_animal"
            ];
    
            // Supprimer les données et réinitialiser l'auto-incrémentation
            foreach ($tables as $table) {
                $this->db->exec("DELETE FROM $table;");
                $this->db->exec("ALTER TABLE $table AUTO_INCREMENT = 1;");
            }
    
            // Réactiver les contraintes de clés étrangères
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
            $this->db->commit();
    
            return ["status" => "success", "message" => "Toutes les données ont été supprimées avec succès et les ID ont été réinitialisés."];
        } catch (\Exception $e) {
            return ["status" => "error", "message" => "Erreur lors de la suppression : " . $e->getMessage()];
        }
    }    
}