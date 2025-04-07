<?php
class HistoriqueManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getHistoriqueParEleve($eleve_id) {
        $sql = "SELECT n.note, n.commentaire, n.date_evaluation, m.nom AS matiere_nom
                FROM Notes n
                JOIN Matieres m ON n.matiere_id = m.id
                WHERE n.eleve_id = ?
                ORDER BY n.date_evaluation DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $eleve_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
