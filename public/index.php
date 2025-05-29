<?php
require_once __DIR__ . '/../vendor/autoload.php';
define('BASE_VIEW_PATH', dirname(__DIR__) . '/views/');

use Config\Database;
use MonProjet\GestionBudget\Controllers\UtilisateurController;
use MonProjet\GestionBudget\Controllers\CategorieController;
use MonProjet\GestionBudget\Controllers\ItemController;

// Connexion à la base
$db = Database::getInstance();
$pdo = $db->getConnection();

// Définit les routes simples (sans paramètres dynamiques)
$routes = [
    '/' => function () use ($pdo) {
        $title = "Accueil";
        ob_start();
        require BASE_VIEW_PATH . 'home.php';
        $content = ob_get_clean();
        require BASE_VIEW_PATH . 'layout.php';
    },

    '/categories' => function () use ($pdo) {
        $controller = new CategorieController($pdo);
        $controller->index();
    },

    '/utilisateurs' => function () use ($pdo) {
        $controller = new UtilisateurController($pdo);
        $controller->index();
    },

    '/utilisateur/create' => function () use ($pdo) {
        $controller = new UtilisateurController($pdo);
        $controller->create();
    },

    // '/utilisateur/delete' => function () use ($pdo) {
    //     $controller = new UtilisateurController($pdo);
    //     $controller->delete();
    // }
];

// Récupère l’URL demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/gestion_budget/public'; // ajuste ce chemin selon ton projet
$uri = str_replace($basePath, '', $uri);

// Vérifie les routes simples
if (isset($routes[$uri])) {
    $routes[$uri]();
    exit;
}

// Vérifie les routes dynamiques
if (preg_match('#^/utilisateur/update/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controller = new UtilisateurController($pdo);
    $controller->update($id);
    exit;
}

// if (preg_match('#^/utilisateur/totalCategorie/(\d+)$#', $uri, $matches)) {
//     $id = (int) $matches[1];
//     $controller = new UtilisateurController($pdo);
//     $controller->totalByCategory($id);
//     exit;
// }

if (preg_match('#^/utilisateur/visionGeneral/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controller = new UtilisateurController($pdo);
    $controller->totalByCategoryANDItem($id);
    exit;
}

if (preg_match('#^/item/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controller = new ItemController($pdo);
    $controller->index($id);
    exit;
}

// Si aucune route ne correspond, retourne une 404
http_response_code(404);
echo "404 - Page non trouvée";
