
<?php

function getArticleById(PDO $pdo, int $id)
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getArticles(PDO $pdo, int $limit = null, int $page = null)
{

    /*
        @todo faire la requête de récupération des articles
        La requête sera différente selon les paramètres passés, commencer par le BASE de base
    */
    $resultpage = getTotalArticles($pdo);
    if($limit && $page == null){
        $query = $pdo->prepare("SELECT * FROM articles ORDER BY id DESC LIMIT :limit");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    }
    else if($limit && $page !== null){
        $offset = 0;
        for($i = 1; $i < $page; $i++){
            $offset = $offset + 10;
        }
        $query = $pdo->prepare("SELECT * FROM articles LIMIT :limit OFFSET $offset");
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
       
        
    }
    else{
        $query = $pdo->prepare("SELECT * FROM articles");
    }
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
   
}

function getTotalArticles(PDO $pdo)
{
    /*
        @todo récupérer le nombre total d'article (avec COUNT)
    */
    $query = $pdo->prepare("SELECT COUNT(id) as total FROM articles");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function saveArticle(PDO $pdo, string $title, string $content, $image, int $category_id, int $id = null):bool 
{
    if ($id === null) {
        /*
            @todo si id est null, alors on fait une requête d'insection
        */
        
        $sql = "INSERT INTO `articles` (`category_id`, `title`, `content`, `image`) VALUES (:cat_id, :title, :content, :img)";
        
        $res = $pdo->prepare($sql);
        $res->bindValue(':cat_id', $category_id, $pdo::PARAM_INT);
        $res->bindValue(':title', $title, $pdo::PARAM_STR);
        $res->bindValue(':content', $content, $pdo::PARAM_STR);
        $res->bindValue(':img', $image, $pdo::PARAM_STR);
        
        if($res->execute()){
            return true;
        }
        else{
            return false;
        }

    } else {
        /*
            @todo sinon, on fait un update
        */
        
    $sql = "UPDATE `articles` SET `category_id` = :cat_id, `title` = :title, `content` = :content, `image` = :img WHERE `id` = :id";
        
        $res = $pdo->prepare($sql);
        $res->bindValue(':id', $id, $pdo::PARAM_INT);
        $res->bindValue(':cat_id', $category_id, $pdo::PARAM_INT);
        $res->bindValue(':title', $title, $pdo::PARAM_STR);
        $res->bindValue(':content', $content, $pdo::PARAM_STR);
        $res->bindValue(':img', $image, $pdo::PARAM_STR);
        
        if($res->execute()){
            return true;
        }
        else{
            return false;
        }
        
    }

    // @todo on bind toutes les valeurs communes
   
}

function deleteArticle(PDO $pdo, int $id):bool
{
    
    /*
        @todo Faire la requête de suppression
    */

    
    $sql = "DELETE FROM `articles` WHERE `articles`.`id` = :id";
    $res = $pdo->prepare($sql);
    $res->bindValue(':id', $id, $pdo::PARAM_INT);
    $res->execute();
    if ($res->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
    
}