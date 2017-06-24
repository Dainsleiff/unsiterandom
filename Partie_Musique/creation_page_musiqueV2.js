//--------------------Lazyload images-----------------------------
$("img.lazy").lazyload();

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------NEW DIV-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


$(".class_album").click(function(){
  var bouton_click=this;
  var album=this.id;

    $.ajax({
       url : 'ajax_creationDivMusiques.php', // La ressource ciblée
       type : 'GET', // Le type de la requête HTTP.
       data : 'album=' +album,
       dataType : 'json',
       success : function(reponse,statut){
             //$("<p>"+reponse[0].author+"</p>").appendTo(".musique");   CA MARCHE  reponse[0].author contient l'auteur du premier element renvoyé par la requete en ajax
            remove_newDiv(bouton_click);
            create_newDiv(album);
            ajout_musique_newDiv(reponse,album);  //on passe la reponse ajax, et le nom des albums pour completer les champs

       }
    });

});

function remove_newDiv(bouton_click){
    $("#newDiv_id" ).remove();  //a chaque click on supprimer puis recréer newDiv
    $(".class_album").children("img").css({"border":"","padding":""});
    $(bouton_click).children("img").css({"border":"3px solid red","padding":"0"});
}



function create_newDiv(nom_album){
      var newDiv= $("<div>", {id: "newDiv_id"});
      var div_album_select=$("div[id=\'"+nom_album+"_div\']");   //---> LE HOLD-UP QUI FONCTIONNE !! id avec des espaces = on le bidouille un peu
      div_album_select.after(newDiv);

      $("#newDiv_id").prepend('<img id="CHECK_IT_BABY" src="Images/dancing_hamtaro.gif" alt="dancing hamtaro">');  //le hamster qui danse
      $("#CHECK_IT_BABY").click(function(){
          remove_newDiv();
  });
}

