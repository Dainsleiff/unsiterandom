//--------------------Lazy load images----------------------


//spécifie qu'on scroll dans la div#scroller et pas la page elle même
//on commence a charger l'image 100 px avant qu'elle soit visible sur l'ecran
$("img.lazy").lazyload({container: $("#scroller"),threshold : 100});
//---------------------------------scroller--------------------------

var currentScroller;
var i=0;
function move_Scroll(scroll_id, value) {
  document.getElementById(scroll_id).scrollLeft += value;
}




//marche pas encore,c'est pour diminuer le mouvement jusqu'a arrêt en mouseout
function decrementeScroll(content, value){
  while (value>i) {
    document.getElementById(content).scrollLeft+(value - i);
    i=i+1;
  }
}
