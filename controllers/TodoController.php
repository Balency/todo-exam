<?php
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Todo.php';


class TodoController {
    private Todo $model;

    public function __construct() {
        $db = new Database();
        $this->model = new Todo($db->getConnection());
    }

    public function getTodos(): void {
      //  $secretKey = null;
       // if (isset($_SERVER['HTTP_SECRET_KEY'])) {
           // $secretKey = $_SERVER['HTTP_SECRET_KEY'];
       // }

        $todos = $this->model->getTodos();
        sendResponse($todos);
    }

    public function createTodo(): void {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['title']) || !isset($input['description']) || !isset($input['is_secret'])) {
            sendError('Invalid input', 400);
            return;
        }

        $title = $input['title'];
        $description = $input['description'];
        $isSecret = (bool)$input['is_secret'];

        $id = $this->model->createTodo($title, $description, $isSecret);
        if ($id === null) {
            sendError('Failed to create todo', 500);
            return;
        }

        sendResponse(['id' => $id, 'message' => 'Todo created successfully'], 201);
    }

    public function updateTodo(int $id): void {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || !isset($input['title']) || !isset($input['description']) || !isset($input['is_secret'])) {
            sendError('Invalid input', 400);
            return;
        }

        $title = $input['title'];
        $description = $input['description'];
        $isSecret = (bool)$input['is_secret'];

        $success = $this->model->updateTodo($id, $title, $description, $isSecret);
        if (!$success) {
            sendError('Failed to update todo', 500);
            return;
        }

        sendResponse(['message' => 'Todo updated successfully']);
    }

    public function deleteTodo(int $id): void {
        $success = $this->model->deleteTodo($id);
        if (!$success) {
            sendError('Failed to delete todo', 500);
            return;
        }

        sendResponse(['message' => 'Todo deleted successfully']);
    }
}
