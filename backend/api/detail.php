<?php
    header('Content-Type: application/json');
    include_once('../db.php');

    // Récupérer l'ID de la plante à partir des paramètres de l'URL
    $id_plante = isset($_GET['id']) ? $_GET['id'] : null;

    // Vérifier si l'ID est valide
    if (!$id_plante) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de plante manquant.'
        ]);
        exit;
    }

    // Préparer la requête pour récupérer les détails de la plante
    $sql = "SELECT * FROM plante WHERE id_plant = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_plante);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les détails de la plante
    $plante = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la plante a été trouvée
    if ($plante) {
        echo json_encode([
            'status' => 'success',
            'data' => $plante
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Plante non trouvée.'
        ]);
    }
?>