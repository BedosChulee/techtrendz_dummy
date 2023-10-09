<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{

    /*
        @todo faire la requête d'insertion d'utilisateur et retourner $query->execute();
        Attention faire une requête préparer et à binder les paramètres
    */
    $pwd = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`, `role`) VALUES ( :email, :pwd, :first_name, :last_name, :roles)";
    $res = $pdo->prepare($sql);
    $res->bindValue(':email', $email, PDO::PARAM_STR);
    $res->bindValue(':pwd', $pwd, PDO::PARAM_STR);
    $res->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $res->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $res->bindValue(':roles', $role, PDO::PARAM_STR);
    if($res->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    /*
        @todo faire une requête qui récupère l'utilisateur par email et stocker le résultat dans user
        Attention faire une requête préparer et à binder les paramètres
    */
    $sql = "SELECT * FROM `users` WHERE `email` = :email";
    $res = $pdo->prepare($sql);
    $res->bindValue(':email', $email, PDO::PARAM_STR);
    $res->execute();
    $result = $res->fetch(PDO::FETCH_ASSOC);
   
    
    /*
        @todo Si on a un utilisateur et que le mot de passe correspond (voir fonction  native password_verify)
              alors on retourne $user
              sinon on retourne false
    */
    if(password_verify($password,$result['password']) == true){
        return $result;
    }
    else{
        return false;
    }

}
