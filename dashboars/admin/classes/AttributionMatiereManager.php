<?php
class AttributionMatiereManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function ajouter($enseignant_id, $classe_id, $matiere_id) {
        $stmt = $this->conn->prepare("INSERT INTO Classe_Enseignant_Matiere (enseignant_id, classe_id, matiere_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $enseignant_id, $classe_id, $matiere_id);
        $stmt->execute();
    }

    public function modifier($id, $enseignant_id, $classe_id, $matiere_id) {
        $stmt = $this->conn->prepare("UPDATE Classe_Enseignant_Matiere SET enseignant_id = ?, classe_id = ?, matiere_id = ? WHERE id = ?");
        $stmt->bind_param("iiii", $enseignant_id, $classe_id, $matiere_id, $id);
        $stmt->execute();
    }

    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM Classe_Enseignant_Matiere WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT cem.id, cem.enseignant_id, cem.classe_id, cem.matiere_id,
                       u.nom AS enseignant_nom, u.prenom AS enseignant_prenom,
                       c.nom AS classe_nom, m.nom AS matiere_nom
                FROM Classe_Enseignant_Matiere cem
                JOIN Utilisateurs u ON cem.enseignant_id = u.id
                JOIN Classes c ON cem.classe_id = c.id
                JOIN Matieres m ON cem.matiere_id = m.id
                WHERE cem.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function lister() {
        $sql = "SELECT cem.id, u.nom AS enseignant_nom, u.prenom AS enseignant_prenom,
                       c.nom AS classe_nom, m.nom AS matiere_nom
                FROM Classe_Enseignant_Matiere cem
                JOIN Utilisateurs u ON cem.enseignant_id = u.id
                JOIN Classes c ON cem.classe_id = c.id
                JOIN Matieres m ON cem.matiere_id = m.id
                ORDER BY cem.id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
