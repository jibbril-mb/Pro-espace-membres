<?php  
session_start();
require_once 'header.php';
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=base-es-membres', 'djiby', 'djibybd');
    
    if(isset($_POST['form_connexion']))
    {
        //si ça existe on continu 
        
        $mail_connect = htmlspecialchars($_POST['mail_connect']);
        $password_connect = sha1($_POST['password_connect']);
        
        if(!empty($mail_connect) AND !empty($password_connect))
        {
            //Vérifie si l'utilisateur existe bien
            $req_utilisateur = $bdd->prepare('SELECT * FROM membres WHERE mail = ? AND motdepasse = ?');
            $req_utilisateur->execute(array($mail_connect, $password_connect));
            $utilisateur_exist = $req_utilisateur->rowCount(); 
            if($utilisateur_exist == 1)
            {
            //si ça existe on continu  

            $info_utilisateur = $req_utilisateur->fetch();
            $_SESSION['id'] = $info_utilisateur['id'];
            $_SESSION['pseudo'] = $info_utilisateur['pseudo'];
            $_SESSION['mail'] = $info_utilisateur['mail'];
            header("Location: profil.php?id=".$_SESSION['id']); //Pour rediriger vers le profil de l'utilisateur ...

            }
            else
            {
                $errors = "Mauvais email ou mot de passe!";
            }
        }
        else
        {
                $errors = "Tous les champs doivent etre complétés!";
        }
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <style>
        h1{
           
            font-size: 55px;
            color: #003366;
            opacity: 0.8;
           text-shadow: 2px 2px 8px #24a6d1;
           font-weight: normal; 
           font-style: italic;
        }
    </style>

</head>
<body>
    <div align ="center">

        <h1>Connexion</h1>

        <br><br>

        <form action="" method="post">
         <p>
            <label for="mail_connect">Email:</label>
            <input type="email" name="mail_connect" id="mail_connect"><br><br>
            <label for="password_connect">Mot de passe:</label>
            <input type="password" name="password_connect" id="password_connect"><br><br>
            <input type="submit" name="form_connexion" value="Se connecter">
         </p>
         </form>
         <?php 
         
            if(isset($errors))
            {
                echo '<font color="red">'.$errors."</font>";
            }
         ?>

     </div>

     <?php include 'footer.php'; ?>

</body>
</html>