CREATE EVENT verifier_vente_auto_quotidien
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_DATE + INTERVAL 10 HOUR)
DO
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE animal_id INT;

    -- Curseur pour parcourir tous les animaux en auto-vente
    DECLARE cur CURSOR FOR
        SELECT id FROM animal WHERE auto_vente = 1;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    boucle_animaux: LOOP
        FETCH cur INTO animal_id;

        IF done THEN
            LEAVE boucle_animaux;
        END IF;

        -- Appel de la fonction pour vérifier la vente automatique
        CALL verifierVenteAuto(animal_id, CURRENT_DATE);
    END LOOP;

    CLOSE cur;
END;

CREATE EVENT nourrir_animaux_quotidien
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_DATE + INTERVAL 8 HOUR)
DO
  CALL nourrirAnimaux(CURRENT_DATE);
