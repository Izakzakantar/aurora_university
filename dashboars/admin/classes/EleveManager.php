<?php
class EleveManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    // Ajouter un élève
    public function ajouter($nom, $prenom, $email, $motDePasse, $classe, $naissance) {
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Créer l'utilisateur
        $query1 = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'Elève')";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bind_param("ssss", $nom, $prenom, $email, $motDePasseHash);
        $stmt1->execute();

        $user_id = $stmt1->insert_id;

        // Créer l'élève
        $query2 = "INSERT INTO Eleves (id, date_naissance) VALUES (?, ?)";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("is", $user_id, $naissance);
        $stmt2->execute();

        return $user_id;
    }

    // Modifier un élève
    public function modifier($id, $nom, $prenom, $email, $classe, $naissance) {
        $stmt1 = $this->conn->prepare("UPDATE Utilisateurs SET nom = ?, prenom = ?, email = ? WHERE id = ?");
        $stmt1->bind_param("sssi", $nom, $prenom, $email, $id);
        $stmt1->execute();

        $stmt2 = $this->conn->prepare("UPDATE Eleves SET date_naissance = ? WHERE id = ?");
        $stmt2->bind_param("si", $naissance, $id);
        $stmt2->execute();

        return true;
    }

    // Supprimer un élève
    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM Utilisateurs WHERE id = ? AND role = 'Elève'");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Lister les élèves
    public function lister() {
        $sql = "
            SELECT u.id, u.nom, u.prenom, u.email, e.date_naissance
            FROM Utilisateurs u
            JOIN Eleves e ON u.id = e.id
        ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function emailExiste($email) {
        $stmt = $this->conn->prepare("SELECT id FROM Utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
} 
?>
