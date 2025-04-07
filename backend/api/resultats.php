<?php
  header('Content-Type: application/json');
  include_once('../db.php');

  // Récupérer les paramètres de la requête GET
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Si page n'est pas défini, on prend 1 par défaut
  $limit = 10;  // Le nombre d'éléments par page est défini à 10

  // Calculer l'offset pour la pagination
  $offset = ($page - 1) * $limit;

  // Récupérer les filtres envoyés via POST
  $input = json_decode(file_get_contents('php://input'), true);

  // Vérifier que toutes les données nécessaires sont présentes
  $required = ['categorie', 'superficie', 'saison_adequate', 'luminosite', 'type_de_sol', 'systeme_d_irrigation', 'resistance_au_froid', 'resistance_aux_pests', 'niveau_d_entretien', 'type_de_culture'];
  foreach ($required as $field) {
      if (!isset($input[$field])) {
          echo json_encode([
              'status' => 'error',
              'message' => "Champ manquant : $field"
          ]);
          exit;
      }
  }

    // Préparer la requête SQL
    $sql = "SELECT * FROM plante 
    WHERE categorie = :categorie
    AND superficie_minimale <= :superficie
    AND saison_adequate LIKE :saison
    AND luminosite = :luminosite
    AND type_de_sol LIKE :type_de_sol
    AND systeme_d_irrigation = :systeme_d_irrigation
    AND resistance_au_froid LIKE :resistance_au_froid
    AND resistance_aux_pests LIKE :resistance_aux_pests
    AND niveau_d_entretien = :niveau_d_entretien
    AND type_de_culture = :type_de_culture
    LIMIT :limit OFFSET :offset";

    // Préparer la requête avec PDO
    $stmt = $pdo->prepare($sql);

    // Lier les valeurs avec bindValue au lieu de bindParam
    $stmt->bindValue(':categorie', $input['categorie']);
    $stmt->bindValue(':superficie', $input['superficie']);
    $stmt->bindValue(':saison', "%" . $input['saison_adequate'] . "%");
    $stmt->bindValue(':luminosite', $input['luminosite']);
    $stmt->bindValue(':type_de_sol', "%" . $input['type_de_sol'] . "%");
    $stmt->bindValue(':systeme_d_irrigation', $input['systeme_d_irrigation']);
    $stmt->bindValue(':resistance_au_froid', "%" . $input['resistance_au_froid'] ."%");
    $stmt->bindValue(':resistance_aux_pests', "%" . $input['resistance_aux_pests'] . "%");
    $stmt->bindValue(':niveau_d_entretien', $input['niveau_d_entretien']);
    $stmt->bindValue(':type_de_culture', $input['type_de_culture']);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats
    $plantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
    'status' => 'success',
    'count' => count($plantes),
    'data' => $plantes
    ]);
?>