<?php
class NoteManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    // Ajouter une nouvelle note
    public function ajouter($eleve_id, $matiere_id, $note, $commentaire, $date_evaluation, $annee_scolaire, $niveau_etude) {
        $stmt = $this->conn->prepare("INSERT INTO Notes (eleve_id, matiere_id, note, commentaire, date_evaluation, annee_scolaire, niveau_etude) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidssss", $eleve_id, $matiere_id, $note, $commentaire, $date_evaluation, $annee_scolaire, $niveau_etude);
        return $stmt->execute();
    }

    // Récupérer les élèves ayant déjà une note par cet enseignant
    public function getElevesParEnseignant($enseignant_id) {
        $sql = "SELECT DISTINCT u.id, u.nom, u.prenom
                FROM Notes n
                JOIN Eleves e ON n.eleve_id = e.id
                JOIN Utilisateurs u ON u.id = e.id
                JOIN Classe_Enseignant_Matiere cem ON cem.matiere_id = n.matiere_id
                WHERE cem.enseignant_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $enseignant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Récupérer les matières enseignées par l’enseignant
    public function getMatieresParEnseignant($enseignant_id) {
        $sql = "SELECT DISTINCT m.id, m.nom
                FROM Classe_Enseignant_Matiere cem
                JOIN Matieres m ON cem.matiere_id = m.id
                WHERE cem.enseignant_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $enseignant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function listerParEnseignant($enseignant_id) {
        $sql = "SELECT n.*, u.nom AS eleve_nom, u.prenom AS eleve_prenom, m.nom AS matiere_nom
                FROM Notes n
                JOIN Eleves e ON n.eleve_id = e.id
                JOIN Utilisateurs u ON u.id = e.id
                JOIN Matieres m ON n.matiere_id = m.id
                JOIN Classe_Enseignant_Matiere cem ON cem.matiere_id = m.id
                WHERE cem.enseignant_id = ?
                ORDER BY n.date_evaluation DESC";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $enseignant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>
