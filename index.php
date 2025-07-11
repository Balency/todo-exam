<?php
require_once 'utils/Response.php';
require_once 'config/Database.php';
require_once 'config/Router.php';
require_once 'controllers/TodoController.php';

// Racine de l'API (nom du dossier servi par le serveur web)
$BASE_PATH = '/c:\xampp\htdocs\<nnemete_blondel_fred_exam_final/todo-exam';

$router = new Router($BASE_PATH);

$router->add('GET', '/', function () {
    sendResponse(['message' => 'Bienvenue dans l\'API Todo!']);
});


// Gestion des erreurs
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    sendError($e->getMessage(), 500);
}
