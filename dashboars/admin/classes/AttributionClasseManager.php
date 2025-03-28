<?php
class AttributionClasseManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function ajouter($enseignant_id, $classe_id, $matiere_id) {
        $stmt = $this->conn->prepare("INSERT INTO Classe_Enseignant_Matiere (classe_id, enseignant_id, matiere_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $classe_id, $enseignant_id, $matiere_id);
        return $stmt->execute();
    }

    public function lister() {
        $sql = "
            SELECT cem.id, u.nom AS enseignant_nom, u.prenom AS enseignant_prenom, c.nom AS classe_nom, m.nom AS matiere_nom
            FROM Classe_Enseignant_Matiere cem
            JOIN Enseignants e ON cem.enseignant_id = e.id
            JOIN Utilisateurs u ON e.id = u.id
            JOIN Classes c ON cem.classe_id = c.id
            JOIN Matieres m ON cem.matiere_id = m.id
        ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM Classe_Enseignant_Matiere WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function modifier($id, $enseignant_id, $classe_id, $matiere_id) {
        $stmt = $this->conn->prepare("UPDATE Classe_Enseignant_Matiere SET enseignant_id = ?, classe_id = ?, matiere_id = ? WHERE id = ?");
        $stmt->bind_param("iiii", $enseignant_id, $classe_id, $matiere_id, $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Classe_Enseignant_Matiere WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
