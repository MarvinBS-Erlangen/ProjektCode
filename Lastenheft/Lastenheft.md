# https://github.com/ioana229/MMI/issues/12

Ausganssituation: Eine große Firmenkette für gesunde Fastfood (MacAPPLE) möchte neben dem Restaurantgeschäft seinen Kunden nun auch einen Lieferservice anbieten. Dabei sollen Kunden über die Homepage verschiedene Menüs und Produkte auswählen und bestellen können. Für die einzelnen Produkte werden Zutaten, Energiewerte, Preise usw. in der Datenbank erfasst. Auch die Adressen der Kunden sind zu erfassen. Die Firma möchte die Datenbank auswerten können, wobei z. B. für die einzelnen Produkte die Bestellhäufigkeit angezeigt, bzw. für einzelne Kunden deren Vorlieben dargestellt werden sollen. Die Datenbank soll Produkte, Kunden, Bestellungen und Rechnungen erfassen. Kunden der Firmenkette sollen über die Webseite an einem „Funny-Dinner-Contest“ mitmachen können. Dafür sollen sie lustige Bilder, die sie während des Essens gemacht haben, hochladen können. Ein Admin kann nach Begutachtung der Bilder diese freischalten und die Kunden können dann ein Rating für jedes Bild abgeben. Am Ende eines Monats soll dann das Bild mit den meisten Ratings gewonnen haben.
Lastenheft für das MacAPPLE Online-Lieferservice und Funny-Dinner-Contest

# 1. Zielbestimmung
   
## 1.1 Aufgabenstellung
MacAPPLE, eine große Firmenkette für gesundes Fastfood, möchte ihr Angebot erweitern und neben dem Restaurantgeschäft einen Lieferservice anbieten. Kunden sollen über die Unternehmenshomepage verschiedene Menüs und Produkte auswählen und bestellen können. Zusätzlich soll ein interaktiver "Funny-Dinner-Contest" implementiert werden, bei dem Kunden lustige Bilder hochladen und bewerten können.

## 1.2 Muss-Ziele
* Online-Bestellsystem: Entwicklung einer benutzerfreundlichen Webplattform zur Bestellung von Produkten.
* Datenbankintegration: Erfassung und Verwaltung von Produkten, Zutaten, Energiewerten, Preisen, Kundenadressen, Bestellungen und Rechnungen.
* Datenanalyse: Fähigkeit zur Auswertung der Datenbank, um Bestellhäufigkeiten und Kundenpräferenzen zu ermitteln.
* Funny-Dinner-Contest: Möglichkeit für Kunden, Bilder hochzuladen, die nach Admin-Freigabe von anderen Kunden bewertet werden können.
* Datenschutz & Sicherheit: Sicherstellung der Einhaltung aller relevanten Datenschutzgesetze (z.B. DSGVO) und Schutz sensibler Daten.

# 2. Produkteinsatz
   
## 2.1 Zielgruppe
* Bestehende Kunden: Stammkunden, die den Komfort eines Lieferservices nutzen möchten.
* Neukunden: Personen, die gesundes Fastfood bevorzugen und Wert auf bequeme Bestellmöglichkeiten legen.
* Technikaffine Nutzer: Kunden, die gerne an Online-Wettbewerben teilnehmen und interaktive Funktionen schätzen.
  
## 2.2 Marktpositionierung
* Wettbewerbsvorteil: Kombination aus gesundem Speisenangebot und innovativen Online-Funktionen zur Steigerung der Kundenbindung.
* Markenimage: Positionierung als modernes, kundenorientiertes Unternehmen, das auf Ernährung und Digitalisierung setzt.

# 3. Produktfunktionen
   
## 3.1 Online-Bestellsystem
* Produktkatalog:
    * Darstellung aller verfügbaren Menüs und Produkte mit Bildern und Beschreibungen.
    * Anzeige von Zutaten, Allergenen, Energiewerten und Preisen.
* Bestellprozess:
    * Auswahl von Produkten und Hinzufügen zum Warenkorb.
    * Übersicht und Bearbeitung des Warenkorbs.
    * Checkout mit Eingabe oder Auswahl der Lieferadresse.
    * Auswahl der Zahlungsmethoden (z.B. Kreditkarte, PayPal, Sofortüberweisung).
* Benutzerkonto:
    * Registrierung und Login-Funktion.
    * Speicherung von Lieferadressen und Bestellhistorie.
    * Möglichkeit zur Nachbestellung vorheriger Bestellungen.
      
## 3.2 Datenbankverwaltung

* Produkte:
    * Verwaltung von Produktdetails, Zutatenlisten und Nährwertangaben.
* Kunden:
    * Speicherung von Kontaktdaten, Lieferadressen und Bestellhistorie.
* Bestellungen:
    * Erfassung von Bestellungen mit Zeitstempel, Produkten und Beträgen.
* Rechnungen:
    * Generierung und Archivierung von Rechnungen für jede Bestellung.
* Auswertungen:
    * Produktanalyse: Ermittlung der Bestellhäufigkeit einzelner Produkte.
    * Kundenanalyse: Identifikation von Vorlieben und Bestellmustern einzelner Kunden.
      
## 3.3 Funny-Dinner-Contest
* Bild-Upload:
    * Kunden können lustige Bilder während des Essens hochladen.
    * Beschreibungen oder Titel können hinzugefügt werden.
