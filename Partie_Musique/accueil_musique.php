<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Accueil Site des connards</title>
  <link rel="stylesheet" href="accueil_musique.css">
  <style type="text/css">
  /* pour désactivé la barre de scroll sous le scroller*/
      /*.scroll .content {
        overflow : hidden;
      }*/
  </style>
</head>
<body>
  <!-- _____________________OUVERTURE DE BDD POUR LE RESTE_____________________ -->
  <?php
    try{
      $db = new PDO("sqlite:BDD/musiques.db");
    }catch(PDOException  $e ){
      echo "Erreur accés Base de données: ".$e;}
   ?>






  <!--__________________Menu +bannière____________________________-->
  <header>
    <!-- <img id="banniere_p"src="Images/banniere_p.png" alt="bannière principale">    METTRE IMAGE DE BANNIERE ICI-->
    <!-- </header> -->
    <nav>
      <ul id="menu">
        <li><a href="javascript:void(0)">Accueil</a></li><!--
        --><li><a href="javascript:void(0)">Mangas</a>
        <ul>
          <li><a href="javascript:void(0)">Anime de la semaine</a></li>
          <li><a href="javascript:void(0)">Liste complète</a></li>
        </ul>
      </li><!--
      --><li><a href="javascript:void(0)">Dessins</a>
      <ul>
        <li><a href="javascript:void(0)">Dessins partagés</a></li>
        <li><a href="javascript:void(0)">Dessins personnels</a></li>
      </ul>
    </li><!--
    --><li><a href="javascript:void(0)">Jeux</a>
    <ul>
      <li><a href="javascript:void(0)">Jeux en bash</a></li>
      <li><a href="javascript:void(0)">Jeux en java</a></li>
      <li><a href="javascript:void(0)">Jeux en C</a></li>
    </ul>
  </li><!--
  --><li><a href="#">Musique</a>
  <ul>
    <li><a href="javascript:void(0)">Nos conseils</a></li>
    <li><a href="javascript:void(0)">Téléchargements</a></li>
    <li><a href="javascript:void(0)">Votre liste</a></li>
  </ul>
</li><!--
--><li><a href="javascript:void(0)">Forum</a></li>
</ul>
</nav>
</header>








<!--____________________Contenu page d'accueil____________________________-->


<section>


  <!-- _________________________________BANNIERE GAUCHE___________________________ -->
  <aside class="banniere_g">
    <!-- _______________________________FORMULAIRE A GAUCHE_________________________-->

      <h2>Par genre :</h2>

                  <!-- __________PHP POUR AFFICHER TOUS LES GENRES DISPOS DANS LA BDD DANS LA BANNIERE DE GAUCHE________________ -->


      <ul id="choix_genre">
      <?php
      $sql = "SELECT DISTINCT style FROM musique WHERE 'author' is not NULL";
      foreach ($db->query($sql) as $row) {                               //formulaires cachés pour envoyer les datas des ahref
        echo'<form id="form_'.$row['style'].'" method="get" action="creation_page_musiqueV2.php">
            <input type="hidden" name="data_genre" value="'.$row['style'].'"/>
            </form>';

            // pour récuperer la "value" on appelera $_POST['data_genre'] sur la page php créer.
        echo'<li><a href=\'#\' onclick=\'document.getElementById("form_'.$row['style'].'").submit()\'>&#9836 '.$row['style'].' &#9836</a></li>';
      }
      ?>

    </ul>
  </aside>




