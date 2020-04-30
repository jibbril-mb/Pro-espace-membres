<?php  
session_start();

    require_once 'header.php';

    try
    {
        $bdd = new PDO('mysql:host=127.0.0.1;dbname=base-es-membres', 'djiby', 'djibybd');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    
    
    if(isset($_SESSION['id']))
    {
       
        $req_utilisateur = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
        $req_utilisateur->execute(array($_SESSION['id']));
        $utilisateur = $req_utilisateur->fetch();

        if(isset($_POST['nouveau_pseudo']) AND !empty($_POST['nouveau_pseudo'] != $utilisateur['pseudo']))
        {

            $nouveau_pseudo = htmlspecialchars($_POST['nouveau_pseudo']);

            $insert_pseudo = $bdd->prepare('UPDATE membres SET pseudo = ? WHERE id = ?'); // important de préciser id ,sinon tous les pseudo de la base de données seront mises à jour
            $insert_pseudo->execute(array($nouveau_pseudo, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
                    //modification du mail
        if(isset($_POST['nouveau_mail']) AND !empty($_POST['nouveau_mail'] != $utilisateur['email']))
        {

            $nouveau_mail = htmlspecialchars($_POST['nouveau_mail']);

            $insert_mail = $bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?'); // important de préciser id ,sinon tous les pseudo de la base de données seront mises à jour
            $insert_mail->execute(array($nouveau_mail, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
                    //modif  password
        if(isset($_POST['nouveau_password1']) AND !empty($_POST['nouveau_password2']) AND isset($_POST['nouveau_password2']))

        {
            $motdepasse1 = sha1($_POST['nouveau_password1']);
            $motdepasse2 = sha1($_POST['nouveau_password2']);

            if($motdepasse1 == $motdepasse2)
            {
                $insert_motdepasse = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE id = ? ');
                $insert_motdepasse->execute(array($motdepasse1, $_SESSION['id']));
                header('Location: profil.php?id='.$_SESSION['id']);
            }
            else
            {
                $message = "Vos deux mots de passes ne correspondent pas !";   
            }
        
        }
        if(isset($_POST['nouveau_pseudo']) AND $_POST['nouveau_pseudo'] == $utilisateur['pseudo'])
        {
            header('Location: profil.php?id='.$_SESSION['id']);
        }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <div align ="center">
        <h2>Modification de profil</h2>
        <div align="left">
            <p>
                <form method="post" action="">
                <label>Pseudo:</label>
                <input type="text" name="nouveau_pseudo" placeholder="Pseudo" value="<?php echo $utilisateur['pseudo']; ?>"><br><br>
                <label>Email:</label>
                <input type="email" name="nouveau_mail" placeholder="email" value="<?php echo $utilisateur['email']; ?>"><br><br>
                <label for="">Mot de passe:</label>
                <input type="password" name="nouveau_password1" placeholder="Mot de passe"><br><br>
                <label for="">Confirmation du mot de passe:</label>
                <input type="password" name="nouveau_password2" placeholder="Confirmation du mot de passe"><br><br>
                <input type="submit" value="Mettre à jour mon profil !">
                </form>

                <?php if(isset($message)) {echo $message; }?>
            </p>
        </div>
     </div>
</body>

<?php include 'footer.php'; ?>

</html>
<?php 
}
else
{
   header("location: connexion.php"); 
}
?>