# Verwendung der MacAPPLE_DB Datenbank
USE MacAPPLE_DB;

# Einfügen von Daten in die Tabelle Adresse
INSERT INTO Adresse (Straße, Hausnummer, Postleitzahl, Stadt, Land) VALUES
('Hauptstraße', '1', '10115', 'Berlin', 'Deutschland'),
('Bahnhofstraße', '5', '80335', 'München', 'Deutschland'),
('Marktplatz', '10', '20095', 'Hamburg', 'Deutschland');

# Einfügen von Daten in die Tabelle Kunde
INSERT INTO Kunde (Vorname, Nachname, EMail, Telefon, AdresseID) VALUES
('Max', 'Mustermann', 'max.mustermann@example.com', '0123456789', 1),
('Erika', 'Musterfrau', 'erika.musterfrau@example.com', '0987654321', 2),
('Hans', 'Schmidt', 'hans.schmidt@example.com', '0112233445', 3);

# Einfügen von Daten in die Tabelle Admin
INSERT INTO Admin (Benutzername, Passwort) VALUES
('admin1', 'hashedpassword1'),
('admin2', 'hashedpassword2');

# Einfügen von Daten in die Tabelle Produkt
INSERT INTO Produkt (Produktname, Beschreibung, Preis, Energiewert) VALUES
('Classic Burger', 'Ein klassischer Rindfleischburger.', 5.99, 650),
('Veggie Burger', 'Leckerer vegetarischer Burger.', 6.49, 550),
('Pommes Frites', 'Knusprige goldgelbe Pommes.', 2.99, 300),
('Süßkartoffel-Pommes', 'Gesunde Süßkartoffel-Pommes.', 3.49, 350),
('Chicken Nuggets', 'Goldene Hähnchen-Nuggets.', 4.99, 450),
('Caesar Salat', 'Frischer Salat mit Dressing.', 4.49, 200);

# Einfügen von Daten in die Tabelle Zutat
INSERT INTO Zutat (Zutatenname, Beschreibung) VALUES
('Rindfleisch', 'Frisches Rindfleisch-Pattie.'),
('Burger Brötchen', 'Sesambrötchen, frisch gebacken.'),
('Salat', 'Knackiger grüner Salat.'),
('Tomate', 'Frische Tomatenscheiben.'),
('Käse', 'Geschmolzener Cheddar-Käse.'),
('Hähnchenfleisch', 'Zartes Hähnchenfleisch.'),
('Süßkartoffeln', 'Frische Süßkartoffeln.');

# Einfügen von Daten in die Tabelle Produkt_Zutat
## Classic Burger Zutaten
INSERT INTO Produkt_Zutat (ProduktID, ZutatID) VALUES
(1,2), -- Burger Brötchen
(1,1), -- Rindfleisch
(1,3), -- Salat
(1,4), -- Tomate
(1,5); -- Käse

## Veggie Burger Zutaten
INSERT INTO Produkt_Zutat (ProduktID, ZutatID) VALUES
(2,2), -- Burger Brötchen
(2,3), -- Salat
(2,4), -- Tomate
(2,5); -- Käse

## Pommes Frites Zutaten
INSERT INTO Produkt_Zutat (ProduktID, ZutatID) VALUES
(3, '8'); -- Standard Kartoffeln (angenommen ZutatID 8)

## Süßkartoffel-Pommes Zutaten
INSERT INTO Produkt_Zutat (ProduktID, ZutatID) VALUES
(4,7); -- Süßkartoffeln

## Einfügen von Daten in die Tabelle Menü
INSERT INTO Menü (Menüname, Beschreibung, Preis) VALUES
('Classic Menü', 'Classic Burger mit Pommes und Getränk.', 9.99),
('Veggie Menü', 'Veggie Burger mit Süßkartoffel-Pommes und Getränk.', 10.49),
('Family Box', 'Assortment von Produkten für die ganze Familie.', 19.99);

# Einfügen von Daten in die Tabelle Menü_Produkt
## Classic Menü
INSERT INTO Menü_Produkt (MenüID, ProduktID) VALUES
(1,1), -- Classic Burger
(1,3); -- Pommes Frites

## Veggie Menü
INSERT INTO Menü_Produkt (MenüID, ProduktID) VALUES
(2,2), -- Veggie Burger
(2,4); -- Süßkartoffel-Pommes

## Family Box
INSERT INTO Menü_Produkt (MenüID, ProduktID) VALUES
(3,1), -- Classic Burger
(3,2), -- Veggie Burger
(3,5), -- Chicken Nuggets
(3,6); -- Caesar Salat

# Einfügen von Daten in die Tabelle Bestellung
INSERT INTO Bestellung (KundenID, Bestelldatum, Gesamtbetrag, LieferadresseID, Zahlungsart) VALUES
(1, '2023-10-01 12:00:00', 15.98, 1, 'Kreditkarte'),
(2, '2023-10-02 13:30:00', 10.49, 2, 'PayPal'),
(3, '2023-10-03 18:45:00', 19.99, 3, 'Bar');

# Einfügen von Daten in die Tabelle Bestellposten_Produkt
## Bestellung 1: Zusätzliches Produkt
INSERT INTO Bestellposten_Produkt (BestellID, ProduktID, Menge) VALUES
(1,5,1); -- Chicken Nuggets

# Einfügen von Daten in die Tabelle Bestellposten_Menü
## Bestellung 1: Menü
INSERT INTO Bestellposten_Menü (BestellID, MenüID, Menge) VALUES
(1,1,1); -- Classic Menü

## Bestellung 2: Veggie Menü
INSERT INTO Bestellposten_Menü (BestellID, MenüID, Menge) VALUES
(2,2,1); -- Veggie Menü

## Bestellung 3: Family Box
INSERT INTO Bestellposten_Menü (BestellID, MenüID, Menge) VALUES
(3,3,1); -- Family Box

# Einfügen von Daten in die Tabelle Rechnung
INSERT INTO Rechnung (BestellID, Rechnungsdatum, Betrag) VALUES
(1, '2023-10-01 12:05:00', 15.98),
(2, '2023-10-02 13:35:00', 10.49),
(3, '2023-10-03 18:50:00', 19.99);

# Hinzufügen von Bildern in die Tabelle Bild
## Hinweis: Die Bilddatei wird hier als Platzhalter NULL gesetzt, da die tatsächlichen Bilddaten komplex wären
INSERT INTO Bild (KundenID, Bilddatei, Titel, Hochladedatum, Freigabestatus, AdminID) VALUES
(1, 'not-null-value', 'Burger Spaß', '2023-10-01 12:10:00', TRUE, 1),
(2, 'not-null-value', 'Pommes Kunst', '2023-10-02 13:40:00', FALSE, NULL);

# Einfügen von Daten in die Tabelle Bewertung
INSERT INTO Bewertung (BildID, KundenID, Bewertungspunkte, Bewertungsdatum) VALUES
(1, 2, 5, '2023-10-02 14:00:00'),
(1, 3, 4, '2023-10-03 15:30:00'),
(2, 1, 3, '2023-10-04 16:00:00');

# Optional: Einfügen von zusätzlichen Zutaten für vollständige Beziehungen
## ZutatID 8 für normale Kartoffeln
INSERT INTO Zutat (Zutatenname, Beschreibung) VALUES
('Kartoffeln', 'Frische Kartoffeln für Pommes.');

## Aktualisieren des Produkt_Zutat für Pommes Frites
UPDATE Produkt_Zutat SET ZutatID = 8 WHERE ProduktID = 3;

## Optional: Einfügen von weiteren Produkten und Beziehungen nach Bedarf
