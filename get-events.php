<?php
require_once 'db.php';

$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$searchCriteria = isset($_GET['searchCriteria']) ? $_GET['searchCriteria'] : '';

$events = array();

$sql = "SELECT id, nom_cours AS title, date_cours AS start, date_fin, heure_debut AS startTime, heure_fin AS endTime, categories, professeurs, salle, nom_filiere, code_filiere FROM evenements WHERE $searchCriteria LIKE '%$searchInput%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $color = ''; // Variable pour stocker la couleur associée à chaque catégorie

        // Associer chaque catégorie à une couleur
        switch ($row['categories']) {
            case 'Cours':
                $color = 'DodgerBlue';
                $endDateTime = $row['start']; // Utiliser date_cours pour la fin de l'événement
                break;
            case 'TP Machine':
                $color = 'Maroon';
                $endDateTime = $row['start']; // Utiliser date_cours pour la fin de l'événement
                break;
            case 'Examens':
                $color = 'DarkOrchid';
                $endDateTime = $row['start']; // Utiliser date_cours pour la fin de l'événement
                break;
            case 'Reunion':
                $color = 'SlateGray';
                $endDateTime = $row['start']; // Utiliser date_cours pour la fin de l'événement
                break;
            case 'Soutenances':
                $color = 'SeaGreen';
                $endDateTime = $row['date_fin']; // Utiliser date_fin pour la fin de l'événement
                break;
            case 'Vacances':
                $color = 'red';
                $endDateTime = $row['date_fin']; // Utiliser date_fin pour la fin de l'événement
                break;
            default:
                // Par défaut, laisser la couleur vide
                break;
        }
        
        $event = array(
            'id' => $row['id'],
            'categories' => $row['title'],
            'start' => $row['start'] . ' ' . $row['startTime'], // Combinez date et heure de début
            'end' => $endDateTime . ' ' . $row['endTime'], // Utilisez la variable $endDateTime pour la fin de l'événement
            'title' => $row['categories'],
            'professeurs' => $row['professeurs'],
            'salle' => $row['salle'],
            // Modifier les valeurs des clés 'nom_filiere' et 'code_filiere'
            'nom_filiere' => $row['nom_filiere'] . ' (' . $row['code_filiere'] . ')',
            'code_filiere' => '', // Vous pouvez laisser vide si vous ne voulez pas utiliser le code_filiere individuellement dans l'affichage
            'color' => $color // Ajouter la couleur associée à la catégorie
        );
        
        $events[] = $event;
    }
}
echo json_encode($events);
?>

