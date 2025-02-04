CREATE FUNCTION getPoidAnimal(animal_id INT, date_calc DATE) 
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE poid_base DECIMAL(10,2);
    DECLARE gain_pourcentage INT;
    DECLARE perte_pourcentage INT;
    DECLARE jours_nourri INT DEFAULT 0;
    DECLARE quantite_nourriture DECIMAL(10,2) DEFAULT 0;
    DECLARE date_achat DATE;
    DECLARE duree_total INT DEFAULT 0;
    DECLARE poid_gagne DECIMAL(10,2);
    DECLARE poid_perdu DECIMAL(10,2);
    DECLARE poid_final DECIMAL(10,2);
    
    -- 1. Récupérer le poids de base, le taux de gain et de perte
    SELECT a.poid_de_base, al.pourcentage_gain, ca.taux_perte_poid
    INTO poid_base, gain_pourcentage, perte_pourcentage
    FROM animal AS a
    JOIN categorie_animal AS ca ON a.id_categorie = ca.id
    JOIN categorie_alimentation AS cal ON ca.id = cal.id_categorie_animal
    JOIN alimentation AS al ON cal.id_alimentation = al.id
    WHERE a.id = animal_id
    LIMIT 1;

    -- 2. Compter le nombre de jours où l'animal a été nourri avant la date donnée
    SELECT IFNULL(COUNT(*), 0), IFNULL(SUM(quantite), 0)
    INTO jours_nourri, quantite_nourriture
    FROM animal_alimentation
    WHERE id_animal = animal_id AND date_alimentation < date_calc;

    -- 3. Obtenir la date d'achat (première transaction de type 0)
    SELECT MIN(date_transaction)
    INTO date_achat
    FROM transaction_animal
    WHERE id_animal = animal_id AND type = 0;

    -- Si pas de date d'achat, retourner NULL
    IF date_achat IS NULL THEN
        RETURN NULL;
    END IF;

    -- 4. Calcul de la durée totale entre l'achat et la date de calcul
    SET duree_total = DATEDIFF(date_calc, date_achat);

    -- 5. Calcul du poids gagné et perdu
    SET poid_gagne = (poid_base * gain_pourcentage * jours_nourri) / 100;
    SET poid_perdu = (poid_base * perte_pourcentage * (duree_total - jours_nourri)) / 100;

    -- 6. Poids final
    SET poid_final = poid_base + poid_gagne - poid_perdu;

    -- 7. Retourner le poids final (au moins 0)
    RETURN IF(poid_final < 0, 0, poid_final);
END;


CREATE FUNCTION verifierVenteAuto(animal_id INT, date_verif DATE)
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    DECLARE auto_vente_flag TINYINT(1);
    DECLARE poid_actuel DECIMAL(10,2);
    DECLARE poid_min DECIMAL(10,2);
    DECLARE id_status_vendu INT;

    -- 1. Vérifier si l'animal est en vente automatique et récupérer son poids minimal
    SELECT a.auto_vente, ca.poid_min
    INTO auto_vente_flag, poid_min
    FROM animal AS a
    JOIN categorie_animal AS ca ON a.id_categorie = ca.id
    WHERE a.id = animal_id;

    -- Si l'animal n'est pas en auto-vente, ne rien faire
    IF auto_vente_flag = 0 THEN
        RETURN 'L\'animal n\'est pas en vente automatique.';
    END IF;

    -- 2. Calculer le poids actuel de l'animal
    SET poid_actuel = getPoidAnimal(animal_id, date_verif);

    -- 3. Vérifier si le poids est suffisant pour la vente
    IF poid_actuel >= poid_min THEN
        -- Obtenir l'ID du statut "Vendu"
        SELECT id INTO id_status_vendu FROM status WHERE nom = 'Vendu' LIMIT 1;

        -- 4. Ajouter une transaction de vente
        INSERT INTO transaction_animal (id_animal, type, date_transaction)
        VALUES (animal_id, 1, date_verif);

        -- 5. Mettre à jour le statut de l'animal à "Vendu"
        UPDATE status_animal
        SET id_status = id_status_vendu, date_status = date_verif
        WHERE id_animal = animal_id;

        RETURN CONCAT('Animal ID ', animal_id, ' vendu le ', date_verif, '.');
    ELSE
        RETURN 'Poids insuffisant pour la vente automatique.';
    END IF;
END;


