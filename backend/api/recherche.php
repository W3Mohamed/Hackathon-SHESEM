<?php
    header('Content-Type: application/json');
    include_once('../db.php');

    $nom_plante = isset($_GET['libelle']) ? $_GET['libelle'] : null;

    if (!$nom_plante) {
        echo json_encode(['status' => 'error', 'message' => 'Libelle de plante manquant.']);
        exit;
    }

    $sql = "SELECT * FROM plante WHERE libelle LIKE :libelle";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':libelle', "%$nom_plante%");

    $stmt->execute();
    $plantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($plantes) {
        echo json_encode(['status' => 'success', 'data' => $plantes]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Aucune plante trouvée.']);
    }
?>