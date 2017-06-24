<?php
  $album=$_GET['album'];
  //$album="Ten thousand fists";
  try{
    $db = new PDO("sqlite:BDD/musiques.db");
  }catch(PDOException  $e ){
    echo "CA MARCHE PAS: ".$e;}

    $sql_musique= 'SELECT DISTINCT author,title,album FROM musique WHERE album=\''.$album.'\' ORDER BY title';
    $statement=$db->prepare($sql_musique);
    $statement->execute();
    $results=$statement->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($results);
    $json_musiques=json_encode($results);
    echo $json_musiques;




?>
