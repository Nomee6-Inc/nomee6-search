var rawFile = new XMLHttpRequest();
rawFile.open("GET", "language.json", false);
rawFile.onreadystatechange = function ()
{
   var allText = rawFile.responseText;
}
rawFile.send(null);
var jsonfile = rawFile.responseText;
var arrLang = JSON.parse(jsonfile);

$(document).ready(function() {
   var lang = localStorage.getItem('lang') || navigator.language.slice(0, 2);
   $(".lang").each(function(index, item) {
     $(this).text(arrLang[lang][$(this).attr("key")]);
   });
 });
 $(function() {
      $(".translate").click(function() {
        localStorage.setItem('lang', $(this).attr('id'));
        var lang = localStorage.getItem('lang') || navigator.language.slice(0, 2);
     $(".lang").each(function(index, item) {
          $(this).text(arrLang[lang][$(this).attr("key")]);
    });
  });
 });