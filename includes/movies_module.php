<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once dbconn;

class MoviesModule {
/* Denna klass innehåller alla funktioner relaterade till film objektet, här kan vi
hämta alla filmer från databasen, lägga till nya osv. */ 

public function getAllMovies() {
    // Huvudfunktion för att hämta alla filmer, vi använder oss av join för att lätt hämta kategori baserat på id.
    global $dbconn; // Vi använder oss av $dbconn i dbconn.php så vi måste göra den global.
    $sql = "SELECT movies.id,movies.title, movies.year, categories.category ,movies.author
    FROM movies
    JOIN categories ON movies.category = categories.id";

    // Vi skapar ett prepared statement
    $query = $dbconn->prepare($sql); 
    $query->execute(); // Vi kör vårat prepared sql statement
    $query->bind_result($id,$title,$year,$category,$author); // Vi binder resultaten till variablar

    // Nu ska vi hämta resultaten
    $movie = []; // array
    // Nedan hämtar vi resultatet, sedan lägger vi in filmen i en array. 
    while ($query->fetch() ) {
    $movie = [
        'title'=> $title,
        'year'=> $year,
        'category'=> $category,
        'author' => $author,
        'id' => $id,
    ];
    $movies[] = $movie; // För varje film så lägger vi in den i en array
    }
    $query ->close(); // Vi avslutar statement
    if(empty($movies)) {
        // Om vi inte hittar några filmer i databasen, returera null array, om vi inte returerar någon array kommer vi få en php error
        return [];
    }
    return $movies; // Skicka tillbaka array med alla filmer. 
}

public function getMovieById($id){
    // Denna funktion hämtar en specifik film från databasen baserat på id.
    global $dbconn;
    $sql = 'SELECT * FROM movies WHERE id=?';
    $query = $dbconn->prepare($sql);
    $query->bind_param('i', $id);
    if($query->execute()) {
    // Efter vi har kört ett prepared SQL statement så hämtar vi resultatet
    $result = $query->get_result();
    $movie = $result->fetch_assoc();
    $query->close();
    return $movie;
    } else {
    return null;
    }
}

public function deleteMovie($id){
    // Funktion för att ta bort en film från databasen
    global $dbconn;
    $sql = 'DELETE FROM movies WHERE id = ?';
    $query = $dbconn->prepare($sql);
    $query->bind_param('i',$id); // Vi använder denna gången 'i' istället för 's', då det är en INT vi ska binda.
    if($query->execute()) {
        // Film togs bort utan errors, ladda om index.php
        $query ->close(); 
        header('Location: index.php');
        return true;
    } else {
        // Filmen kunde inte tas bort, ladda om index.php
        $query ->close();
        header('Location: index.php');
        return false;
    }
}

public function addMovie($title,$year,$category,$author){
    // Denna funktion lägger till filmer i databasen
    global $dbconn;
    $sql = 'INSERT INTO movies (title,year,category,author) VALUES (?,?,?,?)';
    $query = $dbconn->prepare($sql); 
    $query->bind_param('ssss',$title,$year,$category,$author);
    if($query->execute()){
        // Om filmen har lagts till i databas utan problem, ladda om sidan.
        $query ->close();
        header('Location: index.php');
        return true;
    } else {
        // Filmen kunde inte läggas till, ladda om sidan.
        $query ->close();
        header('Location: index.php');
        return false;
    }
}

public function updateMovieById($id,$title,$year,$category,$author){
    // Denna funktion uppdaterar en existerande film i databasen baserat på id.
    global $dbconn;
    $sql = 'UPDATE movies SET title=?, year=?, category=?, author=? WHERE id=?'; // SQL Query som ska köras i prepared statement för att uppdatera existerande film i databas.
    $query = $dbconn->prepare($sql);
    $query->bind_param(('ssssi'),$title,$year,$category,$author,$id);
    $query->execute();
    if($query->affected_rows > 0){ 
        // Film har redigerats. Återvänd till index.php
        $query->close();
        header('Location: index.php');
        return true;
    } else { 
        // Film har inte redigerats.
        $query->close();
        header('Location: index.php');
        return false;}

}
}
