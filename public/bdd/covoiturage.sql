-- Création de la table des villes (Référentiel)
CREATE TABLE ville (
   idVille INT AUTO_INCREMENT,
   codePostale VARCHAR(10) NOT NULL,
   nomCommune VARCHAR(200) NOT NULL,
   PRIMARY KEY(idVille)
);

-- Table des rôles des utilisateurs (conducteur, passager, admin)
CREATE TABLE role (
   idRole INT AUTO_INCREMENT,
   nomRole ENUM('utilisateur', 'admin') NOT NULL UNIQUE,
   PRIMARY KEY(idRole)
);

-- Table des utilisateurs
CREATE TABLE utilisateur (
   idUtilisateur INT AUTO_INCREMENT,
   nom VARCHAR(200) NOT NULL,
   prenom VARCHAR(200) NOT NULL,
   email VARCHAR(200) NOT NULL UNIQUE,
   motDePasse VARCHAR(60) NOT NULL,
   idRole INT NOT NULL,
   idVille INT NOT NULL,
   idVoiture INT NULL,
   PRIMARY KEY(idUtilisateur),
   FOREIGN KEY(idRole) REFERENCES role(idRole),
   FOREIGN KEY(idVille) REFERENCES ville(idVille),
   FOREIGN KEY(idVoiture) REFERENCES voiture(idVoiture) ON DELETE SET NULL
);

-- Table des voitures
CREATE TABLE voiture (
   idVoiture INT AUTO_INCREMENT,
   marque VARCHAR(100) NOT NULL,
   modele VARCHAR(100) NOT NULL,
   immatriculation VARCHAR(50) UNIQUE NOT NULL,
   nbPlaces INT CHECK (nbPlaces > 0),
   PRIMARY KEY(idVoiture)
);

-- Table des trajets
CREATE TABLE trajet (
   idTrajet INT AUTO_INCREMENT,
   idConducteur INT NOT NULL,
   dateHeure DATETIME NOT NULL,
   idVilleDepart INT NOT NULL,
   idVilleArrivee INT NOT NULL,
   placesRestantes INT NOT NULL CHECK (placesRestantes >= 0),
   detailTrajet TEXT,
   PRIMARY KEY(idTrajet),
   FOREIGN KEY(idConducteur) REFERENCES utilisateur(idUtilisateur) ON DELETE CASCADE,
   FOREIGN KEY(idVilleDepart) REFERENCES ville(idVille),
   FOREIGN KEY(idVilleArrivee) REFERENCES ville(idVille)
);

-- Table des réservations
CREATE TABLE reservation (
   idReservation INT AUTO_INCREMENT,
   idUtilisateur INT NOT NULL,
   idTrajet INT NOT NULL,
   statut ENUM('en attente', 'confirmée', 'annulée') NOT NULL DEFAULT 'en attente',
   dateReservation DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(idReservation),
   FOREIGN KEY(idUtilisateur) REFERENCES utilisateur(idUtilisateur) ON DELETE CASCADE,
   FOREIGN KEY(idTrajet) REFERENCES trajet(idTrajet) ON DELETE CASCADE
);
