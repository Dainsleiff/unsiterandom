
<?php
require_once('getid3.php');
require_once('findMP3&Cover.php');


try{
  $db = new PDO("sqlite:../../BDD/musiques.db");
}catch(PDOException  $e ){
  echo "CA MARCHE PAS: ".$e;}

var_dump($db);

  $files=findMP3("../../musiques");
  //var_dump($files);
  foreach ($files as $value) {

  $filename="../../musiques/".$value;  //mettre le chemin vers les musiques


  $getID3 = new getID3;
  $ThisFileInfo = $getID3->analyze($filename);



//----------affichage de toutes les meta données--------------------------------
  //var_dump($ThisFileInfo);
  //var_dump($ThisFileInfo['tags']);


//---------------affichage des meta données "utiles"-----------------------------

  //if(isset($ThisFileInfo['tags']['id3v2']['artist'][0])) {echo "Artiste: ".$ThisFileInfo['tags']['id3v2']['artist'][0]."\n"; }
  //if(isset($ThisFileInfo['tags']['id3v2']['title'][0])) {echo "Titre: ".$ThisFileInfo['tags']['id3v2']['title'][0]."\n"; }
  //if(isset($ThisFileInfo['tags']['id3v2']['album'][0])) {echo "Album: ".$ThisFileInfo['tags']['id3v2']['album'][0]."\n"; }
  //if(isset($ThisFileInfo['tags']['id3v2']['genre'][0])) {echo "Genre: ".$ThisFileInfo['tags']['id3v2']['genre'][0]."\n"; }
  //if(isset($ThisFileInfo['tags']['id3v2']['year'][0])) {echo "Année: ".$ThisFileInfo['tags']['id3v2']['year'][0]."\n"; }

 $artist=$ThisFileInfo['tags']['id3v2']['artist'][0];
 $title=$ThisFileInfo['tags']['id3v2']['title'][0];
 $album=$ThisFileInfo['tags']['id3v2']['album'][0];
 $genre=$ThisFileInfo['tags']['id3v2']['genre'][0];
 $year=$ThisFileInfo['tags']['id3v2']['year'][0];

var_dump($artist);
var_dump($title);
var_dump($album);
var_dump($genre);
var_dump($year);

$sql ="INSERT INTO musique(title,album,author,style,year) VALUES(:title,:album,:artist,:genre,:year)";

$req = $db->prepare($sql);
$req->bindValue(':title',$title,PDO::PARAM_STR);
$req->bindValue(':album',$album,PDO::PARAM_STR);
$req->bindValue(':artist',$artist,PDO::PARAM_STR);
$req->bindValue(':year',$year,PDO::PARAM_STR);
$req->bindValue(':genre',$genre,PDO::PARAM_STR);

$req->execute();



}







//-------------------------tags possibles--------------------------------------
//src http://www.getid3.org/demo/AAC.aac.html
//ou voir structure.txt
//tags_html -> id3v2 -> album  (array1)
//                   -> artist  (array1)
//                   -> encoded_by (array1)
//                   -> genre  (array2)
//                   -> title  (array1)
//                   -> url_user  (array1)
//                   -> year  (array1)
//------------------------------------------------------------------------------
?>
