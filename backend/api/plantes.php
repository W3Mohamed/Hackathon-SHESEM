<?php
    header('Content-Type: application/json');
    include_once('../db.php');

    // Pagination : Récupérer la page et la limite
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Si page n'est pas défini, on prend 1 par défaut
    $limit = 8;  // Limite fixée à 10 résultats par page

    // Calculer l'offset pour la pagination
    $offset = ($page - 1) * $limit;

    // Vérifier si un filtre de catégorie est passé dans l'URL
    $categorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

    // Requête pour compter le total
    $countSql = "SELECT COUNT(*) as total FROM plante";
    $countStmt = $pdo->query($countSql);
    $total = $countStmt->fetchColumn();

    // Requête SQL pour récupérer les plantes avec pagination et filtre par catégorie (si spécifié)
    $sql = "SELECT * FROM plante WHERE 1";

    // Ajouter le filtre de catégorie si spécifié
    if ($categorie) {
        $sql .= " AND categorie = :categorie";
    }

    // Ajouter la pagination
    $sql .= " LIMIT :limit OFFSET :offset";

    // Préparer la requête
    $stmt = $pdo->prepare($sql);

    // Lier les valeurs
    if ($categorie) {
        $stmt->bindValue(':categorie', $categorie, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $plantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier s'il y a des résultats
    if (count($plantes) > 0) {
        echo json_encode([
            'status' => 'success',
            'page' => $page,
            'limit' => $limit,
            'count' => count($plantes),
            'data' => $plantes,
            'total' => $total
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Aucune plante trouvée'
        ]);
    }
?>