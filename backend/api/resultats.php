<?php
    header('Content-Type: application/json');
    include_once('../db.php');

    // Vérifier la méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Méthode non autorisée. Seules les requêtes POST sont acceptées.'
        ]);
        exit;
    }

    // Récupérer les paramètres de pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 8;
    $offset = ($page - 1) * $limit;

    // Récupérer et valider les données JSON
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Données JSON invalides'
        ]);
        exit;
    }

    // Vérifier les champs obligatoires
    $required = [
        'categorie'
        // 'superficie', 
        // 'saison_adequate', 
        // 'luminosite', 
        // 'type_de_sol', 
        // 'systeme_d_irrigation', 
        // 'resistance_au_froid', 
        // 'resistance_aux_pests', 
        // 'niveau_d_entretien', 
        // 'type_de_culture'
    ];

    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode([
                'status' => 'error',
                'message' => "Champ manquant ou vide : $field",
                'received_data' => $input // Pour le débogage
            ]);
            exit;
        }
    }

    try {
        // Requête pour compter le nombre total de résultats (sans pagination)
        $baseSql = "FROM plante WHERE categorie = :categorie";
        $params = [':categorie' => $input['categorie']];
        
        // Vérifie et ajoute dynamiquement les autres filtres
        if (!empty($input['superficie'])) {
            $baseSql .= " AND superficie_minimale <= :superficie";
            $params[':superficie'] = $input['superficie'];
        }
        if (!empty($input['saison_adequate'])) {
            $baseSql .= " AND saison_adequate LIKE :saison";
            $params[':saison'] = "%" . $input['saison_adequate'] . "%";
        }
        if (!empty($input['luminosite'])) {
            $baseSql .= " AND luminosite = :luminosite";
            $params[':luminosite'] = $input['luminosite'];
        }
        if (!empty($input['type_de_sol'])) {
            $baseSql .= " AND type_de_sol LIKE :type_de_sol";
            $params[':type_de_sol'] = "%" . $input['type_de_sol'] . "%";
        }
        if (!empty($input['systeme_d_irrigation'])) {
            $baseSql .= " AND systeme_d_irrigation = :systeme_d_irrigation";
            $params[':systeme_d_irrigation'] = $input['systeme_d_irrigation'];
        }
        if (!empty($input['resistance_au_froid'])) {
            $baseSql .= " AND resistance_au_froid LIKE :resistance_au_froid";
            $params[':resistance_au_froid'] = "%" . $input['resistance_au_froid'] . "%";
        }
        if (!empty($input['resistance_aux_pests'])) {
            $baseSql .= " AND resistance_aux_pests LIKE :resistance_aux_pests";
            $params[':resistance_aux_pests'] = "%" . $input['resistance_aux_pests'] . "%";
        }
        if (!empty($input['niveau_d_entretien'])) {
            $baseSql .= " AND niveau_d_entretien = :niveau_d_entretien";
            $params[':niveau_d_entretien'] = $input['niveau_d_entretien'];
        }
        if (!empty($input['type_de_culture'])) {
            $baseSql .= " AND type_de_culture = :type_de_culture";
            $params[':type_de_culture'] = $input['type_de_culture'];
        }
        

        // 1. Requête de comptage
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total " . $baseSql);
        foreach ($params as $key => $val) {
            $countStmt->bindValue($key, $val);
        }
        $countStmt->execute();
        $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        // 2. Requête de données avec pagination
        $dataSql = "SELECT * " . $baseSql . " LIMIT :limit OFFSET :offset";
        $dataStmt = $pdo->prepare($dataSql);
        

        // Lier les paramètres des filtres
        foreach ($params as $key => $val) {
            $dataStmt->bindValue($key, $val);
        }
        $dataStmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();

        $plantes = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        // Réponse finale
        echo json_encode([
            'status' => 'success',
            'page' => $page,
            'per_page' => $limit,
            'total_count' => (int)$totalCount,
            'current_count' => count($plantes),
            'filters' => $input, // Pour référence
            'data' => $plantes
        ]);

    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        error_log("Erreur PDO: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur de base de données',
            'debug' => $e->getMessage() // À retirer en production
        ]);
    } catch (Exception $e) {
        // Gestion des autres erreurs
        error_log("Erreur: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Une erreur est survenue',
            'debug' => $e->getMessage() // À retirer en production
        ]);
    }
?>