window.onload = function(){


  /* Commence la page a l'index 1*/

    var ongletIndex = 1;

    showSlide(ongletIndex);

    /* incremente de 1 le slider*/
    /* Donne la classe a l'image courante */
    function currentSlide(n) {
    showSlide(ongletIndex = n);
    }
    $("[class*='ongletbtn']").click(function(){
        var b = this.className;
        var a = b.match(/(\d)/);
        if(a[0]){
            currentSlide(a[0]);

            localStorage.setItem('onglet',a[0]);
            
        }
    })


    function showSlide(n) {
    var i;
    /* recupere les images */
    var Slide = document.getElementsByClassName("onglets");

    /*  recupere les boutons */
    var button = document.getElementsByClassName("ongletbtn");
    
    /* Si la classe est > au nombre d'image retour a 1*/
    if (n > Slide.length) {ongletIndex = 1}

    /* Si la classe est < a 0 passe au dernier slide */
    if (n < 1) {ongletIndex = Slide.length}

    /* Display none toute les images */
    for (i = 0; i < Slide.length; i++) {
        Slide[i].style.display = "none";  
    }

    /* Enleve la classe active a tout les boutons */
    for (i = 0; i < button.length; i++) {
        button[i].className = button[i].className.replace("active", "");
    }

    /* Donne display block a l'image et active au bouton courant */
    Slide[ongletIndex-1].style.display = "block";  
    button[ongletIndex-1].className += " active";

    }

    $('.movie').append('<br><button>Ajouter a l\'historique</button>')
    $('.movie button').click(function(){
        var id = this.parentNode.id;
        console.log(id);
        var reponse = prompt('A quel ID voulez-vous ajouter ce film ?');
        if(reponse && !isNaN(reponse) && !isNaN(id))
        {
            $.ajax(
                {
                    type: "POST",
                    url: 'InsertHisto.php',
                    data: {
                        value: reponse,
                        idfilm: id,
                    },
                    success: val => 
                    {
                       
                        alert('Le film a bien ete ajouter a l\'historique');
                        console.log(val);
                        
                    }
                }); 
          
        }
        else if(reponse != null)
        {
            alert('Veuillez insérer une valeur valide')
        }
   
    })
    $('.ajout').click(function(){
        var reponse = prompt('Quel abonnement voulez-vous  ?\n 1 -> VIP \n 2 -> GOLD \n 3 -> Classic \n 4 -> Pass Day');
        var membre = $('#content div').attr('id');
        if(reponse > 4 || reponse < 1 || isNaN(reponse) || isNaN(membre))
        {
            alert('Veuillez entrer une valeur valide');
        }
        else
        {
            $.ajax(
                {
                    type: "POST",
                    url: 'InsertHisto.php',
                    data: {
                        value1: reponse,
                        value2: membre,
                        
                    },
                    success: val => 
                    {
                        
                        window.location.reload();
                        console.log(val);
                        
                    }
                }); 
        }

    })
    $('.suppr').click(function(){
        var membre = $('#content div').attr('id');
        if(!isNaN(membre))
        {
            $.ajax(
                {
                    type: "POST",
                    url: 'InsertHisto.php',
                    data: {
                        suprValue: membre,
                        
                    },
                    success: val => 
                    {
                        // val = JSON.parse(val);
                        window.location.reload();
                        console.log(val);
                        
                    }
                }); 
        }

        

    })

    $('.note').click(function(){
       var reponse =  prompt('Quel est votre avis sur ce film ? ')
       var membre = $('.note').attr('id');     
       var idfilmparent = $(this).parent().attr('id');
        
        if(reponse != null && !isNaN(membre))
        {
                $.ajax(
                    {
                        type: "POST",
                        url: 'InsertHisto.php',
                        data: {
                            com: reponse,
                            membre:membre,
                            idfilm:idfilmparent,
                        },
                        success: val => 
                        {
                            // val = JSON.parse(val);
                            window.location.reload();
                            console.log(val);
                            
                        }
                    }); 
        }
    })

    var select = document.getElementById('selector');
    console.log(select);
    select.addEventListener('change',function(){
       if(select.value == 'Genre')
       {
           $('#content').html('<ul id="genrelist"> Genres : <br> <li>Dramatic comedy</li><li>Science fiction</li><li>Drama</li><li>Documentary</li><li>Animation</li><li>Comedy</li><li>Fantasy</li><li>Action</li><li>Thriller</li>  <li>Adventure</li><li>Various</li><li>Historical</li><li>Romance</li><li>Western</li><li>Music</li><li>Musical</li><li>Horror</li><li>War</li><li>Unknow</li><li>Spying</li><li>Historical epic</li><li>Biography</li><li>Short film</li><li>Erotic</li><li>Karate</li><li>Program</li><li>Family</li> <li>Experimental</li> <li>Experimental Drame</li>  </ul>');
       }
    })


    
}