<?php

class Todo {
    private mysqli $db;

    public function __construct(mysqli $db) {
        $this->db = $db;
    }

    /**
     * Get todos: public todos and secret todos if secret key is valid
     * @param string|null $secretKey
     * @return array
     */
    public function getTodos(?string $secretKey = null): array {
        $todos = [];

        // Prepare base query for public todos
        $query = "SELECT id, title, description, is_secret FROM todos WHERE is_secret = 0";

        $result = $this->db->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $todos[] = $row;
            }
        }

        // If secret key is provided and valid, get secret todos
        if ($secretKey !== null && $this->isValidSecretKey($secretKey)) {
            $secretQuery = "SELECT id, title, description, is_secret FROM todos WHERE is_secret = 1";
            $secretResult = $this->db->query($secretQuery);
            if ($secretResult) {
                while ($row = $secretResult->fetch_assoc()) {
                    $todos[] = $row;
                }
            }
        }

        return $todos;
    }

    /**
     * Create a new todo
     * @param string $title
     * @param string $description
     * @param bool $isSecret
     * @return int|null Inserted todo ID or null on failure
     */
    public function createTodo(string $title, string $description, bool $isSecret): ?int {
        $stmt = $this->db->prepare("INSERT INTO todos (title, description, is_secret) VALUES (?, ?, ?)");
        if (!$stmt) {
            return null;
        }
        $isSecretInt = $isSecret ? 1 : 0;
        $stmt->bind_param("ssi", $title, $description, $isSecretInt);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return null;
    }

    /**
     * Update an existing todo
     * @param int $id
     * @param string $title
     * @param string $description
     * @param bool $isSecret
     * @return bool Success status
     */
    public function updateTodo(int $id, string $title, string $description, bool $isSecret): bool {
        $stmt = $this->db->prepare("UPDATE todos SET title = ?, description = ?, is_secret = ? WHERE id = ?");
        if (!$stmt) {
            return false;
        }
        $isSecretInt = $isSecret ? 1 : 0;
        $stmt->bind_param("ssii", $title, $description, $isSecretInt, $id);
        return $stmt->execute();
    }

    /**
     * Delete a todo by ID
     * @param int $id
     * @return bool Success status
     */
    public function deleteTodo(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM todos WHERE id = ?");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Validate the secret key
     * @param string $secretKey
     * @return bool
     */
    private function isValidSecretKey(string $secretKey): bool {
        // For simplicity, hardcode a secret key or fetch from config/env
        $validSecretKey = 'votre_clé_secrète'; // Replace with actual secret key or config
        return $secretKey === $validSecretKey;
    }
}
