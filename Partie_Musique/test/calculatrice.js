var memory;
var edition=false;

function init(){
  var boutons=document.getElementsByClassName("bouton_simple");
  var i;
  for (i = 0; i < boutons.length; i++) {
      boutons[i].setAttribute("onClick", "affiche(this)");
  }
}

function rab(){
  var e=document.getElementById("zone_affichage");
  e.value="";
}



function calcul(){

    var e=document.getElementById('zone_affichage').value;
    var data=encodeURIComponent(e.replace(/Math\./g,""));
    ajax_get_request(maj_zone_affichage,"http://www-etu-info.iut2.upmf-grenoble.fr/~persella/tp2/calculatrice.php?data="+data,true);
}


function affiche(bouton_click){
  var e=document.getElementById('zone_affichage');

  var valeur=bouton_click.value;
  e.value=e.value+valeur;
}

function plusmoins(){
  var e=document.getElementById('zone_affichage');
  var first =e.value.charAt(0);
  if (first=="-"){
    e.value=e.value.substring(1);
  }
  else {
    e.value="-"+e.value;
  }
}

function range_memory(){
  var e=document.getElementById('zone_affichage');
  memory=e.value;
}

function affiche_memory(){

  if(memory===undefined){
    alert("RIEN EN MEMOIRE");
  }
  else{
    var e=document.getElementById("zone_affichage");
    e.value=e.value+memory;
  }
}

function raz_memory(){
  memory=undefined;
}

function mode_edition(){
    edition=true;
    var e=document.getElementById("E");
    e.style.color = "red";
    e.setAttribute("onclick","mode_calcul()");
    var boutons_mod=document.getElementsByClassName("bouton_libre");
    var lol;
    for (lol = 0; lol < boutons_mod.length; lol++) {
      boutons_mod[lol].removeAttribute("onclick");
      boutons_mod[lol].setAttribute("ondblclick","edit(this)");
    }
}

function mode_calcul(){

  document.getElementById("E").style.color = "black";
  document.getElementById("E").setAttribute("onclick","mode_edition()");
  var boutons_mod=document.getElementsByClassName("bouton_libre");
  var lol;

  for (lol = 0; lol < boutons_mod.length; lol++) {
    //boutons_mod[lol].removeAttribute("onblur");
    boutons_mod[lol].removeAttribute("ondblclick");
    boutons_mod[lol].setAttribute("onclick","affiche(this)");
    boutons_mod[lol].setAttribute("type","button");
  }
  edition=false;
}

function edit(elem)
{
  elem.setAttribute("type","text");
  elem.setAttribute("ondblclick","fix(this)");
  //elem.setAttribute("onblur","save(this)");
}

function fix(elem)
{
  elem.setAttribute("type","button");
  elem.setAttribute("ondblclick","edit(this)");
  //elem.removeAttribute("onblur");
  //save(this);
}

function deplacer_champ_bas(){
  var calc=document.getElementById("calc");
  var monchamp= document.getElementById("zone_affichage");
  calc.appendChild(monchamp);
  monchamp.setAttribute("ondblclick","deplacer_champ_haut");
}

function deplacer_champ_haut(){
  var calc=document.getElementById("calc").firstChild;
  var monchamp= document.getElementById("zone_affichage");
  list.insertBefore(monchamp, calc);
  monchamp.setAttribute("ondblclick","deplacer_champ_bas");
}

function ajax_get_request(callback,url,async){
    var xhr =new XMLHttpRequest();
    xhr.onreadystatechange=function()
    {
      if ((xhr.readyState==4) && (xhr.status == 200)){
        callback(xhr.responseText);
      }
    };
    xhr.open("GET",url,async);
    // initialisation de l'objet
    xhr.send();
    // envoi de la requête

}

function maj_zone_affichage(reponse_server){
  var e=document.getElementById('zone_affichage');
  e.value=reponse_server;
}

function toJSON(){




}
