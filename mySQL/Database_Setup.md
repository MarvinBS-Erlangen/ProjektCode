-- Erstellen einer neuen Datenbank
CREATE DATABASE IF NOT EXISTS MacAPPLE_DB;
USE MacAPPLE_DB;

-- Tabelle für Adressen
CREATE TABLE Adresse (
    AdresseID INT AUTO_INCREMENT PRIMARY KEY,
    Strasse VARCHAR(100),
    Hausnummer VARCHAR(10),
    Postleitzahl VARCHAR(10),
    Stadt VARCHAR(50),
    Land VARCHAR(50)
);

-- Tabelle für Kunden
CREATE TABLE Kunde (
    KundenID INT AUTO_INCREMENT PRIMARY KEY,
    Vorname VARCHAR(50) NOT NULL,
    Nachname VARCHAR(50) NOT NULL,
    EMail VARCHAR(100) UNIQUE NOT NULL,
    Hash_Password VARCHAR(255) NOT NULL,
    Telefon VARCHAR(20),
    AdresseID INT,
    FOREIGN KEY (AdresseID) REFERENCES Adresse(AdresseID)
);

-- Tabelle für Produkte
CREATE TABLE Produkt (
    ProduktID INT AUTO_INCREMENT PRIMARY KEY,
    Produktname VARCHAR(100) NOT NULL,
    Beschreibung TEXT,
    Preis DECIMAL(10, 2) NOT NULL,
    Energiewert INT
);

-- Tabelle für Zutaten
CREATE TABLE Zutat (
    ZutatID INT AUTO_INCREMENT PRIMARY KEY,
    Zutatenname VARCHAR(100) NOT NULL,
    Beschreibung TEXT
);

-- Zwischentabelle für Produkt-Zutat Beziehung
CREATE TABLE Produkt_Zutat (
    ProduktID INT,
    ZutatID INT,
    PRIMARY KEY (ProduktID, ZutatID),
    FOREIGN KEY (ProduktID) REFERENCES Produkt(ProduktID) ON DELETE CASCADE,
    FOREIGN KEY (ZutatID) REFERENCES Zutat(ZutatID) ON DELETE CASCADE
);

-- Tabelle für Menüs
CREATE TABLE Menue (
    MenueID INT AUTO_INCREMENT PRIMARY KEY,
    Menuename VARCHAR(100) NOT NULL,
    Beschreibung TEXT,
    Preis DECIMAL(10, 2) NOT NULL
);

-- Zwischentabelle für Menü-Produkt Beziehung
CREATE TABLE Menue_Produkt (
    MenueID INT,
    ProduktID INT,
    PRIMARY KEY (MenueID, ProduktID),
    FOREIGN KEY (MenueID) REFERENCES Menue(MenueID) ON DELETE CASCADE,
    FOREIGN KEY (ProduktID) REFERENCES Produkt(ProduktID) ON DELETE CASCADE
);

-- Tabelle für Bestellungen
CREATE TABLE Bestellung (
    BestellID INT AUTO_INCREMENT PRIMARY KEY,
    KundenID INT,
    Bestelldatum DATETIME NOT NULL,
    Gesamtbetrag DECIMAL(10, 2) NOT NULL,
    LieferadresseID INT,
    Zahlungsart VARCHAR(50),
    FOREIGN KEY (KundenID) REFERENCES Kunde(KundenID),
    FOREIGN KEY (LieferadresseID) REFERENCES Adresse(AdresseID)
);

-- Tabelle für Bestellposten von Produkten
CREATE TABLE Bestellposten_Produkt (
    BestellID INT,
    ProduktID INT,
    Menge INT,
    PRIMARY KEY (BestellID, ProduktID),
    FOREIGN KEY (BestellID) REFERENCES Bestellung(BestellID) ON DELETE CASCADE,
    FOREIGN KEY (ProduktID) REFERENCES Produkt(ProduktID) ON DELETE CASCADE
);

-- Tabelle für Bestellposten von Menüs
CREATE TABLE Bestellposten_Menue (
    BestellID INT,
    MenueID INT,
    Menge INT,
    PRIMARY KEY (BestellID, MenueID),
    FOREIGN KEY (BestellID) REFERENCES Bestellung(BestellID) ON DELETE CASCADE,
    FOREIGN KEY (MenueID) REFERENCES Menue(MenueID) ON DELETE CASCADE
);

-- Tabelle für Rechnungen
CREATE TABLE Rechnung (
    RechnungsID INT AUTO_INCREMENT PRIMARY KEY,
    BestellID INT,
    Rechnungsdatum DATETIME NOT NULL,
    Betrag DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (BestellID) REFERENCES Bestellung(BestellID)
);

-- Tabelle für Admins
CREATE TABLE Admin (
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    Benutzername VARCHAR(50) UNIQUE NOT NULL,
    Passwort_Hash VARCHAR(255) NOT NULL
);

-- Tabelle für Bilder (Funny-Dinner-Contest)
CREATE TABLE Bild (
    BildID INT AUTO_INCREMENT PRIMARY KEY,
    KundenID INT,
    Bilddatei VARCHAR(255) NOT NULL,
    Titel VARCHAR(100),
    Hochladedatum DATETIME NOT NULL,
    Freigabestatus BOOLEAN DEFAULT FALSE,
    AdminID INT,
    FOREIGN KEY (KundenID) REFERENCES Kunde(KundenID) ON DELETE CASCADE,
    FOREIGN KEY (AdminID) REFERENCES Admin(AdminID) ON DELETE SET NULL
);

-- Tabelle für Bewertungen (Funny-Dinner-Contest)
CREATE TABLE Bewertung (
    BewertungsID INT AUTO_INCREMENT PRIMARY KEY,
    BildID INT,
    KundenID INT,
    Bewertungspunkte INT CHECK (Bewertungspunkte BETWEEN 1 AND 5),
    Bewertungsdatum DATETIME NOT NULL,
    FOREIGN KEY (BildID) REFERENCES Bild(BildID) ON DELETE CASCADE,
    FOREIGN KEY (KundenID) REFERENCES Kunde(KundenID) ON DELETE CASCADE
);
