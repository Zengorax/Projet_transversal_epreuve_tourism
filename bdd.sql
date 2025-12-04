CREATE TABLE Type(
   Id_Type INT AUTO_INCREMENT,
   Type VARCHAR(60) ,
   PRIMARY KEY(Id_Type)
);

CREATE TABLE Pays(
   Id_Pays INT AUTO_INCREMENT,
   Nom VARCHAR(100) ,
   PRIMARY KEY(Id_Pays),
   UNIQUE(Nom)
);

CREATE TABLE Client(
   Id_Client INT AUTO_INCREMENT,
   Identifiant VARCHAR(100)  NOT NULL,
   Password TEXT,
   Nom VARCHAR(60) ,
   Prenom VARCHAR(60) ,
   Email VARCHAR(100) ,
   PRIMARY KEY(Id_Client),
   UNIQUE(Identifiant),
   UNIQUE(Email)
);

CREATE TABLE Statut(
   Id_Statut INT AUTO_INCREMENT,
   Statut VARCHAR(50) ,
   PRIMARY KEY(Id_Statut)
);

CREATE TABLE Ville(
   Id_Ville INT AUTO_INCREMENT,
   Nom VARCHAR(100) ,
   Id_Pays INT,
   PRIMARY KEY(Id_Ville),
   UNIQUE(Nom),
   FOREIGN KEY(Id_Pays) REFERENCES Pays(Id_Pays)
);

CREATE TABLE Circuit_Touristique(
   Id_Circuit_Touristique INT AUTO_INCREMENT,
   Image TEXT,
   Description TEXT,
   Duree_Circuit INT,
   Prix_Inscription DECIMAL(19,4),
   Nb_Places_Dispo INT,
   Date_Depart DATETIME,
   Id_Ville INT NOT NULL,
   Id_Ville_1 INT NOT NULL,
   PRIMARY KEY(Id_Circuit_Touristique),
   FOREIGN KEY(Id_Ville) REFERENCES Ville(Id_Ville),
   FOREIGN KEY(Id_Ville_1) REFERENCES Ville(Id_Ville)
);

CREATE TABLE Activitee(
   Id_Activitee INT AUTO_INCREMENT,
   Nom VARCHAR(100) ,
   Image TEXT,
   Description TEXT,
   Cout_Visite DECIMAL(19,4),
   Id_Type INT,
   Id_Ville INT NOT NULL,
   PRIMARY KEY(Id_Activitee),
   UNIQUE(Nom),
   FOREIGN KEY(Id_Type) REFERENCES Type(Id_Type),
   FOREIGN KEY(Id_Ville) REFERENCES Ville(Id_Ville)
);

CREATE TABLE Etape(
   Id_Etape INT AUTO_INCREMENT,
   Ordre INT,
   Date_ DATETIME,
   Duree INT,
   Id_Circuit_Touristique INT NOT NULL,
   Id_Activitee INT NOT NULL,
   PRIMARY KEY(Id_Etape),
   FOREIGN KEY(Id_Circuit_Touristique) REFERENCES Circuit_Touristique(Id_Circuit_Touristique),
   FOREIGN KEY(Id_Activitee) REFERENCES Activitee(Id_Activitee)
);

CREATE TABLE Reservation(
   Id_Reservation INT AUTO_INCREMENT,
   Date_Reservation DATETIME,
   Id_Statut INT,
   Id_Circuit_Touristique INT NOT NULL,
   Id_Client INT NOT NULL,
   PRIMARY KEY(Id_Reservation),
   FOREIGN KEY(Id_Statut) REFERENCES Statut(Id_Statut),
   FOREIGN KEY(Id_Circuit_Touristique) REFERENCES Circuit_Touristique(Id_Circuit_Touristique),
   FOREIGN KEY(Id_Client) REFERENCES Client(Id_Client)
);
