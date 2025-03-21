// Wartet darauf, dass der gesamte Inhalt der Seite geladen ist
document.addEventListener('DOMContentLoaded', function() {
    // Sucht alle Elemente mit der Klasse 'btn-back'
    const backButtons = document.querySelectorAll('.btn-back');
    
    // Überprüft, ob mindestens ein 'btn-back' Element gefunden wurde
    if (backButtons.length > 0) {
        // Fügt jedem 'btn-back' Element einen Klick-Event-Listener hinzu
        backButtons.forEach(function(backButton) {
            backButton.addEventListener('click', function() {
                // Holt den aktuellen Seitennamen aus der URL
                const currentPage = window.location.pathname.split('/').pop();
                
                // Überprüft, auf welcher Seite sich der Benutzer befindet
                switch (currentPage) {
                    case 'contact.php':
                    case 'datenschutzerklaerung.php':
                    case 'agb.php':
                    case 'impressum.php':
                        // Geht zur vorherigen Seite im Verlauf zurück
                        window.history.back();
                        break;
                    default:
                        // Gibt eine Warnung aus, wenn kein Handler für die aktuelle Seite definiert ist
                        console.warn('Back button handler not set for this page.');
                }
            });
        });
    } else {
        // Gibt eine Warnung aus, wenn kein 'btn-back' Element auf der Seite gefunden wurde
        console.warn('Back button not found on this page.');
    }
});