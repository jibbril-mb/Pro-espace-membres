<?php  
session_start();

    require_once 'header.php';
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=base-es-membres', 'djiby', 'djibybd');
    
    if(isset($_GET['id']) AND $_GET['id'] > 0)
    {
        //pour sécuriser la variable..
        $getid = intval($_GET['id']);
        $req_utilisateur = $bdd->prepare('SELECT * FROM membres WHERE id= ?');
        $req_utilisateur->execute(array($getid));
        //affichage des données 
        $info_utilisateur = $req_utilisateur->fetch();
         

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

        <h2>Profil de <?php echo $info_utilisateur['pseudo']; ?> </h2>

        <br><br>
        Pseudo = <?php echo $info_utilisateur['pseudo']; ?>
        <br>
        Email = <?php echo $info_utilisateur['mail']; ?>
        <br>
        <?php 
         
        if(isset($_SESSION['id']) AND $info_utilisateur['id'] == $_SESSION['id']) 
        {
        ?>
        <a href="modif_profil.php">Modifier mon profil</a>
        <a href="deconnexion.php">Se déconnecter</a>
        <?php     
        }
        ?> 

     </div>
</body>

<?php include 'footer.php'; ?>

</html>
<?php 
}
?>