CREATE PROCEDURE nourrirAnimaux(IN date_nourrissage DATE)
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE animal_id INT;
    DECLARE aliment_id INT;
    DECLARE quantite_stock DECIMAL(10,2);
    DECLARE quota_journalier INT DEFAULT 1;

    -- Curseur pour récupérer les animaux à nourrir, priorisés par date de mise en vente
    DECLARE cur_animaux CURSOR FOR
        SELECT a.id, ca.id_alimentation
        FROM animal a
        JOIN categorie_alimentation ca ON a.id_categorie = ca.id_categorie_animal
        LEFT JOIN stock_alimentation sa ON ca.id_alimentation = sa.id_alimentation
        WHERE NOT EXISTS (
            SELECT 1 FROM animal_alimentation aa 
            WHERE aa.id_animal = a.id AND aa.date_alimentation = date_nourrissage
        )
        ORDER BY a.date_mise_en_vente ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur_animaux;

    boucle_animaux: LOOP
        FETCH cur_animaux INTO animal_id, aliment_id;

        IF done THEN
            LEAVE boucle_animaux;
        END IF;

        -- Vérification du stock disponible pour l'aliment de l'animal
        SELECT COALESCE(SUM(qtt), 0) INTO quantite_stock
        FROM stock_alimentation
        WHERE id_alimentation = aliment_id;

        IF quantite_stock >= quota_journalier THEN
            -- Enregistrement de l'alimentation de l'animal
            INSERT INTO animal_alimentation (id_animal, date_alimentation, quantite)
            VALUES (animal_id, date_nourrissage, quota_journalier);

            -- Mise à jour du stock (on consomme l'aliment)
            UPDATE stock_alimentation
            SET qtt = qtt - quota_journalier
            WHERE id_alimentation = aliment_id
            AND qtt > 0
            LIMIT 1;  -- Consommer d’un stock à la fois
        END IF;
    END LOOP;

    CLOSE cur_animaux;
END ;




CREATE FUNCTION predire_stock_alimentation(date_prevision DATE)
RETURNS TEXT
DETERMINISTIC
BEGIN
    DECLARE cur_date DATE DEFAULT CURRENT_DATE;
    DECLARE jours INT DEFAULT DATEDIFF(date_prevision, cur_date);
    DECLARE done INT DEFAULT 0;
    DECLARE animal_id INT;
    DECLARE quota_journalier DECIMAL(10,2);
    DECLARE poid_min DECIMAL(10,2);
    DECLARE perte_poids INT;
    DECLARE poids DECIMAL(10,2);
    DECLARE pourcentage_gain INT;
    DECLARE auto_vente TINYINT;
    DECLARE date_vente DATE;
    DECLARE statut VARCHAR(50);
    DECLARE stock_dispo DECIMAL(10,2);
    DECLARE id_alimentation INT;
    DECLARE resume TEXT DEFAULT '';

    -- Curseur pour parcourir les animaux en bonne santé
    DECLARE cur_animaux CURSOR FOR
        SELECT a.id, a.quota_nourriture_journalier, ca.poid_min, ca.taux_perte_poid, a.auto_vente, a.date_mise_en_vente, a.poid_de_base, al.pourcentage_gain
        FROM animal a
        JOIN categorie_animal ca ON a.id_categorie = ca.id
        JOIN categorie_alimentation cal ON ca.id = cal.id_categorie_animal
        JOIN alimentation al ON cal.id_alimentation = al.id
        JOIN status_animal sa ON a.id = sa.id_animal
        WHERE sa.id_status = (SELECT id FROM status WHERE nom = 'Bonne Santé')
        ORDER BY a.date_mise_en_vente ASC, a.auto_vente DESC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur_animaux;

    boucle_animaux: LOOP
        FETCH cur_animaux INTO animal_id, quota_journalier, poid_min, perte_poids, auto_vente, date_vente, poids, pourcentage_gain;

        IF done THEN
            LEAVE boucle_animaux;
        END IF;

        SET cur_date = CURRENT_DATE;

        -- Simulation jour par jour
        WHILE cur_date <= date_prevision DO
            -- Vérifie la disponibilité de la nourriture
            SELECT id, qtt INTO id_alimentation, stock_dispo
            FROM stock_alimentation
            WHERE qtt > 0
            ORDER BY date_achat ASC
            LIMIT 1;

            IF stock_dispo >= quota_journalier THEN
                -- Consommer la nourriture
                UPDATE stock_alimentation
                SET qtt = qtt - quota_journalier
                WHERE id = id_alimentation;

                -- Gain de poids en fonction du pourcentage de gain
                SET poids = poids + (poids * (pourcentage_gain / 100));
            ELSE
                -- Perte de poids si non nourri
                SET poids = poids - (poids * perte_poids / 100);
            END IF;

            -- Vérifie si l'animal doit être vendu automatiquement
            IF auto_vente = 1 AND poids >= poid_min THEN
                INSERT INTO transaction_animal (id_animal, type, date_transaction)
                VALUES (animal_id, 1, cur_date);
                
                UPDATE status_animal
                SET id_status = (SELECT id FROM status WHERE nom = 'Vendu')
                WHERE id_animal = animal_id;
                
                LEAVE boucle_animaux; -- Arrête de nourrir un animal vendu
            END IF;

            SET cur_date = DATE_ADD(cur_date, INTERVAL 1 DAY);
        END WHILE;

        -- Résumé des prédictions
        SET resume = CONCAT(resume, 'Animal ID: ', animal_id, ', Poids prévu: ', poids, ', Statut: ',
                            (SELECT nom FROM status WHERE id = 
                                (SELECT id_status FROM status_animal WHERE id_animal = animal_id LIMIT 1)
                            ), '\n');
    END LOOP;

    CLOSE cur_animaux;

    RETURN resume;
END ;
