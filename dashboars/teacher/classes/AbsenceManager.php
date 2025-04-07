<?php
class AbsenceManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function ajouter($eleve_id, $matiere_id, $date, $statut, $remarque) {
        $stmt = $this->conn->prepare("INSERT INTO Absences (eleve_id, matiere_id, date_absence, statut, remarque) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $eleve_id, $matiere_id, $date, $statut, $remarque);
        return $stmt->execute();
    }

   
    public function listerParEnseignant($enseignant_id) {
        $sql = "SELECT u.prenom, u.nom, a.date_absence, a.statut, a.remarque, m.nom AS matiere_nom
                FROM Absences a
                JOIN Eleves e ON a.eleve_id = e.id
                JOIN Utilisateurs u ON u.id = e.id
                JOIN Matieres m ON a.matiere_id = m.id
                ORDER BY a.date_absence DESC";
    
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    

}
