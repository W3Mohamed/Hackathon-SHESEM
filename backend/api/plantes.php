<?php
  header('Content-Type: application/json');
  include_once('../db.php');

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

  // Requête SQL avec filtres
  $sql = "SELECT * FROM plante 
          WHERE categorie = :categorie
          AND superficie_minimale <= :superficie
          AND saison_adequate LIKE :saison
          AND luminosite = :luminosite
          AND type_de_sol = :type_de_sol
          AND systeme_d_irrigation = :systeme_d_irrigation
          AND resistance_au_froid = :resistance_au_froid
          AND resistance_aux_pests = :resistance_aux_pests
          AND niveau_d_entretien = :niveau_d_entretien
          AND type_de_culture = :type_de_culture";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
      ':categorie' => $input['categorie'],
      ':superficie' => $input['superficie'],
      ':saison' => "%" . $input['saison_adequate'] . "%",
      ':luminosite' => $input['luminosite'],
      ':type_de_sol' => $input['type_de_sol'],
      ':systeme_d_irrigation' => $input['systeme_d_irrigation'],
      ':resistance_au_froid' => $input['resistance_au_froid'],
      ':resistance_aux_pests' => $input['resistance_aux_pests'],
      ':niveau_d_entretien' => $input['niveau_d_entretien'],
      ':type_de_culture' => $input['type_de_culture']
  ]);

  $plantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([
      'status' => 'success',
      'count' => count($plantes),
      'data' => $plantes
  ]);
?>