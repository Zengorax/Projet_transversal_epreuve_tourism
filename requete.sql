3
SELECT CONCAT(
    'Information sur le circuit ', c.Id_Circuit_Touristique, ' : ',
    c.Description, ', ',
    v_dep.Nom, ', ',
    v_arr.Nom, ', ',
    COUNT(e.Id_Etape), ' étapes.'
) AS message
FROM Circuit_Touristique c
JOIN Ville v_dep ON c.Id_Ville   = v_dep.Id_Ville
JOIN Ville v_arr ON c.Id_Ville_1 = v_arr.Id_Ville
LEFT JOIN Etape e ON c.Id_Circuit_Touristique = e.Id_Circuit_Touristique
WHERE c.Id_Circuit_Touristique = 7
GROUP BY c.Id_Circuit_Touristique, c.Description, v_dep.Nom, v_arr.Nom;

4
DELETE a
FROM Activitee a
LEFT JOIN Etape e ON a.Id_Activitee = e.Id_Activitee
WHERE e.Id_Activitee IS NULL;

5
SELECT
    c.Id_Circuit_Touristique,
    c.Description,
    c.Prix_Inscription,
    COALESCE(SUM(a.Cout_Visite), 0) AS total_visites,
    c.Prix_Inscription + COALESCE(SUM(a.Cout_Visite), 0) AS prix_circuit_complet
FROM Circuit_Touristique c
LEFT JOIN Etape e
       ON c.Id_Circuit_Touristique = e.Id_Circuit_Touristique
LEFT JOIN Activitee a
       ON e.Id_Activitee = a.Id_Activitee
WHERE c.Id_Circuit_Touristique = 7
GROUP BY c.Id_Circuit_Touristique, c.Description, c.Prix_Inscription;



6
INSERT INTO Reservation (Date_Reservation, Id_Statut, Id_Circuit_Touristique, Id_Client)
VALUES (NOW(), 1, 7, 3);


7
SELECT
    c.Nom,
    c.Prenom,
    COUNT(r.Id_Reservation) AS nb_reservations
FROM Client c
LEFT JOIN Reservation r ON c.Id_Client = r.Id_Client
GROUP BY c.Id_Client, c.Nom, c.Prenom;


8
SELECT
    c.Nom,
    c.Prenom
FROM Client c
LEFT JOIN Reservation r
    ON c.Id_Client = r.Id_Client
   AND r.Date_Reservation >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
   AND r.Date_Reservation < CURDATE()
WHERE r.Id_Reservation IS NULL;

9
SELECT
    c.Id_Circuit_Touristique,
    c.Description
FROM Circuit_Touristique c
LEFT JOIN Reservation r
       ON c.Id_Circuit_Touristique = r.Id_Circuit_Touristique
      AND r.Id_Statut IN (1, 2)   -- par ex. 1 = validée, 2 = en cours
WHERE c.Date_Depart > NOW()
GROUP BY c.Id_Circuit_Touristique, c.Description, c.Nb_Places_Dispo
HAVING c.Nb_Places_Dispo > COUNT(r.Id_Reservation);

10 
SELECT
    c.Id_Circuit_Touristique,
    c.Description,
    c.Duree_Circuit                         AS nb_joursannonces,
    MIN(e.Date)                             AS date_debut_min,
    MAX(DATEADD(e.Date, INTERVAL e.Duree DAY)) AS date_fin_max
FROM Circuit_Touristique c
LEFT JOIN Etape e
       ON c.Id_Circuit_Touristique = e.Id_Circuit_Touristique
GROUP BY
    c.Id_Circuit_Touristique,
    c.Description,
    c.Duree_Circuit;