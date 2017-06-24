
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title> Musique </title>
  <link rel="stylesheet" type="text/css" href="creation_page_musiqueV2.css" />

</head>
<body>
   <canvas id="matrix"></canvas>
    <div id="Global_z1">
        <a class="retour_accueil" href="accueil_musique.php"><img width="120" height="120" src="Images/back-arrow.png" alt="image retour menu"></a>
        <header>
          <h1 id="header_title">Musique!</h1>
        </header>
        <nav>
          <ul>
            <li><a id="launch_matrix" onclick="start_matrix()">MATRIX !</a></li>
            <li><a id="launch_mosquito">MOSQUITO !</a></li>
          </ul>
        </nav>



        <?php
        class Music {
          public $id ;
          public $author ;
          public $title ;
          public $cover ;
          public $mp3 ;
          public $category ;
        }


        //-----------------connection à la bdd---------------------------
        try{
          $db = new PDO("sqlite:BDD/musiques.db");
        }catch(PDOException  $e ){
          echo "CA MARCHE PAS: ".$e;}
          //var_dump($db);
          //---------------------------------------------------------------

          $form_genre=htmlentities($_GET['data_genre']);
          //$form_genre=htmlentities($_POST['data_genre']);
          //echo'<p>VOICI LE GENRE DU FORMULAIRE :'.$form_genre;


          $sql_album = 'SELECT DISTINCT author,album,style,year FROM musique WHERE style=\''.$form_genre.'\' ORDER BY author';
          //'SELECT * FROM musique WHERE style=\''.$form_genre.'\' ORDER BY author';
          echo '<div class="musique">';








            //echo'<h1>Albums de '.$row_artist['author'].'</h1>';
            foreach ($db->query($sql_album) as $row) {

              //on construit une div par musique trouvé via la requete (musique = row)

              //------------------------------DIV EXTRAIT--------------------------
                  echo '<div class="extrait" id="'.$row['album'].'_div">';
                      echo'  <figure>';

                      //la cover est identifié avec le nom de l'artiste + de l'album, donc si il n'y a pas d'album référencé


                          if ($row['album']!=NULL) {
                          //echo'<button type="button" class="class_album" id="'.$row['album'].'"><img width="130" height="130" src="musiques/'.$row['author'].' - '.$row['album'].'.jpg" alt="couverture" /></button>';
                            //<input id="libre1" class="class_album" value="" type="button">
                          echo'<a class="class_album" id="'.$row['album'].'" >
                                    <img class="lazy" src="Images/loader.gif" width="130" height="130" alt="couverture" data-original="musiques/'.$row['author'].' - '.$row['album'].'.jpg"/>
                                </a>';
                          }

                          //on affiche une cover par défaut
                          else{
                            echo'<img class="lazy" src="Images/loader.gif" data-original="musiques/none_cover.jpg" width="130" height="130" alt="couverture" />';
                          }
                      echo'</figure>';
                  echo'</div>';
                }


          echo'</div>';



          ?>

          <script src="node_modules/jquery/dist/jquery.min.js"></script>
          <script src="node_modules/jquery-lazyload/jquery.lazyload.js"></script>
          <script src="creation_page_musiqueV2.js"></script>
      </div>
  </body>
  </html>
