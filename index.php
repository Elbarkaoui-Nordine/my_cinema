<? include('bdd.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class='onglet header'>
        <h1 id='title'>(NORDINE MOVIES)</h1>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary ongletbtn 1">Film</button>
                <button  type="button" class="btn btn-secondary ongletbtn 2">Membre</button>
                <button  type="button" class="btn btn-secondary ongletbtn 3">Abonnement</button>
                <button  type="button" class="btn btn-secondary ongletbtn 4">Projection</button>
            </div>

    

        <form action="index.php" method="GET" class='onglets'>
            <label for="filmValue">Trouver un film : </label><input type="text" name='filmValue'>
            <span>Par : </span> 
            <select name="selectFilm" id="selector">
                <option <?php if (isset($_GET['filmValue']) && isset($_GET['selectFilm'])){ if($_GET["selectFilm"] == "Titre") { ?>selected="true" <?php }; }?> value="Titre">Titre</option>
                <option <?php if (isset($_GET['filmValue']) && isset($_GET['selectFilm']) ){ if($_GET["selectFilm"] == "Genre") { ?>selected="true" <?php };} ?> value="Genre">Genre</option>
                <option <?php if (isset($_GET['filmValue'])  && isset($_GET['selectFilm'])){ if($_GET["selectFilm"] == "Distrib") { ?>selected="true" <?php };} ?>value="Distrib">Distributeur</option>
            </select>
            <select name="NOP" id="NOP">
                <option <?php if (isset($_GET["NOP"]) && $_GET["NOP"] == "5") { ?>selected="true" <?php }; ?> value="5">5</option>
                <option <?php if (isset($_GET['NOP']) && $_GET["NOP"] == "10") { ?>selected="true" <?php }; ?> value="10">10</option>
                <option <?php if (isset($_GET['NOP']) && $_GET["NOP"] == "15") { ?>selected="true" <?php }; ?> value="15">15</option>         
            </select>
     
            <input type="submit"   value='valider'>
        </form>

        <form action="index.php" method="GET" class='onglets'>
            <label for="membreValue">Trouver un membre : </label><input type="text" name='membreValue'>
            <select name="NOP" id="NOP">
                <option <?php if (isset($_GET["NOP"]) && $_GET["NOP"] == "5") { ?>selected="true" <?php }; ?> value="5">5</option>
                <option <?php if (isset($_GET['NOP']) && $_GET["NOP"] == "10") { ?>selected="true" <?php }; ?> value="10">10</option>
                <option <?php if (isset($_GET['NOP']) && $_GET["NOP"] == "15") { ?>selected="true" <?php }; ?> value="15">15</option>         
            </select>
            <input type="submit" value='valider'>
            
        </form>

        <form action="index.php" method="GET" class='onglets'>
            <label for="aboName"> Abonnement par ID perso :  </label><input type="text" name='aboName'>   
             <input type="submit" value='valider'>
        </form>

        <form action="index.php" method="GET" class='onglets'>
            <label for="projection">Quels films passent ce soir ? <input <? if (isset($_GET["projection"]) && !empty($_GET["projection"])){ echo "value='".$_GET['projection']."'"; } ?>type="date" name="projection"> </label>
            <select name="NOP" id="NOP">
                <option <?php if (isset($_GET["NOP"])){ if($_GET["NOP"] == "5") { ?>selected="true" <?php }; }?> value="5">5</option>
                <option <?php if (isset($_GET["NOP"])){ if($_GET["NOP"] == "10") { ?>selected="true" <?php }; } ?> value="10">10</option>
                <option <?php if (isset($_GET["NOP"])){ if($_GET["NOP"] == "15") { ?>selected="true" <?php }; }?> value="15">15</option>         
            </select>
            <input type="submit" value='valider'>
        </form>
        </div>
     
        <div id='content'>

        <?     include('filmquery.php');    ?>
        </div>

    </div>
    

    <script src='script.js'></script>
</body>
</html>