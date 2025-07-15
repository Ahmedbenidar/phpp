<?php

// ... existing code ...

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM client WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        // Démarrer la session
        session_start();
        
        // Stocker les informations du professeur dans la session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['client_id'] = $row['id'];
        $_SESSION['client_name'] = $row['nom'];
        
        // Rediriger vers la page d'accueil
        header('Location: home.php');
        exit();
    } else {
        echo "Email ou mot de passe incorrect";
    }
}

// ... existing code ...

?>