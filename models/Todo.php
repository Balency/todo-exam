<?php

class Todo {
    private mysqli $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    // TODO: Définir les méthodes pour gérer les todos (CRUD)
}
