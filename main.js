let timer;

document.addEventListener('visibilitychange', function() {
    clearTimeout(timer); // Vorhandenen Timer löschen, wenn der Tab-Status geändert wird

    if (document.hidden) {
        timer = setTimeout(function() {
            document.originalTitle = document.title; 
            document.title = ittcData.inactiveTitle;
        }, ittcData.timeout);
    } else {
        document.title = document.originalTitle || document.title; // Setze den Titel zurück, falls ein originalTitle vorhanden ist
    }
});