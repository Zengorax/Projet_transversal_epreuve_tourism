3
SELECT  description, date_depart COUNT( etape)
FROM circuit_touristique
WHERE circuit_touristique.id = 7

4
DELETE FROM lieu_touristique
WHERE type_lieu NOT IN (etape)

5
SELECT SUM (prix_inscription) AS prix_total
FROM circuit_touristique
JOIN etape ON circuit_touristique = etape.circuit


6
INSERT INTO reservation (client, circuit_touristique, date_reservation)
VALUES (nom, prenom, identidiant, email)


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
SELECT nom
FROM lieu_touristique
WHERE id_type_lieu

10 
SELECT circuit_touristique.id
MIN(duree_)
MAX(date_)
FROM etape
GROUP BY circuit_touristique.id