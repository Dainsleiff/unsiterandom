
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title> Musique </title>
  <link rel="stylesheet" type="text/css" href="creation_page_musique.css" />
</head>
<body>
  <a class="retour_accueil" href="accueil_musique.php"><img width="120" height="120" src="Images/back-arrow.png" alt="image retour menu"></a>
  <header >
    <h1>Musique!</h1>
  </header>
  <nav>
    <ul>
      <li><a href="#">QUI SOMMES NOUS</a></li>
      <li><a href="#">LE TOP 10</a></li>
      <li><a href="#">CATEGORIES</a></li>
      <li><a href="#">CONTACT</a></li>
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

    $form_genre=htmlentities($_POST['data_genre']);
    //echo'<p>VOICI LE GENRE DU FORMULAIRE :'.$form_genre;
    $sql =  'SELECT * FROM musique WHERE style=\''.$form_genre.'\' ORDER BY album';

    foreach ($db->query($sql) as $row) {

      //on construit une div par musique trouvé via la requete (musique = row)
      echo '<div class="musique">';
      //------------------------------DIV EXTRAIT--------------------------
          echo '<div class="extrait">';
              echo'  <figure>';

              //la cover est identifié avec le nom de l'artiste + de l'album, donc si il n'y a pas d'album référencé
              //on affiche une cover par défaut

                  if ($row['album']!=NULL) {
                    echo'<img width="130" height="130" src="musiques/'.$row['author'].' - '.$row['album'].'.jpg" alt="couverture" />';
                  }
                  else{
                    echo'<img width="130" height="130" src="musiques/none_cover.jpg" alt="couverture" />';
                  }

              echo'</figure>';
              //-------------mp3---------------
              echo'<audio controls>';
                  echo'<source src="musiques/'.$row['author'].' - '.$row['title'].'.mp3" type="audio/mpeg">';
              echo'</audio>';
          echo'</div>';   //<*********************


          echo'<div class=info>';  //-------div informations--------

              //----------------------title et album---------------------
              if ($row['title']!=NULL &&$row['album']){
                echo'<p>Titre: '.$row['title'].'<br />
                Album: '.$row['album'].'
                </p>';
              }
              else{
                echo'<p>Titre: Pas d\'artiste détecté dans la BDD <br />';
              }

              //----------------------genre--------------------
              if ($row['style']!=NULL){
                echo'<p>Genre: '.$row['style'].'<br />';
              }
              else{
                echo'<p>Genre: Pas de genre détecté dans la BDD <br />';
              }

              //------------------------------year-----------------------------------------------
              if ($row['year']!=NULL){
                echo'Sortie: '.$row['year'];
              }
              else{
                echo'Sortie : Pas de date de sortie détectée dans la BDD';
              }


              echo'</p>';
              // echo'</div>'; <**********************


              echo'<header>Artiste: '.$row['author'].'</header>';
              echo'<p>Sed tamen haec cum ita tutius observentur, quidam vigore artuum inminuto rogati
              ad nuptias ubi aurum dextris manibus cavatis offertur, inpigre vel usque Spoletium pergunt.
              haec nobilium sunt instituta.</p>';
          echo'</div>';
      echo'</div>';



    }
    ?>

  </body>
  </html>
