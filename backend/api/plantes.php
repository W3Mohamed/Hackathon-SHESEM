    <?php
    header('Content-Type: application/json');
    include_once('../db.php');

    // Pagination : Récupérer la page et la limite
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Si page n'est pas défini, on prend 1 par défaut
    $limit = 10;  // Limite fixée à 10 résultats par page

    // Calculer l'offset pour la pagination
    $offset = ($page - 1) * $limit;

    // Requête SQL pour récupérer toutes les plantes avec pagination
    $sql = "SELECT * FROM plante LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);

    // Lier les valeurs avec bindValue
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
            'data' => $plantes
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Aucune plante trouvée'
        ]);
    }
