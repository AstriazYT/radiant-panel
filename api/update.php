<?php
header('Content-Type: application/json');

// Clé de sécurité pour éviter que n'importe qui modifie ton launcher
$SECRET_KEY = "TON_MOT_DE_PASSE_SECRET";

// Récupération des données JSON envoyées par le JS
$inputData = json_decode(file_get_contents('php://input'), true);

if (!$inputData) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée reçue.']);
    exit;
}

// Vérification du mot de passe
if (!isset($inputData['key']) || $inputData['key'] !== $SECRET_KEY) {
    echo json_encode(['success' => false, 'message' => 'Clé de sécurité incorrecte !']);
    exit;
}

// Formatage de la nouvelle configuration
$configData = [
    'maintenance' => (bool)$inputData['maintenance'],
    'latestVersion' => $inputData['latestVersion'],
    'announcement' => $inputData['announcement'],
    'downloadUrl' => $inputData['downloadUrl']
];

// Chemin vers le fichier config.json à la racine
$filePath = '../config.json';

// Écriture du fichier sur le serveur
if (file_put_contents($filePath, json_encode($configData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['success' => true, 'message' => 'Configuration enregistrée !']);
} else {
    echo json_encode(['success' => false, 'message' => 'Impossible d\'écrire le fichier config.json. Vérifiez les permissions de dossier.']);
}
?>
