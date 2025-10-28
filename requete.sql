3
SELECT description, date_depart COUNT( etape)
FROM circuit_touristique
WHERE circuit_touristique.id = 7

4
DELETE FROM lieu_touristique
WHERE type_lieu NOT IN (etape)

5
SELECT SUM (prix_inscription) AS prix_total
FROM circuit_touristique
JOIN etape ON circuit_touristique = etape.circuit
GROUP BY 

6
INSERT INTO reservation ()
VALUES ()


7
SELECT nom, prenom,
COUNT( reservation.id) AS nombre_reservations
FROM client
JOIN reservations ON client.id =  reservation.id
GROUP BY client.id


8
SELECT client.id
FROM reservations
WHERE date_reservation LIKE '%2024%' 

9
SELECT Nom
FROM lieu_touristique
WHERE id_Type_Lieu

10 
