<?php
require_once 'utils/Response.php';
require_once 'config/Database.php';
require_once 'config/Router.php';
require_once 'controllers/TodoController.php';

// Racine de l'API (nom du dossier servi par le serveur web)
$BASE_PATH ='/todo-exam';

$router = new Router($BASE_PATH);


$router->add('GET', '/', function () {
    sendResponse(['message' => 'Bienvenue dans l\'API Todo!']);
});

$todoController = new TodoController();


$router->add('GET', '/todos', function () use ($todoController) {
    $todoController->getTodos();
});

$router->add('POST', '/todos', function () use ($todoController) {
    $todoController->createTodo();
});

$router->add('PUT', '/todos/{id:\d+}', function ($id) use ($todoController) {
    $todoController->updateTodo((int)$id);
});

$router->add('DELETE', '/todos/{id:\d+}', function ($id) use ($todoController) {
    $todoController->deleteTodo((int)$id);
});


// Gestion des erreurs
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    sendError($e->getMessage(), 500);
}