function ajout_musique_newDiv(reponse_ajax,nom_album){
      for(var i=0;i<reponse_ajax.length;i++){
          $("#newDiv_id").append('<h5>'+reponse_ajax[i].title+" By "+reponse_ajax[i].author+', From '+nom_album+'</h5>');
          $("#newDiv_id").append('<audio controls><source src="musiques/'+reponse_ajax[i].author+' - '+reponse_ajax[i].title+'.mp3" type="audio/mpeg"></audio>');
          $("#newDiv_id").append('<a class="buttons_playlistDown" onclick="create_playlistDown(this)" data-author="'+reponse_ajax[i].author+'" data-title="'+reponse_ajax[i].title+'" data-album="'+nom_album+'"><img class="img_buttons_playlistDown" src="Images/play_button.png" alt="buttons_playlistDown"></a>');

      }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------PLAYLIST DOWN-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function create_playlistDown(buttons_playlistDown){
    $("#Div_playListDown").remove();   //on reset a chaque appel de buttons_playlistDown
    var newDiv_playListDown =$("<div>", {id: "Div_playListDown"});
    var playlistDown_author=$(buttons_playlistDown).data('author');
    var playlistDown_album=$(buttons_playlistDown).data('album');
    // var playlistDown_author=buttons_playlistDown.attr('data-author');   //on recupere les données via les attributs custom
    // var playlistDown_title=buttons_playlistDown.attr('data-title');
    var newDiv_playListDown_Img=$("<img>",{class: "lazy",src:'musiques/'+playlistDown_author+' - '+playlistDown_album+'.jpg'});

    $("body").append(newDiv_playListDown);
    newDiv_playListDown.append(newDiv_playListDown_Img);
}











//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------CANVAS MATRIX-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



function start_matrix(){
      document.getElementById("header_title").innerHTML="Welcome to the matrix, Neo.";
      //document.getElementById("header_title").style.backgroundColor="black";
      var c = document.getElementById("matrix");
      var ctx = c.getContext("2d");

      //making the canvas full screen
      c.height = window.innerHeight;
      c.width = window.innerWidth;

      //chinese characters - taken from the unicode charset
      var symbol = "10";
      //converting the string into an array of single characters
      symbol = symbol.split("");

      var font_size = 20;
      var columns = c.width/font_size; //number of columns for the rain
      //an array of drops - one per column
      var drops = [];
      //x below is the x coordinate
      //1 = y co-ordinate of the drop(same for every drop initially)
      for(var x = 0; x < columns; x++)
      	drops[x] = 1;

      //drawing the characters
      function draw()
      {
      	//Black BG for the canvas
      	//translucent BG to show trail
      	ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
      	ctx.fillRect(0, 0, c.width, c.height);

      	ctx.fillStyle = "#0F0"; //green text
      	ctx.font = font_size + "px arial";
      	//looping over drops
      	for(var i = 0; i < drops.length; i++)
      	{
      		//a random number to print
      		var text = symbol[Math.floor(Math.random()*symbol.length)];
      		//x = i*font_size, y = value of drops[i]*font_size
      		ctx.fillText(text, i*font_size, drops[i]*font_size);

      		//sending the drop back to the top randomly after it has crossed the screen
      		//adding a randomness to the reset to make the drops scattered on the Y axis
      		if(drops[i]*font_size > c.height && Math.random() > 0.975)
      			drops[i] = 0;

      		//incrementing Y coordinate
      		drops[i]++;
      	}
      }
      setInterval(draw, 66);
      document.getElementById("launch_matrix").setAttribute("onclick","stop_matrix");
}

function stop_matrix(){
      //ctx.clearRect(0, 0, c.width, c.height);
      // var parent = document.body;
      // var child = document.getElementById(launch_matrix);
      // parent.removeChild(child);
      document.getElementById("launch_matrix").setAttribute("onclick","start_matrix");
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------MOSQUITO JQUERY-------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

var score_mosquito_killed=0;
var nb_boss=0;
        //-----création div+css puis appel à la fonction animateDiv3 sur click launchmosquito
$('#launch_mosquito').click(function(){
    create_mosquito();
    change_cursor_mosquito();
    make_score();
});

function create_mosquito(){
    var mosquitoA= $("<a>", {class: "mosquito_class",onclick:"kill_mosquito(this)"});
    $("body").append(mosquitoA);
    mosquitoA.css("position", "fixed");
    mosquitoA.css("width", "100px");
    mosquitoA.css("height", "100px");
    animateDiv3(mosquitoA);
    add_mosquitos();
    }




            //---création coordonnées de déplacement----
function makeNewPosition3(){
    var h = $(window).height() - 100;
    var w = $(window).width() - 100;
    var nh = Math.floor(Math.random() * h);
    var nw = Math.floor(Math.random() * w);
    return [nh,nw];

}

          //----déplacement avec les coordonnées reçu de makeNewPosition3----
function animateDiv3(mosquito){
    var newq = makeNewPosition3();
    var speed= Math.floor(Math.random() * 1000);
    mosquito.delay(speed).animate({ top: newq[0], left: newq[1] }, function(){
      animateDiv3(mosquito);
    });
};



        //ajout d'un new moustique
function add_mosquitos(){
      setTimeout(function(){
      var mosquitoA= $("<a>", {class: "mosquito_class",onclick:"kill_mosquito(this)"});
      $("body").append(mosquitoA);
      mosquitoA.css("position", "fixed");
      mosquitoA.css("width", "100px");
      mosquitoA.css("height", "100px");
      add_mosquitos();
      animateDiv3(mosquitoA);


    },2000);
}



function add_mosquito_boss(){
  var mosquitoBoss= $("<a>", {class: "mosquitoBoss_class",ondblclick:"kill_mosquito(this)"});
  mosquitoBoss.css("position", "fixed");
  mosquitoBoss.css("width", "100px");
  mosquitoBoss.css("height", "100px");
  $("body").append(mosquitoBoss);
  nb_boss++;
  animateDiv3(mosquitoBoss);

}



        //changement de curseur pour la tapette
function change_cursor_mosquito(){
    $(document.body).css({'cursor' : 'url(http://unsiterandom.ddns.net/Partie_Musique/Images/mosquito_cursor.cur), default'});
}



        //quand on kill le moustique on efface le lien+on incremente le compteur global
function kill_mosquito(mosquito_killed){
    mosquito_killed.remove();
    score_mosquito_killed++;
    $('#div_score').text("U killed "+score_mosquito_killed+" mosquitos and "+nb_boss+" boss spawned.");

    ////un boss pop tous les 10 kills
    if(score_mosquito_killed%10==0 && score_mosquito_killed!=0){
        add_mosquito_boss();
    }
}



        ///on créer le compteur de moustiques tués
function make_score(){
    var div_compteur= $("<div>", {id: "div_score"});
    div_compteur.css("position", "absolute");
    div_compteur.css("top", "20%");
    div_compteur.css("right", "0");
    div_compteur.css("width","200");
    div_compteur.css("height","50");
    div_compteur.css("border","3px solid black")
    //div_compteur.css("backgroundColor","green");
    $("body").append(div_compteur);
    div_compteur.text("U killed "+score_mosquito_killed+" mosquitos");
}

function add_bonus(){
    //autoclicker jquery when hover
    //.remove() all .mosquito_class when clicked


}
