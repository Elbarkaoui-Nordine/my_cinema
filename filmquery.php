<?php
if( isset($_GET['NOP']) && !empty($_GET['NOP']))
{

    $filmParPage = (int)$_GET['NOP'];
}
else
{
    $filmParPage = 10;
}
if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0){
    $_GET['page'] = intval($_GET['page']);
    $pagecourante = $_GET['page'];
}
else
{ 
    $pagecourante = 1;
}
$depart = ($pagecourante-1)*$filmParPage;
if(isset($_GET['filmValue']) && !empty($_GET['filmValue']))
{
    if(isset($_GET['selectFilm']) && !empty($_GET['selectFilm']))
    {
        if($_GET['selectFilm'] == 'Titre')
        {
            $count = $dbh->prepare('SELECT * from film where titre REGEXP :moninput');
            $count->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));
            $filmCount = $count->rowCount();
            if($filmCount == 0 ){
                echo '<p id="nofound">Aucun film trouver pour la recherche : '.$_GET['filmValue'].'</p>';
            }
            $pageTotal = ceil($filmCount/$filmParPage);  
            $req = $dbh->prepare('SELECT * from film where titre REGEXP :moninput ORDER BY titre LIMIT '.$depart.','.$filmParPage);
            $req->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));
    
            while($titre = $req->fetch()){
                
                echo "<div class='movie border' id='".$titre['id_film']."'><p id='titre'>".$titre['titre']."</p> Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."</div>";
            }
    
            if($pageTotal > 1)
            {
                echo "<div id='pagebtn'>";
                echo "<a href='index.php?page=1&filmValue=".$_GET['filmValue']."&selectFilm=Titre&NOP=".$filmParPage."'><button><<</button></a>";
                for($i = -4; $i < 5; $i++)
                {
                    if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
                    {
                        echo "<a href='index.php?page=".($pagecourante+$i)."&filmValue=".$_GET['filmValue']."&selectFilm=Titre&NOP=".$filmParPage."'><button>".($pagecourante+$i)."</button></a>";
                    }
                }
                echo "<a href='index.php?page=".$pageTotal."&filmValue=".$_GET['filmValue']."&selectFilm=Titre&NOP=".$filmParPage."'><button>>></button></a>";
                echo "</div>";
            }
        }
        elseif($_GET['selectFilm'] == 'Genre')
        {
            if(strtoupper(str_replace('é','e',(trim($_GET['filmValue'])))) == 'EXPERIMENTAL DRAME')
            {
                $_GET['filmValue'] = 'exp&amp;atilde;&amp;copy;rimental';
            }
            $count = $dbh->prepare('SELECT * from film LEFT JOIN genre ON film.id_genre = genre.id_genre where genre.nom = :moninput');
            $count->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));
            $filmCount = $count->rowCount();
            if($filmCount == 0 ){
                echo '<p id="nofound">Aucun film trouver pour la recherche : '.$_GET['filmValue'].'</p>';
            }
            $pageTotal = ceil($filmCount/$filmParPage); 
            $req = $dbh->prepare('SELECT * from film LEFT JOIN genre ON film.id_genre = genre.id_genre where genre.nom = :moninput ORDER BY titre LIMIT '.$depart.','.$filmParPage);
            $req->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));
            

            while($titre = $req->fetch()){
                echo "<div class='border movie' id=".$titre['id_film']."><p id='titre'>".$titre['titre']."</p> Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."</div>";
            }

            if($pageTotal > 1)
            {
                echo "<div id='pagebtn'>";
                echo "<a href='index.php?page=1&filmValue=".$_GET['filmValue']."&selectFilm=Genre&NOP=".$filmParPage."'><button><<</button></a>";
                for($i = -4; $i < 5; $i++)
                {
                    if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
                    {
                        echo "<a href='index.php?page=".($pagecourante+$i)."&filmValue=".$_GET['filmValue']."&selectFilm=Genre&NOP=".$filmParPage."'><button>".($pagecourante+$i)."</button></a>";
                    }
                }
                echo "<a href='index.php?page=".$pageTotal."&filmValue=".$_GET['filmValue']."&selectFilm=Genre&NOP=".$filmParPage."'><button>>></button></a>";
                echo "</div>";
            }
        }
        elseif($_GET['selectFilm'] == 'Distrib')
        {
            $count = $dbh->prepare('SELECT *  from film LEFT JOIN distrib ON distrib.id_distrib = film.id_distrib where distrib.nom REGEXP :moninput');
            $count->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));
            $filmCount = $count->rowCount();
            if($filmCount == 0 ){
                echo '<p id="nofound">Aucun film trouver pour la recherche : '.$_GET['filmValue'].'</p>';
            }
            $pageTotal = ceil($filmCount/$filmParPage); 
            $req = $dbh->prepare('SELECT *  from film LEFT JOIN distrib ON distrib.id_distrib = film.id_distrib where distrib.nom REGEXP :moninput ORDER BY titre LIMIT '.$depart.','.$filmParPage);
            $req->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmValue']))));

            while($titre = $req->fetch()){
                echo "<div class='border movie'><p id='titre'>".$titre['titre']."</p> Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."</div>";
            }
            if($pageTotal > 1)
            {
                echo "<div id='pagebtn'>";
                echo "<a href='index.php?page=1&filmValue=".$_GET['filmValue']."&selectFilm=Distrib&NOP=".$filmParPage."'><button><<</button></a>";
                for($i = -4; $i < 5; $i++)
                {
                    if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
                    {
                        echo "<a href='index.php?page=".($pagecourante+$i)."&filmValue=".$_GET['filmValue']."&selectFilm=Distrib&NOP=".$filmParPage."'><button>".($pagecourante+$i)."</button></a>";
                    }
                }
                echo "<a href='index.php?page=".$pageTotal."&filmValue=".$_GET['filmValue']."&selectFilm=Distrib&NOP=".$filmParPage."'><button>>></button></a>";
                echo "</div>";
            }

        }
    }
}
elseif(isset($_GET['membreValue']) && !empty($_GET['membreValue']))
{
        $count = $dbh->prepare('SELECT * from fiche_personne WHERE CONCAT_WS(" ", fiche_personne.nom, fiche_personne.prenom) LIKE "'.preg_replace('!\s+!', ' ',trim($_GET['membreValue'])).'" OR CONCAT_WS(" ", fiche_personne.prenom, fiche_personne.nom) LIKE :moninput');
        $count->execute(array(":moninput" => "%".preg_replace('!\s+!', ' ', trim($_GET['membreValue']))."%"));
        $filmCount = $count->rowCount();
        if($filmCount == 0 ){
            echo '<p id="nofound">Aucun membre trouver pour la recherche : '.$_GET['membreValue'].'</p>';
        }
        $pageTotal = ceil($filmCount/$filmParPage);  

        $req = $dbh->prepare('SELECT * from fiche_personne WHERE CONCAT_WS(" ", fiche_personne.nom, fiche_personne.prenom) LIKE "'.preg_replace('!\s+!', ' ',trim($_GET['membreValue'])).'" OR CONCAT_WS(" ", fiche_personne.prenom, fiche_personne.nom) LIKE :moninput LIMIT '.$depart.','.$filmParPage);  
        $req->execute(array(":moninput" => "%".preg_replace('!\s+!', ' ', trim($_GET['membreValue']))."%"));

        while($titre = $req->fetch()){
            echo "<div class='border card'><p id=size> ID Perso : ".$titre['id_perso']."<br> nom : ".$titre['nom']."<br>Prenom : ".$titre['prenom']."<br>Date de naissaince : ".substr($titre['date_naissance'],0,-8)."<br>Email : ".$titre['email']."<br>Code Postale : ".$titre['cpostal']." Ville : ".$titre['ville'].'
            </p><a href="index.php?histoId='.$titre['id_perso'].'&histoNom='.$titre['nom'].'&histoPrenom='.$titre['prenom'].'&NOP='.$_GET['NOP'].'"><button>Afficher l\'historique</button></a><br></div>';
        }
        if($pageTotal > 1)
        {
            echo "<div id='pagebtn'>";
            echo "<a href='index.php?page=1&membreValue=".$_GET['membreValue']."&NOP=".$filmParPage."'><button><<</button></a>";
            for($i = -4; $i < 5; $i++)
            {
                if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
                {
                    echo "<a href='index.php?page=".($pagecourante+$i)."&membreValue=".$_GET['membreValue']."&NOP=".$filmParPage."'><button>".($pagecourante+$i)."</button></a>";
                }
            }
            echo "<a href='index.php?page=".$pageTotal."&membreValue=".$_GET['membreValue']."&NOP=".$filmParPage."'><button>>></button></a>";
            echo "</div>";
        }
    
    
}

