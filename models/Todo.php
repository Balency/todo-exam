<?php
class User
{
    private $db;
    private $table = "utilisateurs";

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $result = $this->db->query("SELECT * FROM $todo");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($nom, $email, $mot_de_passe)
    {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO $this->table (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $email, $hash);
        return $stmt->execute();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $nom, $email, $mot_de_passe)
    {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE $this->table SET nom = ?, email = ?, mot_de_passe = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nom, $email, $hash, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}