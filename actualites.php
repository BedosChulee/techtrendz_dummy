<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/templates/header.php";


// @todo On doit appeler getArticale pour récupérer les articles et faire une boucle pour les afficher
$articles = getArticles($pdo);
?>

<h1>TechTrendz Actualités</h1>
<?php


?>
<div class="row text-center">
    <?php 
        foreach ($articles as $article){
            $title = $article['title'];
            echo "<div class='col-md-4 my-2 d-flex'>
                    <div class='card'>
                        <img src='/uploads/articles/3-devops.png' class='card-img-top' alt='Les meilleurs outils DevOps'>
                        <div class='card-body'>
                            <h5 class='card-title'>". $title ."</h5>
                            <a href='actualite.php?id=". $article['id'] ."' class='btn btn-primary'>Lire la suite</a>
                        </div>
                    </div>
                </div>";
        }
    ?>
    
   

</div>

<?php require_once __DIR__ . "/templates/footer.php"; ?>