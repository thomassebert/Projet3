$(document).ready(function(){
      $('.parallax').parallax();
    });


function pagination(page)
{
	var episodes = document.getElementsByClassName('episodes');

	page = page - 1;

	for (var i = 0; i < episodes.length; i++) 
	{
		if($.inArray( episodes[i], episodes )  !== -1)
		{
			episodes[i].classList.add("hide");
		}
		
	}

	for (var i = (page*6); i < (page*6)+6; i++) 
	{
		if($.inArray( episodes[i], episodes )  !== -1)
		{
			episodes[i].classList.remove("hide");
		}
	}

}

$(document).ready(function()
{

	var listePages = document.getElementById('pagination');
	var episodes = document.getElementsByClassName('episodes');
	var nombre = '1';

	for (var i = 0; i <= episodes.length; i++) {
		if ((i % 6) === 0) 
		{
			listePages.innerHTML += '<li class="boutonPage waves-effect" numeropage="'+nombre+'">'+nombre+'</li><br/>'
			nombre ++;
		}
	}
	

    pagination(1);	

    var boutonsPage = document.getElementsByClassName('boutonPage');

    boutonsPage[0].classList.add("active");

    for (var i = 0 ; i < boutonsPage.length; i++) {
    	if($.inArray( boutonsPage[i], boutonsPage ) !== -1)
    	{

      		boutonsPage[i].addEventListener("click", function(e)
      		{
      			 for (var a = 0 ; a < boutonsPage.length; a++) 
      			 {
    				if($.inArray( boutonsPage[a], boutonsPage ) !== -1)
    				{
    					boutonsPage[a].classList.remove("active");
    				}
    			}
      			e.target.classList.add("active");
    			var numeroPage = e.target.getAttribute("numeropage");
    			var numeroPage = Number(numeroPage);
      			pagination(numeroPage);
      		});
    	}
    	
    }
    
});



