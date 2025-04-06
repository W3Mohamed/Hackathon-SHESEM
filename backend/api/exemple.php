<?php
header('Content-Type: application/json');
include_once('../db.php');

// Exemple simple de retour de données
$data = [
  'status' => 'success',
  'message' => 'API connectée avec succès !',
  'data' => ['name' => 'Hackathon', 'year' => 2025]
];
echo json_encode($data);
?>
