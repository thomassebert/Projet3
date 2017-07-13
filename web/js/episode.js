$(document).ready(function() {
    Materialize.updateTextFields();
  });


$(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });

$(document).ready(function(){
var champIdCommentaireReponse = document.getElementById("formulaire_commentaire_id_commentaire_reponse");
var champNiveauCommentaire = document.getElementById("formulaire_commentaire_niveau_commentaire");
var champSignalement = document.getElementById("formulaire_commentaire_signalement");
var boutonsReponse = document.getElementsByClassName("modalbutton");
for(var i=0; i<boutonsReponse.length; i++)
{
		boutonsReponse[i].addEventListener("click", function(e)
		{
			var idCommentaire = e.target.getAttribute("idcommentaire");
			var niveauCommentaire = e.target.getAttribute("niveaucommentaire");
			var signalement = e.target.getAttribute("signalement");
			if(signalement === 'oui')
			{
				document.getElementById('commentaireOuSignalement').innerHTML = 'Signalez un commentaire';
			}
			else
			{
				document.getElementById('commentaireOuSignalement').innerHTML = "Commentez l'épisode";
			}
			champIdCommentaireReponse.setAttribute('value', idCommentaire);
			champNiveauCommentaire.setAttribute('value', niveauCommentaire);
			champSignalement.setAttribute('value', signalement);
		});
}
 });