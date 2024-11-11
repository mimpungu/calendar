$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        events: function(start, end, timezone, callback) {
            var searchInput = $('#searchInput').val();
            var searchCriteria = $('#searchCriteria').val();

            $.ajax({
                url: 'get-events.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    searchInput: searchInput,
                    searchCriteria: searchCriteria
                },
                success: function(events) {
                    callback(events);
                }
            });
        },
        locale: 'fr', // Définit la langue du calendrier en français
        defaultView: 'month', // Affiche la vue mois par défaut
        header: {
            left: 'prev,next today', // Boutons de navigation gauche
            center: 'title', // Titre centré
            right: 'month,agendaWeek,agendaDay' // Boutons de navigation droite
        },
        eventRender: function(event, element) {
            // Ajouter la classe de couleur en fonction de la catégorie
            switch(event.categories) {
                case 'Cours':
                    element.css('background-color', 'cyan');
                    break;
                case 'TD Machine':
                    element.css('background-color', 'bordeaux');
                    break;
                case 'Examens':
                    element.css('background-color', 'violet');
                    break;
                case 'Réunion':
                    element.css('background-color', 'blanc');
                    break;
                case 'Soutenance':
                    element.css('background-color', 'gris');
                    break;
                case 'Vacances':
                    element.css('background-color', 'red');
                    break;
                default:
                    // Par défaut, laisser la couleur inchangée
                    break;
            }
          
            // Insérer la catégorie dans un élément div
            element.append('<div>' + event.categories + '</div>');
            // Ajouter les autres informations de l'événement
            element.append('<div>' + event.professeurs + '</div>');
            element.append('<div>' + event.salle + '</div>');
            element.append('<div>' + event.nom_filiere + '</div>');
            element.append('<div>' + event.code_filiere + '</div>');
        } 
    });
    
    // Fonction pour déplacer le calendrier vers la première occurrence de l'événement recherché
    function moveToFirstEvent() {
        var searchInput = $('#searchInput').val();
        var searchCriteria = $('#searchCriteria').val();

        $.ajax({
            url: 'get-events.php',
            type: 'GET',
            dataType: 'json',
            data: {
                searchInput: searchInput,
                searchCriteria: searchCriteria
            },
            success: function(events) {
                if (events.length > 0) {
                    var firstEventStart = moment(events[0].start); // Convertir la date de début en objet moment
                    calendar.fullCalendar('gotoDate', firstEventStart); // Déplacer le calendrier vers la date de début du premier événement
                }
            }
        });
    }

    // Appeler la fonction moveToFirstEvent une seule fois après le chargement initial du calendrier
    moveToFirstEvent();

    // Gestionnaire d'événement pour le bouton de recherche
    $('#searchButton').click(function() {
        calendar.fullCalendar('refetchEvents');
        moveToFirstEvent(); // Déplacer le calendrier vers la première occurrence de l'événement recherché après avoir récupéré les nouveaux événements
    });

    $('#downloadPDFButton').click(function() {
        window.location.href = 'export-calendar-pdf.php?searchInput=' + $('#searchInput').val() + '&searchCriteria=' + $('#searchCriteria').val();
    });
    
    $('#exportICalendarButton').click(function() {
        window.location.href = 'export-calendar-ics.php?searchInput=' + $('#searchInput').val() + '&searchCriteria=' + $('#searchCriteria').val();
    });
});