elseif(isset($_GET['histoId']) && !empty($_GET['histoId']) && isset($_GET['histoNom']) && !empty($_GET['histoNom']) && isset($_GET['histoPrenom']) && !empty($_GET['histoPrenom']))
{

    //SELECT * FROM `membre` LEFT JOIN historique_membre ON historique_membre.id_membre = membre.id_membre WHERE id_fiche_perso = '45' 
    /*SELECT membre.id_membre FROM `membre` LEFT JOIN historique_membre ON historique_membre.id_membre = membre.id_membre LEFT JOIN film ON film.id_film = historique_membre.id_film LEFT JOIN fiche_personne ON fiche_personne.id_perso = membre.id_fiche_perso WHERE id_fiche_perso = '250'
    */
    $count = $dbh->query('SELECT film.id_film FROM `membre` LEFT JOIN historique_membre ON historique_membre.id_membre = membre.id_membre LEFT JOIN film ON film.id_film = historique_membre.id_film WHERE id_fiche_perso = "'.$_GET['histoId'].'" AND  historique_membre.id_film IS NOT NULL');
    $filmCount = $count->rowCount();
    $pageTotal = ceil($filmCount/$filmParPage);
    $req = $dbh->query('SELECT * FROM `membre` LEFT JOIN historique_membre ON historique_membre.id_membre = membre.id_membre LEFT JOIN film ON film.id_film = historique_membre.id_film WHERE id_fiche_perso = "'.$_GET['histoId'].'"  AND  historique_membre.id_film IS NOT NULL  LIMIT '.$depart.', '.$filmParPage); 
    
    if($filmCount > 0 )
    {
        echo '<p id="nofound">Historique de '.$_GET['histoNom'].' '. $_GET['histoPrenom'].':<p>';
        while($titre = $req->fetch()){

            echo "<div class='border' id='".$titre['id_film']."'><a id='titre' href='index.php?filmid=".$titre['id_film']."'>".$titre['titre']."</a><br>Vue le :".substr($titre['date'],0,-8);

            if(!empty($titre['Avis']))
            {
                echo '<br>Votre avis : '.$titre['Avis'];
            }

            if(!empty($titre['Note']))
            {
                echo '<br>';
                $gris = (5-$titre['Note']);
                for($i = 0; $i < $titre['Note']; $i++)
                {
                    echo '<span class="fa fa-star checked"></span>';
                }
                for($i = 0; $i < $gris; $i++)
                {
                    echo '<span class="fa fa-star"></span>';
                }
            }
            else
            {
                echo '<br>';
                for($i = 0; $i < 5; $i++)
                {
                    echo '<span class="fa fa-star"></span>';
                } 
                
            }
            
            echo "<br>Notez ce film :
            <button id='".$titre['id_membre']."'class='note'>Donner votre avis</button>
            <form  method='GET' action='index.php'>
            <select name='addnote' id='selector' onchange='this.form.submit()'>";

            for($i = 0 ; $i < 6 ; $i++){
             echo  "<option value='".$i."|".$titre['id_membre']."|".$titre['id_film']."|".$titre['titre'];
                if(isset($titre['Note']) && $titre['Note'] == $i ){
                    echo "'selected='true'";
                }
    
                echo "'>".$i."</option>";
            }
            echo "</select>
            </form>
            </div>
               "; 
         }
    }
    else
    {
        echo '<p id="nofound"> Pas d\'historique trouver pour : '.$_GET['histoNom'].' '. $_GET['histoPrenom']."</p>";
        
    }
    
    if($pageTotal > 1)
    {
        echo "<div id='pagebtn'>";
        echo "<a href='index.php?page=1&histoId=".$_GET['histoId']."&histoNom=".$_GET['histoNom']."&histoPrenom=".$_GET['histoPrenom']."&NOP=".$_GET['NOP']."'><button><<</button></a>";
        for($i = -4; $i < 5; $i++)
        {
            if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
            {
                echo "<a href='index.php?page=".($pagecourante+$i)."&histoId=".$_GET['histoId']."&histoNom=".$_GET['histoNom']."&histoPrenom=".$_GET['histoPrenom']."&NOP=".$_GET['NOP']."'><button>".($pagecourante+$i)."</button></a>";
            }
        }
        echo "<a href='index.php?page=".$pageTotal."&histoId=".$_GET['histoId']."&histoNom=".$_GET['histoNom']."&histoPrenom=".$_GET['histoPrenom']."&NOP=".$_GET['NOP']."'><button>>></button></a>";
        echo "</div>";
    }
  
            
}
elseif(isset($_GET['filmTitre']) && !empty($_GET['filmTitre']))
{
    $req = $dbh->prepare('SELECT * from film where titre = :moninput');
    $req->execute(array(":moninput" => preg_replace('!\s+!', ' ', trim($_GET['filmTitre']))));
    
    while($titre = $req->fetch()){
        echo "<div class='border'><p id='titre'>".$titre['titre']."</p> Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."</div>";
    }
}
elseif(isset($_GET['aboName']) && !empty($_GET['aboName']))
{
    $_GET['aboName'] = (int)$_GET['aboName'];
    $req = $dbh->prepare('SELECT id_fiche_perso, id_membre, fiche_personne.nom, fiche_personne.prenom, abonnement.id_abo, abonnement.nom as abonom FROM fiche_personne LEFT JOIN membre ON fiche_personne.id_perso = membre.id_fiche_perso LEFT JOIN abonnement ON abonnement.id_abo = membre.id_abo WHERE id_fiche_perso = :moninput ORDER BY id_fiche_perso');
    $req->execute(array(":moninput" => trim($_GET['aboName'])) );
    $filmCount = $req->rowCount();
    if($filmCount == 0 ){
        echo '<p id="nofound">Aucun film trouver pour la recherche : '.$_GET['aboName'].'</p>';
    }
    while($titre = $req->fetch()){

        if(!$titre['id_abo'] == 0 )
        {
            echo  "<div class='border' id=".$titre['id_membre']."><p id='aboinfo'>Abonnement de  ".$titre['nom']." ".$titre['prenom']."<br> Abonnement ID : ".$titre['id_abo']."<br> Type d'abonnement : ".$titre['abonom']."</p>  <ul>   <li><button class='ajout'><span>&#128295 </span>Modifier</button></li><li><button class='suppr'><span> 	&#128465; </span>  Supprimer</button></li></ul></div>";
         
        }
        else
        {
            echo "<div class='border' id=".$titre['id_membre']."><p id='aboinfo'>".$titre['nom']." ".$titre['prenom']." n'a pas d'abonnement </p><ul><li><button class='ajout'><span>	

            &#65291; </span>Ajouter</button></li></ul></div>";
        }
        
    } 
}
elseif(isset($_GET['addnote']) && !empty($_GET['addnote']))
{
    $result = $_GET['addnote'];
    $result_explode = explode('|', $result);
    if( count($result_explode) == 4){
        $note =  (int)$result_explode[0];
        $idmembre = (int)$result_explode[1];
        $film = (int)$result_explode[2];
        $titre = $result_explode[3];

        echo  "<p class='center border'>Le film ".$titre."  a ete noter ".$note;
        echo "<br><a href=\"javascript:history.go(-1)\">Retour a l'historique</a></p>";
        $req = $dbh->prepare('UPDATE historique_membre SET Note = :note WHERE  id_membre = :idmembre AND id_film = :film');
        $req->execute(array(":note" => $note , ':idmembre' => $idmembre , ":film" => $film));
    }


    
  
}elseif(isset($_GET['filmid']) && !empty($_GET['filmid']))
{
    $_GET['filmid'] = (int)$_GET['filmid'];
    $req = $dbh->prepare('SELECT * from film where id_film = :moninput');
    $req->execute(array(":moninput" => $_GET['filmid']) );
    while($titre = $req->fetch()){
        echo "<div class='border'><p id='titre'>".$titre['titre']."</p> Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."</div>";
    }
}
elseif(isset($_GET['projection']) && !empty($_GET['projection']))
{
    $count = $dbh->prepare('SELECT * from film where date_debut_affiche <= :debut AND date_fin_affiche >= :debut');
    $count->execute(array(":debut" => $_GET['projection']));
    $filmCount = $count->rowCount();
    $pageTotal = ceil($filmCount/$filmParPage); 
    $req = $dbh->prepare('SELECT * from film where date_debut_affiche <= :debut AND date_fin_affiche >= :debut LIMIT '.$depart.','.$filmParPage);
    $req->execute(array(":debut" => $_GET['projection']));
    while($titre = $req->fetch()){
        echo "<div class='border'><p id='titre' >".$titre['titre']."</p>Resume : ".$titre['resum']."<br> Annee de production : ".$titre['annee_prod']." Duree du film : ".$titre['duree_min']."<br>Date de projection : ".$titre['date_debut_affiche']." au ".$titre['date_fin_affiche']."</div>";
    }
    if($pageTotal > 1)
    {
        echo "<div id='pagebtn'>";
        echo "<a href='index.php?page=1&projection=".$_GET['projection']."&NOP=".$filmParPage."'><button><<</button></a>";
        for($i = -4; $i < 5; $i++)
        {
            if(($pagecourante+$i) > 0 && ($pagecourante+$i) <= $pageTotal)
            {
                echo "<a href='index.php?page=".($pagecourante+$i)."&projection=".$_GET['projection']."&NOP=".$filmParPage."'><button>".($pagecourante+$i)."</button></a>";
            }
        }
        echo "<a href='index.php?page=".$pageTotal."&projection=".$_GET['projection']."&NOP=".$filmParPage."'><button>>></button></a>";
        echo "</div>";
    }
}
elseif(isset($_GET['projection']) && empty($_GET['projection']) || isset($_GET['filmid']) && empty($_GET['filmid']) || isset($_GET['addnote']) && empty($_GET['addnote']) || isset($_GET['aboName']) && empty($_GET['aboName']) || isset($_GET['filmTitre']) && empty($_GET['filmTitre']) || isset($_GET['histoId']) && empty($_GET['histoId']) || isset($_GET['histoNom']) && empty($_GET['histoNom']) || isset($_GET['histoPrenom']) && empty($_GET['histoPrenom']) || isset($_GET['membreValue']) && empty($_GET['membreValue']) || isset($_GET['filmValue']) && empty($_GET['filmValue']))
{
    echo '<p id="error">Veuillez entrer une information correcte</p>';
    echo '<img src="wait.gif">';
}
?>