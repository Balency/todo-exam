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
}
