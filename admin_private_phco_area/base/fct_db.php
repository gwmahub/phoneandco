<?php
//BASE/fct_db



// Fonction permettant de se connecter à la base de données
// Cette fonction est utilisée dans la page base/config.php
function Connexion($pNom, $pMotPasse, $pBase, $pServeur){
    //Connexion au serveur
    $connexion = mysqli_connect($pServeur, $pNom, $pMotPasse, $pBase);

    // On vérifie qu'on arrive bien à se connecter au serveur
    // Sinon, on affiche un message d'erreur et on termine le script courant
    if(!$connexion){
        echo "<p>Désolé, accès au serveur refusé</p>";
        exit;
    }

    // Tout s'est bien passé, on renvoie alors la variable de connexion
    return $connexion;
}

// Fonction permettant d'exécuter une requête vers la DB
// Le paramètre "pRequete" n'est rien d'autre que la requête sql elle-même
function ExecRequete($pRequete){
    // Nous allons récupérer la variable $connexion (définie dans la page base/config.php) grâce au mot clé "gloabal"
    // une variable globale est une variable déclarée à l'extérieur du corps de toute fonction,
    // et pouvant donc être utilisée n'importe où dans le programme
    global $connexion;

    // Nous allons exécuter la requête grâce à la fonction mysql_query
    $resultat = mysqli_query($connexion,$pRequete);

    // Si mysql_query retourne true, cela veut dire que la requête a bien été exécutée
    // on retourne alors le résultat
    if($resultat){
        return $resultat;
    }else{
        // Dans le cadre du debugage, si la requête échoue
        // nous afficherons les erreurs rencontrées grâce à la fonction mysql_error()
        if(DEBUG){
            echo "<p style='color:red'><b>Erreur dans l'ex&eacute;cution de la requ&ecirc;te</b></p>";
            echo "<p style='color:red'><b>Message de MySQL :</b>".mysqli_connect_error()."</p>";
        }
    }
}

// Fonction permettant de récupérer le résultat d'une requête SELECT sous la forme d'un array
function requeteResultat($sql){
    global $connexion;

    // on vérifie que la requête s'exécute correctement

    if(!mysqli_connect_errno()){
        mysqli_set_charset($connexion, "utf8");
        $requete = mysqli_query($connexion,$sql);

        if( mysqli_num_rows($requete) == 0) {
            return false;
        }else{

            return mysqli_fetch_all($requete,MYSQLI_ASSOC);
        }
    }else{
        // si la requête ne s'exécute pas correctement, nous retournons false
        if(DEBUG){
            echo "<p style='color:red'><b>Erreur dans l'ex&eacute;cution de la requ&ecirc;te</b></p>";
            echo "<p style='color:red'><b>Failed to connect to MySQL: " . mysqli_connect_error() ."</p>";
        }
        return false;
    }
}
?>