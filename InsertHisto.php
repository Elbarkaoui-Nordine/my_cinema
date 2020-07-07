<? include('bdd.php');

if(isset($_POST['value']) && isset($_POST['idfilm'] )){
   
    $id_membre = $_POST['value'];
    $id_film = $_POST['idfilm'];
    $sth = $dbh->prepare("INSERT INTO historique_membre (id_membre, id_film, date,Note,Avis) VALUES (:idmembre,:idfilm,NOW(),0,'')");
    $sth->execute(array(":idmembre" => $id_membre, ":idfilm" => $id_film));
    $rep = $dbh->prepare('SELECT date FROM historique_membre where id_membre= :val ORDER BY date DESC LIMIT 1');
    $rep->execute(array(":val" => $_POST['value']));
    while($result = $rep->fetch()){
        $a = $result;
    }
    $req = $dbh->prepare('UPDATE membre SET id_dernier_film = :idmembre, date_dernier_film = "'.$a['date'].'" WHERE id_membre = :idfilm ');
    $req->execute(array(":idmembre" => $id_membre, ":idfilm" => $id_film));
    echo $_POST['value'].' '.$_POST['idfilm'];
}
elseif(isset($_POST['value1']) && isset($_POST['value2']))
{

    $req = $dbh->prepare('UPDATE membre SET id_abo = :val1, date_abo= NOW() WHERE id_membre = :val2');
    $req->execute(array(":val1" => $_POST['value1'], ":val2" => $_POST['value2']));
    echo 'CHANGEMENT EFFECUTER';
    
}
elseif(isset($_POST['suprValue']))
{
    $req = $dbh->prepare('UPDATE membre SET id_abo ="0", date_abo= NOW() WHERE id_membre = :suprVal');
    $req->execute(array(":suprVal" => $_POST['suprValue']));
    echo 'CHANGEMENT EFFECUTER'; 
}
elseif(isset($_POST['com']) && !empty($_POST['com']))
{
    $req = $dbh->prepare('UPDATE historique_membre SET  Avis = :avis WHERE id_membre = :membre AND id_film =  :idfilm');
    $req->execute(array(":avis" => $_POST['com'], ":membre" => $_POST['membre'] , ":idfilm" => $_POST['idfilm']));
    echo $_POST['membre'].' '.$_POST['idfilm'];
}