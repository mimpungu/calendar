<?php
require_once 'db.php';

$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';

$suggestions = array();

// Requête SQL pour récupérer les suggestions pour les différents champs
$sql_nom_cours = "SELECT DISTINCT nom_cours FROM evenements WHERE nom_cours LIKE '%$searchInput%' LIMIT 5";
$result_nom_cours = $conn->query($sql_nom_cours);

if ($result_nom_cours->num_rows > 0) {
    while ($row = $result_nom_cours->fetch_assoc()) {
        $suggestions['nom_cours'][] = $row['nom_cours'];
    }
}

$sql_categories = "SELECT DISTINCT categories FROM evenements WHERE categories LIKE '%$searchInput%' LIMIT 5";
$result_categories = $conn->query($sql_categories);

if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $suggestions['categories'][] = $row['categories'];
    }
}

$sql_professeurs = "SELECT DISTINCT professeurs FROM evenements WHERE professeurs LIKE '%$searchInput%' LIMIT 5";
$result_professeurs = $conn->query($sql_professeurs);

if ($result_professeurs->num_rows > 0) {
    while ($row = $result_professeurs->fetch_assoc()) {
        $suggestions['professeurs'][] = $row['professeurs'];
    }
}

$sql_code_filiere = "SELECT DISTINCT code_filiere FROM evenements WHERE code_filiere LIKE '%$searchInput%' LIMIT 5";
$result_code_filiere = $conn->query($sql_code_filiere);

if ($result_code_filiere->num_rows > 0) {
    while ($row = $result_code_filiere->fetch_assoc()) {
        $suggestions['code_filiere'][] = $row['code_filiere'];
    }
}

echo json_encode($suggestions);
?>