<!-- ______________________________CONTENU AU MILIEU_________________________________ -->
  <aside class="contenu">
    <h1>Bienvenue sur la partie musique du site !</h1>
    <p> Pour l'instant seule la partie musique est fonctionelle mais n'est pas encore responsive, le reste arrivera bientôt ;)
      Pour commencer nous vous proposons les albums suivants :
    </p>

              <!-- _______________________________________________________________________________SCROLLER_________________________________________________________________________ -->

    <div class="scroll">
            <?php
                                  //  -------------on affiche random 10 albums qui existent------------
            $sql_random ="SELECT DISTINCT author,album FROM musique WHERE 'album' is not NULL ORDER BY RANDOM() LIMIT 10";

            //on execute la requete, execute() renvoie l'objet PDO qu'on divise en jeu de résultat et qu'on met dans un array (avec fetchAll)
            $sth=$db->prepare($sql_random);
            $sth->execute();
            $array_randomResults=$sth->fetchAll();

            // on construit d'abord les formulaires
            foreach ($array_randomResults as $row) {
               echo'<form id="form_'.$row['album'].'" method="post" action="creation_page_album.php">
                   <input type="hidden" name="data_album" value="'.$row['album'].'"/>
                   </form>';
            }
                                  //ensuite on construit UN SEUL scroller donc EN DEHORS DES FOREACH
        echo'<div class="content" id="scroller">';
                                  //puis on construit les liens AVEC un for each et on les relit aux formulaires
            foreach ($array_randomResults as $row) {
              echo'<a href="#" onclick=\'document.getElementById("form_'.$row['album'].'").submit()\'><img src="Images/loader.gif" class="lazy" width="250" height="200" data-original="musiques/'.$row['author'].' - '.$row['album'].'.jpg" alt="Image cover"></a>';
            }



            ?>


          </div>

          <!-- <div class="right"><a href="javascript:void(0)" onmouseover="currentScroller=setInterval(function() { myScroll2('scroller', 20) }, 25);" onmouseout="clearInterval(currentScroller)"> <img width="80" height="80" src="Images/fleche_cursor_r.png" alt=""> </a> -->
          <!-- <div class="left"><a href="javascript:void(0)" onmouseover="currentScroller=setInterval(function() { myScroll2('scroller', -20) }, 25);" onmouseout="clearInterval(currentScroller)"><img width="80" height="80" src="Images/fleche_cursor_g.png" alt=""></a> -->


      <div class="right"><a href="javascript:void(0)" onmouseover="mouvement_Scroller=setInterval(function() { move_Scroll('scroller', 20) }, 25);" onmouseout="clearInterval(mouvement_Scroller)"> <img width="80" height="80" src="Images/fleche_cursor_r.png" alt=""> </a>
      </div>
      <div class="left"><a href="javascript:void(0)" onmouseover="mouvement_Scroller=setInterval(function() { move_Scroll('scroller', -20) }, 25);" onmouseout="clearInterval(mouvement_Scroller)"><img width="80" height="80" src="Images/fleche_cursor_g.png" alt=""></a>
      </div>
      <p><br><br><br><br><br>Si vous avez des musiques à proposer, n'hésitez pas à contacter le WebMaster qui se chargera de les rajouter à sa bibliothèque ! Et si vous avez des propositions de design ou de rajouts aussi, après tout le site est encore loin d'être fini.
        <br><br><br>
        Vous pouvez aussi rechercher des musiques par genre dans la bannière de gauche, une recherche par artiste est aussi prévue. Mais on verra ça plus tard ;).
      </p>
      <h1>Voici la liste des chanteurs actuellement disponible sur le site :</h1>


      <?php
      echo '<ul id="liste_chanteurs">';
      $sql = "SELECT DISTINCT author FROM musique WHERE 'author' is not NULL";
      foreach ($db->query($sql) as $row) {
                echo '<li>'.$row['author'].'</li>';
      }
      echo '</ul>';
      ?>


    </div>
  </aside>



  <!-- ______________________BANNIERE DROITE_____________________________ -->

  <aside class="banniere_d">
    <h2>Par artiste :</h2>
    <p>A venir !</p>
  </aside>
  <a href="#" class="up"><img src="Images/hamtaro.png" alt="bouton haut de page hamtaro"></a> <!--bouton haut de page-->
</section>







<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/jquery-lazyload/jquery.lazyload.js"></script>
<script type="text/javascript" src="accueil_musique.js"></script>
</body>
</html>
