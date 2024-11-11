<?php
require_once 'db.php';

$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$searchCriteria = isset($_GET['searchCriteria']) ? $_GET['searchCriteria'] : '';

$events = array();

$sql = "SELECT id, nom_cours AS title, date_cours AS start, date_fin, heure_debut AS startTime, heure_fin AS endTime, categories, professeurs, salle, nom_filiere, code_filiere FROM evenements WHERE $searchCriteria LIKE '%$searchInput%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event = array(
            'title' => $row['title'],
            'start' => $row['start'] . 'T' . $row['startTime'], // Format iCalendar
            'end' => '', // Laissez vide pour le moment
            'categories' => $row['categories'], // Ajouter la couleur associée à la catégorie
            'professeurs' => $row['professeurs'], // Ajouter les professeurs
            'salle' => $row['salle'], // Ajouter la salle
            'nom_filiere' => $row['nom_filiere'], // Ajouter le nom de la filière
            'code_filiere' => $row['code_filiere'] // Ajouter le code de la filière
        );

        // Si la catégorie est 'vacances' ou 'soutenances', utiliser la date de fin
        if ($row['categories'] == 'Vacances' || $row['categories'] == 'Soutenances') {
            $event['end'] = $row['date_fin'] . 'T' . $row['endTime']; // Utiliser la date de fin
        } else {
            $event['end'] = $row['start'] . 'T' . $row['endTime']; // Utiliser la date de cours
        }

        $events[] = $event;
    }
}

// Créer le contenu du fichier iCalendar
$ics_content = "BEGIN:VCALENDAR\r\n";
$ics_content .= "VERSION:2.0\r\n";
$ics_content .= "PRODID:-//mimpungu corporation/iCalendarSchool//NONSGML v1.0//EN\r\n";

foreach ($events as $event) {
    $ics_content .= "BEGIN:VEVENT\r\n";
    $ics_content .= "DTSTART:" . date('Ymd\THis', strtotime($event['start'])) . "\r\n";
    $ics_content .= "DTEND:" . date('Ymd\THis', strtotime($event['end'])) . "\r\n";
    $ics_content .= "SUMMARY:" . $event['title'] . "\r\n";

    // Construction de la description
    $description = $event['categories'] . "\\n" . $event['professeurs'] . "\\n" . $event['salle'] . "\\n";
    $description .= $event['nom_filiere'] . " (" . $event['code_filiere'] . ")"; // Ajout du nom de la filière avec le code entre parenthèses
    $ics_content .= "DESCRIPTION:" . $description . "\r\n";

    // Ajout du rappel
    $ics_content .= "BEGIN:VALARM\r\n";
    $ics_content .= "TRIGGER:-PT15M\r\n"; // Rappel 15 minutes avant le début de l'événement
    $ics_content .= "ACTION:DISPLAY\r\n";
    $ics_content .= "DESCRIPTION:Rappel: " . $event['title'] . "\r\n";
    $ics_content .= "END:VALARM\r\n";

    $ics_content .= "END:VEVENT\r\n";
}


$ics_content .= "END:VCALENDAR";

// En-têtes HTTP pour télécharger le fichier
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=calendar.ics');

echo $ics_content;
?>
