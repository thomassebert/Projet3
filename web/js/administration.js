tinymce.init({
  selector: 'textarea',
  language_url : '/js/fr_FR.js',
  language: 'fr_FR',
  height: 500,
  theme: 'modern',
  branding: false,
  skin_url: '/css/custom/',
  skin: "charcoal",
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert link image media | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print | forecolor backcolor | searchreplace fullscreen',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });

 $(document).ready(function() {
    $('select').material_select();
  });

 $(document).ready(function(){
    $('.collapsible').collapsible();
  });

$(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });


$(document).ready(function(){
var boutonsSupprimer = document.getElementsByClassName("modal2");
var boutonConfirmationSuppression = document.getElementById("suppressionEpisode");
for(var i=0; i<boutonsSupprimer.length; i++)
{
		boutonsSupprimer[i].addEventListener("click", function(e)
		{
			var lienSource = e.target.getAttribute("lien");
			boutonConfirmationSuppression.setAttribute("href", lienSource);
		});
}
 });

$(document).ready(function(){
var boutonsSupprimer = document.getElementsByClassName("modal3");
var boutonConfirmationSuppression = document.getElementById("suppressionCommentaire");
for(var i=0; i<boutonsSupprimer.length; i++)
{
		boutonsSupprimer[i].addEventListener("click", function(e)
		{
			var lienSource = e.target.getAttribute("lien");
			boutonConfirmationSuppression.setAttribute("href", lienSource);
		});
}
 });

$(document).ready(function(){
var boutonsSupprimer = document.getElementsByClassName("modal4");
var boutonConfirmationSuppression = document.getElementById("suppressionSignalement");
console.log(boutonsSupprimer);
console.log(boutonConfirmationSuppression);
for(var i=0; i<boutonsSupprimer.length; i++)
{
		boutonsSupprimer[i].addEventListener("click", function(e)
		{
			var lienSource = e.target.getAttribute("lien");
			boutonConfirmationSuppression.setAttribute("href", lienSource);
		});
}
 });


$(document).ready(function(){
var boutonsSupprimer = document.getElementsByClassName("modal5");
var boutonConfirmationSuppression = document.getElementById("restaurationEpisode");
for(var i=0; i<boutonsSupprimer.length; i++)
{
    boutonsSupprimer[i].addEventListener("click", function(e)
    {
      var lienSource = e.target.getAttribute("lien");
      boutonConfirmationSuppression.setAttribute("href", lienSource);
    });
}
 });

$(document).ready(function(){
var boutonsSupprimer = document.getElementsByClassName("modal6");
var boutonConfirmationSuppression = document.getElementById("restaurationCommentaire");
for(var i=0; i<boutonsSupprimer.length; i++)
{
    boutonsSupprimer[i].addEventListener("click", function(e)
    {
      var lienSource = e.target.getAttribute("lien");
      boutonConfirmationSuppression.setAttribute("href", lienSource);
    });
}
 });