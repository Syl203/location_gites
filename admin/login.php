<?php session_start(); 

if(isset($_POST) && !empty($_POST)){

    $user = "root";
    $pass = "";
    $email = trim(htmlspecialchars($_POST["email"]));
    $password = trim(htmlspecialchars($_POST["password"]));
    try{
        $connexion = new PDO('mysql:host=localhost;dbname=location_gites;charset=UTF8',$user,$pass);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        $retour = $e->getMessage();
        die();
    }

    $sql = "SELECT * FROM `administrateur` WHERE `email_admin` = ? AND `password_admin` = ?";
    $req = $connexion->prepare($sql);
    $req->bindParam(1, $email);
    $req->bindParam(2, $password);
    $req->execute();

    if($req->rowCount() >= 0) {
        $ligne = $req->fetch();
        if($ligne){
            $emailT = $ligne['email_admin'];
            $passwordT = $ligne['password_admin'];
            if ($email === $emailT && $password === $passwordT){
                $_SESSION["connecte"] = $email;
                header("Location: index.php");
            } else {
                echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion: merci de verifié votre email et mot de passe</p>
            </div>";
            }
        }else {
            echo "<div class='mt-3 container'>
                    <p class='alert alert-danger p-3'>Erreur de connexion : merci de verifier votre email et mot de passe</p>
            </div>";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css">
    <title>Connexion administrateur</title>
</head>
<body>
    <div class="main">
        <div class="connexion">
            <h1>Connexion</h1>
            <hr>
            <form method="post">
                <label for="email">Email :</label><br />
                <input type="email" name="email" id="email" required class="form-control"><br>
                
                <label for="password">Mot de passe :</label><br>
                <input type="password" name="password" id="password" required class="form-control"><br>

                <button class="btn btn-success" name="clic" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>