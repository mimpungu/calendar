<?php
require_once 'db.php';

$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$searchCriteria = isset($_GET['searchCriteria']) ? $_GET['searchCriteria'] : '';

$events = array();

$sql = "SELECT id, nom_cours AS title, DATE_FORMAT(date_cours, '%d/%m/%Y') AS start, heure_debut AS startTime, heure_fin AS endTime, categories, professeurs, salle, nom_filiere, code_filiere,
    CASE 
        WHEN categories IN ('Vacances', 'Soutenances') THEN DATE_FORMAT(date_fin, '%d/%m/%Y')
        ELSE DATE_FORMAT(date_cours, '%d/%m/%Y')
    END AS end_date
FROM evenements WHERE $searchCriteria LIKE '%$searchInput%'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $color = ''; // Variable pour stocker la couleur associée à chaque catégorie

        // Associer chaque catégorie à une couleur
        switch ($row['categories']) {
            case 'Cours':
                $color = 'DodgerBlue';
                break;
            case 'TP Machine':
                $color = 'Maroon';
                break;
            case 'Examens':
                $color = 'DarkOrchid';
                break;
            case 'Reunion':
                $color = 'SlateGray';
                break;
            case 'Soutenances':
                $color = 'SeaGreen';
                break;
            case 'Vacances':
                $color = 'red';
                break;

            default:
                // Par défaut, laisser la couleur vide
                break;
        }

        $event = array(
            'title' => $row['title'],
            'start' => $row['start'] . ' ' . $row['startTime'], // Combinez date et heure de début
            'end' => $row['end_date'] . ' ' . $row['endTime'], // Utilisation de la colonne conditionnelle pour la date de fin
            'categories' => $row['categories'],
            'professeurs' => $row['professeurs'],
            'salle' => $row['salle'],
            'nom_filiere' => $row['nom_filiere'],
            'code_filiere' => $row['code_filiere'],
            'color' => $color // Ajouter la couleur associée à la catégorie
        );
        $events[] = $event;
    }
}

// Générer le contenu HTML pour le calendrier
$html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Scolaire</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            color: white; /* Définir la couleur du texte en blanc */
        }
        .calendar-title {
            font-weight: bold;
            text-align: center; /* Centrer le titre */
        }
        .event-details {
            margin-top: 5px;
        }
        .event-time {
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">';
// Ajouter le titre du calendrier avec le nom de la filière et le code de la filière
$html .= '<h2 class="calendar-title">Calendrier Scolaire - ' . $events[0]['nom_filiere'] . ' (' . $events[0]['code_filiere'] . ')</h2>';

// Ajouter chaque événement au HTML
foreach ($events as $event) {
    $html .= '<div class="event" style="background-color: ' . $event['color'] . '">';
    $html .= '<div><strong>Début:</strong> ' . $event['start'] . '</div>';
    $html .= '<div><strong>Fin:</strong> ' . $event['end'] . '</div>';
    $html .= '<div><strong>Categorie :</strong> ' . $event['categories'] . '</div>';
    $html .= '<div><strong>Matière:</strong> ' . $event['title'] . '</div>';
    $html .= '<div><strong>Professeur:</strong> ' . $event['professeurs'] . '</div>';
    $html .= '<div><strong>Salle:</strong> ' . $event['salle'] . '</div>';
    $html .= '<div><strong>Filière:</strong> ' . $event['nom_filiere'] . ' (' . $event['code_filiere'] . ')</div>';

    $html .= '</div>';// Fermeture de la div row
}

$html .= '</div> 
</body>
</html>';

// Utiliser DomPDF pour générer le PDF
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optionnel) Réglez la taille du papier et l'orientation
$dompdf->setPaper('A4', 'portrait');

// Rendre le HTML en PDF
$dompdf->render();

// Envoyer le PDF au navigateur pour le téléchargement
$dompdf->stream('calendrier.pdf');
?>