* Admin-Freigabe:
    * Ein Admin überprüft eingereichte Bilder auf Richtlinienkonformität.
    * Freigabe oder Ablehnung mit Benachrichtigung an den Kunden.
* Bewertungssystem:
    * Freigeschaltete Bilder werden in einer Galerie angezeigt.
    * Kunden können Bilder ansehen und eine Bewertung abgeben (z.B. 1-5 Sterne).
* Gewinnerermittlung:
    * Am Monatsende wird das Bild mit den meisten Bewertungen ermittelt.
    * Automatische Benachrichtigung des Gewinners und Anzeige auf der Homepage.
3.4 Sicherheits- und Datenschutzfunktionen
* Verschlüsselung:
    * SSL-Verschlüsselung für die Datenübertragung.
    * Verschlüsselte Speicherung sensibler Daten wie Passwörter.
* Datenschutz:
    * Einhaltung der DSGVO-Richtlinien.
    * Bereitstellung von Datenschutzbestimmungen und Impressum.
* Zugriffskontrolle:
    * Rollenbasierte Zugriffsrechte für Admins und Mitarbeiter.

# 4. Qualitätsanforderungen
   
## 4.1 Benutzerfreundlichkeit
* Intuitive Navigation: Klare Menüstruktur und einfache Bedienung.
* Responsives Design: Optimale Darstellung auf Desktop- und mobilen Endgeräten.
  
## 4.2 Performance
* Schnelle Ladezeiten: Seiten sollen innerhalb von 2 Sekunden laden.
* Skalierbarkeit: System soll bei hoher Nutzerzahl stabil bleiben.
  
## 4.3 Sicherheit
* Backup-Strategie: Tägliche Backups aller Datenbanken und Systeme.

# 5. Rahmenbedingungen
   
## 5.1 Technische Vorgaben
* Webtechnologie:
    * Frontend: HTML5, CSS3, JavaScript (Frameworks wie React oder Angular).
    * Backend: Serverseitige Sprache (PHP) mit MVC-Struktur.
* Datenbank:
    * Verwendung eines relationalen Datenbanksystems (MySQL).
      
## 5.2 Rechtliche Vorgaben
* Impressumspflicht: Vollständige Anbieterkennzeichnung gemäß Telemediengesetz.
* Datenschutz: Umsetzung der Anforderungen der DSGVO, inklusive Nutzerrechte und Datenaufbewahrung.
* Nutzungsbedingungen: Allgemeine Geschäftsbedingungen für Nutzung der Webseite und Teilnahme am Contest.
  
## 5.3 Zeit- und Kostenrahmen
* Projektlaufzeit: Gesamtdauer von 8 Monaten.
    * Woche 1: Anforderungsanalyse und Konzeptentwicklung.
    * Woche 2-3: Entwicklung der Kernfunktionen des Bestellsystems.
    * Woche 3: Implementierung des Funny-Dinner-Contests.
    * Woche 4: Testphase und Fehlerbehebung.
    * Woche 4: Finalisierung und Launch.
* Budget: ?

# 6. Lieferumfang
   
* Funktionsfähige Webseite: Komplettes Online-Bestellsystem und Contest-Plattform.
* Dokumentation:
    * Benutzerhandbuch für Kunden und Admins.
    * Technische Dokumentation für Wartung und Weiterentwicklung.

# 7. Abnahmekriterien
   
* Funktionalität:
    * Alle Muss-Ziele sind vollständig umgesetzt.
    * System läuft stabil und fehlerfrei.
* Benutzerakzeptanz:
    * Positive Rückmeldungen in Usability-Tests mit Testkunden.
* Sicherheit:
    * Bestehen aller Sicherheitstests und Compliance-Prüfungen.
* Leistungsfähigkeit:
    * System erfüllt Performance-Anforderungen bei Lasttests.

# 8. Risiken und Annahmen
   
* Risiken:
    * Zeitverzögerungen durch unvorhergesehene technische Probleme.
    * Sicherheitsbedrohungen durch Cyberangriffe.
* Annahmen:
    * Ressourcenverfügbarkeit: Qualifiziertes Personal steht für die Projektdauer zur Verfügung.
    * Kundenakzeptanz: Die Zielgruppe nimmt den Lieferservice und den Contest positiv an.

# 9. Potenzielle Erweiterungen
    
* Mobile App: Entwicklung einer nativen App für iOS und Android zur Steigerung der Nutzerfreundlichkeit.
* Personalisierte Marketingkampagnen: Nutzung der Daten aus der Kundenanalyse für gezielte Werbeaktionen.
* Erweiterte Zahlungssysteme: Integration weiterer Zahlungsmethoden wie Apple Pay oder Google Pay.
* Gamification-Elemente: Einführung von Belohnungssystemen für regelmäßige Bestellungen oder Contest-Teilnahmen.

Zusätzliche Überlegungen:
* Nachhaltigkeit:
    * Digitalisierung spart Papier und reduziert den ökologischen Fußabdruck.
    * Möglichkeit, umweltfreundliche Verpackungsoptionen bei der Bestellung auszuwählen.
* Kundensupport:
    * Implementierung eines Live-Chats oder Chatbots für schnelle Kundenanfragen.

