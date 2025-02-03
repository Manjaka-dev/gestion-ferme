-- Désactiver temporairement les vérifications des contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Suppression des tables dépendantes
DROP TABLE IF EXISTS transaction_animal;
DROP TABLE IF EXISTS animal_alimentation;
DROP TABLE IF EXISTS status_animal;
DROP TABLE IF EXISTS stock_alimentation;
DROP TABLE IF EXISTS categorie_alimentation;

-- Suppression des tables principales
DROP TABLE IF EXISTS animal;
DROP TABLE IF EXISTS status;
DROP TABLE IF EXISTS categorie_animal;
DROP TABLE IF EXISTS alimentation;

-- Réactiver les vérifications des contraintes de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;
