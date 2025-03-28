<?php
class EnseignantManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    // Créer un enseignant
    public function ajouter($nom, $prenom, $email, $motDePasse, $specialite, $telephone = null) {
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        //  Créer l'utilisateur
        $query1 = "INSERT INTO Utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'Enseignant')";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bind_param("ssss", $nom, $prenom, $email, $motDePasseHash);
        $stmt1->execute();

        $user_id = $stmt1->insert_id;

        // Créer l'entrée enseignant
        $dateEmbauche = date('Y-m-d');
        $query2 = "INSERT INTO Enseignants (id, specialisation, telephone, date_embauche) VALUES (?, ?, ?, ?)";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bind_param("isss", $user_id, $specialite, $telephone, $dateEmbauche);
        $stmt2->execute();

        return $user_id;
    }

    //  Lire tous les enseignants
    public function lister() {
        $sql = "
            SELECT u.id, u.nom, u.prenom, u.email, e.specialisation, e.telephone
            FROM Utilisateurs u
            JOIN Enseignants e ON u.id = e.id
        ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //  Supprimer un enseignant (supprime aussi utilisateur)
    public function supprimer($id) {
        $stmt = $this->conn->prepare("DELETE FROM Utilisateurs WHERE id = ? AND role = 'Enseignant'");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function emailExiste($email) {
        $stmt = $this->conn->prepare("SELECT id FROM Utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
        

    //  Mettre à jour les infos d’un enseignant
    public function modifier($id, $nom, $prenom, $email, $specialite, $telephone = null) {
        $stmt1 = $this->conn->prepare("UPDATE Utilisateurs SET nom = ?, prenom = ?, email = ? WHERE id = ?");
        $stmt1->bind_param("sssi", $nom, $prenom, $email, $id);
        $stmt1->execute();

        $stmt2 = $this->conn->prepare("UPDATE Enseignants SET specialisation = ?, telephone = ? WHERE id = ?");
        $stmt2->bind_param("ssi", $specialite, $telephone, $id);
        $stmt2->execute();

        return true;
    }
}
?>
