<?php
require_once(__DIR__ . '/../config/Database.php');

class MemberModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->OpenCon();
    }

    public function userExistByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM members WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createMember($name, $email, $password_hash, $phone) {
        $role = 'member';
        $stmt = $this->conn->prepare("INSERT INTO members (name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password_hash, $phone, $role);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM members WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateProfile($userId, $name, $email, $phone) {
        $stmt = $this->conn->prepare("UPDATE members SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $userId);
        return $stmt->execute();
    }

    public function updatePassword($userId, $new_password_hash) {
        $stmt = $this->conn->prepare("UPDATE members SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $new_password_hash, $userId);
        return $stmt->execute();
    }
}
?>