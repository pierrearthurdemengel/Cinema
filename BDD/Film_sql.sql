    -- a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
SELECT
    f.titre,
    f.annee,
    TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as temps_format,
    f.synopsis,
    f.note5,
    f.lien_affiche,
    p.nom,
    p.prenom,
    p.sexe,
    p.date_naissance
FROM
    film f
    INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
    INNER JOIN personne p ON r.personne_id = p.id_personne
WHERE
    f.id_film = 1
    
    
     -- b. Liste des films dont la durée excède 2h15 classés par durée (du plus long au plus court)
SELECT
    f.titre,
    f.annee,
    TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as temps_format,
    f.synopsis,
    f.note5,
    f.lien_affiche,
    p.nom,
    p.prenom,
    p.sexe,
    p.date_naissance
FROM
    film f
INNER JOIN 
	 realisateur r ON f.realisateur_id = r.id_realisateur
INNER JOIN 
	 personne p ON r.personne_id = p.id_personne
WHERE
    f.duree > 135 
ORDER BY 
	 temps_format DESC 
    
    -- c. Liste des films d’un réalisateur (en précisant l’année de sortie)
SELECT
    f.titre,
    f.annee,
    TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as temps_format,
    f.synopsis,
    f.note5,
    f.lien_affiche,
    p.nom,
    p.prenom,
    p.sexe,
    p.date_naissance
FROM
    film f
    INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
    INNER JOIN personne p ON r.personne_id = p.id_personne
WHERE
    r.id_realisateur = 2
    
    -- d. Nombre de films par genre (classés dans l’ordre décroissant)
SELECT
    g.nom_genre,
    COUNT(f.id_film) AS nb_films
FROM
    film f
    INNER JOIN appartenir a ON a.id_film = f.id_film
    INNER JOIN genre g ON a.id_genre = g.id_genre
GROUP BY
    g.id_genre
ORDER BY
    nb_films DESC;

-- e. Nombre de films par réalisateur (classés dans l’ordre décroissant)

SELECT
    p.nom,
    COUNT(f.id_film) AS nb_films
FROM
    realisateur r
    INNER JOIN film f ON r.id_realisateur = f.realisateur_id
    INNER JOIN personne p ON r.personne_id = p.id_personne
GROUP BY
    r.id_realisateur
ORDER BY
    nb_films DESC;

--  f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe 

 SELECT
    p.nom, 
	 p.prenom,
	 p.sexe 
FROM
    acteur a
    INNER JOIN personne p ON p.id_personne = a.personne_id
    INNER JOIN casting c ON a.id_acteur = c.acteur_id
    INNER JOIN film f ON c.film_id = f.id_film
WHERE f.id_film = 1

-- g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)

SELECT
	 f.titre,
	 f.annee,
	 r.nom_role
FROM
	 film f
INNER JOIN casting c ON f.id_film = c.film_id
INNER JOIN acteur a ON a.id_acteur = c.acteur_id
INNER JOIN personne p ON p.id_personne = a.personne_id
INNER JOIN role r ON r.id_role = c.role_id
WHERE 
	 a.id_acteur = 2
ORDER BY f.annee DESC 

-- h. Listes des personnes qui sont à la fois acteurs et réalisateurs

SELECT 
	 p.nom,
	 p.prenom
FROM 
	 personne p
INNER JOIN acteur a ON a.personne_id = p.id_personne
INNER JOIN realisateur r ON r.personne_id = p.id_personne

-- i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)
SELECT titre, annee 
FROM film 
WHERE annee <= 2018
ORDER BY annee DESC;

-- ou en mieux pour ne pas actualiser tous les ans

SELECT titre, annee 
FROM film 
WHERE YEAR(NOW()) - annee < 5
ORDER BY annee DESC;


-- j. Nombre d’hommes et de femmes parmi les acteurs

SELECT 
	COUNT(CASE WHEN sexe = 'H' THEN 1 END) AS "Nombre d'hommes", 
	COUNT(CASE WHEN sexe = 'F' THEN 1 END) AS "Nombre de femmes"
FROM personne p
	INNER JOIN acteur a ON a.id_acteur = p.id_personne

-- k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)

SELECT 
	 p.nom, 
	 p.prenom,
	 DATEDIFF(CURRENT_DATE, p.date_naissance) / 365 AS age
FROM 
	 personne p
INNER JOIN 
	 acteur a ON p.id_personne = a.personne_id
WHERE 
	 DATEDIFF(CURRENT_DATE, p.date_naissance) >= 50*365

--  l. Acteurs ayant joué dans 3 films ou plus

SELECT 
	 p.nom, 
    p.prenom,
    COUNT(*) AS "Nombre de film joué"
FROM 
	 casting c
INNER JOIN 
	 acteur a ON c.acteur_id = a.id_acteur
INNER JOIN 
	 personne p ON p.id_personne = a.personne_id
GROUP BY
	  a.id_acteur
HAVING COUNT(*) >= 3;
