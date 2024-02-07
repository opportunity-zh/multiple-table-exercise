<?php
/*
    INCLUDE DATABASE CONNECTION
*/
include('utils/db.php');

$queryString = "SELECT * FROM books WHERE published_at IS NULL";
$data = [];
$count = 0;


if($count = count($_GET) > 0) {
    $queryString .= " WHERE";
}


if(isset($_GET['title'])){
    $queryString .= "title LIKE :title";
    $data[':title'] = "%" . $_GET['title'] . "%"; 
}

if(isset($_GET['genre'])){
    $queryString = "SELECT * FROM books WHERE title LIKE :title";
    $data[':title'] = "%" . $_GET['title'] . "%"; 
}


/*
    DER QUERY WIRD AUSGEFÜHRT
    Die verschiedenen Schritte für PDO
*/

try{

    // überprüfe, ob Abfrage vorhanden ist
    if($queryString == ''){
        throw new \Exception('keine Abfrage in $queryString vorhanden');
    }

    // bereite die Abfrage vor
    $query = $dbConn->prepare($queryString);

    // füge Daten für Platzhalter ein, falls vorhanden
    $query->execute($data);

    // überprüfe, ob Daten zurück gegeben werden
    if($query->rowCount() == 0) {
        throw new \Exception('Deine Abfrage gibt keine Daten zurück');
    }

    // alle Daten werden aus der DB geholt und in einem assoziativen Array gespeichert
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

 
    

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}

catch (\Exception $e) {
    die("Fehler: " . $e->getMessage());
}

