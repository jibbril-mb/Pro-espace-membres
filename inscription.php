<?php  
    require_once 'header.php';

    $bdd = new PDO('mysql:host=127.0.0.1;dbname=base-es-membres', 'djiby', 'djibybd');
    if(isset($_POST['forminscription']))
    {
        //cool

        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $email_confirm = htmlspecialchars($_POST['email_confirm']);
        $password = sha1($_POST['password']);
        $password_confirm = sha1($_POST['password_confirm']); 

        if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['email_confirm']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm']))
        {
   
            //test du Pseudo s'il dépasse 255 caractères
            $pseudolength = strlen($pseudo);
            if($pseudolength <= 255) 
            {
                //cool

                if($email == $email_confirm)
                {
                    //cool

                    if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    {

                        $reqmail = $bdd->prepare('SELECT * FROM membres WHERE mail= ? ');
                        $reqmail->execute(array($email));
                        $mailexist = $reqmail->rowCount(); // Avec combien d'information ce email existe .......

                        if($mailexist == 0)
                        {

                            if($password == $password_confirm) 
                            {
                                //Séléctionne toutes les entrées ou le mail est égale au que l'utilisateur à entré.....  
                                $req = $bdd->prepare('INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)');
                                $req->execute(array($pseudo, $email, $password));
                                $errors = " Votre compte a été bien créer! <a href=\"connexion.php\">Me connecter</a> ";
                                // header('Location : index.php');
                            }
                            else
                            {
                            $errors = "Vos mots de passes ne concordent pas!";
                            }
                        }
                        else
                        {
                            $errors ="Adresse email déjà utiliséé!";
                        }
                }
                
                else
                {
                    $errors ="Votre adresses email n'est pas valide!"; 
                }
                    }
                else
                {
                    $errors ="Vos adresses email ne correspondent pas!";
                }

            }
            else
            {
                $errors = "Votre pseudo ne doit pas dépasser 255 caractères!";
            }
        }
        else
        {    
            $errors = "Tous les champs ne sont pas remplis!";
        }
    
    }

     
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <style>
        h1{
            text-align: left;
            font-size: 50px;
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
        <h1>Devenez déjà présent membre !</h1>
    
        <form action="" method="post">
         <p>
            <label for="pseudo">Pseudo:</label>
            <input type="text" name="pseudo" id="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" ><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php if(isset($email)) { echo $email; } ?>"><br><br>
            <label for="email_confirm">Confirmation email:</label>
            <input type="email" name="email_confirm" id="email_confirm"  value="<?php if(isset($email_confirm)) { echo $email_confirm; } ?>"><br><br>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password"><br><br>
            <label for="password_confirm">Confirmer votre mot de passe:</label>
            <input type="password" name="password_confirm" id="password_confirm"><br><br>
            <input type="submit" name="forminscription" value="Je m'inscris">
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