-- GET ORDERS QUERY:

-- Get Menues and Products from Order
SELECT m.Menuename, p.Produktname, bpm.Menge, bpp.Menge, b.Bestelldatum, b.Gesamtbetrag, b.Zahlungsart FROM Bestellung b JOIN Bestellposten_Menue bpm ON b.BestellID = bpm.BestellID JOIN Menue m ON bpm.MenueID = m.MenueID JOIN Menue_Produkt mp ON m.MenueID = mp.MenueID JOIN Produkt p ON mp.ProduktID = p.ProduktID JOIN Bestellposten_Produkt bpp ON p.ProduktID = bpp.ProduktID;

-- Get Only Menues
SELECT m.Menuename, bpm.Menge, b.Bestelldatum, b.Gesamtbetrag, b.Zahlungsart FROM Bestellung b JOIN Bestellposten_Menue bpm ON b.BestellID = bpm.BestellID JOIN Menue m ON bpm.MenueID = m.MenueID WHERE b.BestellID = ?; -- Use a specific order ID


-- Get only Products
SELECT 
    p.Produktname, 
    bpp.Menge, 
    b.Bestelldatum, 
    b.Gesamtbetrag, 
    b.Zahlungsart 
FROM Bestellung b
JOIN Bestellposten_Produkt bpp ON b.BestellID = bpp.BestellID
JOIN Produkt p ON bpp.ProduktID = p.ProduktID
WHERE b.BestellID = ?; -- Use the same order ID
