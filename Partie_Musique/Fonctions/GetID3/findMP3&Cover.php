<?php




//----------------------------------------------------------------------------------
//on met tous les .mp3 présent dans le repertoire cible dans un tableau
//----------------------------------------------------------------------------------

function findMP3($groupDir){
  $music = array();
  if (is_dir($groupDir)){
  if ($dh = opendir($groupDir)){
    while (($file = readdir($dh)) !== false){
      if($file != '.' && $file != '..') {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
            if ($extension == 'mp3') { //on ne triate que les /mp3
                $music[] = pathinfo($file,PATHINFO_BASENAME);
                //on ajoute seulement le nom du fichier (sans extension .mp3)
                //on affiche le contenue de la fonction dans test.php
            }
      }
  }
    closedir($dh);
  }
}
return $music;
}





//------------------------------------------------------------------------------
//on met toutes les cover présente dans le repertoire cible dans un tableau
//------------------------------------------------------------------------------



function findCovers($groupDir){
  $covers = array();
  if (is_dir($groupDir)){
  if ($dh = opendir($groupDir)){
    while (($file = readdir($dh)) !== false){
      if($file != '.' && $file != '..') {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
            if ($extension == 'jpeg' || $extension == 'gif' || $extension == 'png') { //on ne triate que les jpg,png et gif
                $covers[] = pathinfo($file,PATHINFO_BASENAME);
                //on ajoute le nom du fichier+extension

            }
      }
  }
    closedir($dh);
  }
}
return $covers;
}









//----------------------------------------------------------------------------------
//on met tous les dossiers présent dans le repertoire cible dans un tableau
//----------------------------------------------------------------------------------

//$dossiers =array();

function scanMusic($dataDir){
  $dossiers =array();
  if (is_dir($dataDir)){
    if ($dh = opendir($dataDir)){
      while (($dossier = readdir($dh)) !== false){
        if($dossier != '.' && $dossier != '..') {
          $extension_dossier = pathinfo($dossier, PATHINFO_EXTENSION);
              if ($extension_dossier == NULL) { //on ne traite que les dossier sans extensions
                  $dossiers[] = $dossier;
                //  echo $file."\n";
              }
        }
      }
      closedir($dh);
    }
  }
  return $dossiers;
}



//----------------------------------------------------------------------------------
//on concatène les dossiers+leurs contenue (.mp3) dans un tableau
//----------------------------------------------------------------------------------

//$concatenation=array();
//$fichiers=array();
function concatene($dataDir){
  $concatenation=array();
  $fichiers=array();
  $dossiers=scanMusic($dataDir);
    foreach($dossiers as $value){
    //  echo $value."\n";    //value = un des dossier du repertoire
    //  echo $dataDir."/".$value."\n";
      $fichiers=findMP3($dataDir."/".$value);  //fichiers = tableau des mp3 DU dossier en cours de traitement
    //  var_dump($fichiers);
      foreach($fichiers as $fichier){   //concatenation = on concatene le nom du dossier+le nom de tous les fichiers dedans
        $concatenation[]=$value."/".$fichier;
      }
    }
    return $concatenation;
  //  var_dump($concatenation);
}












 ?>
