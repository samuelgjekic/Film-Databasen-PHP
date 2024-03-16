<?php 
      /* Detta är huvudsidan, nedan använder vi oss av våran movies_module.php klass för att
      lätt hämta alla filmer från databasen, med hjälp av den kan vi även lägga till nya filmer och 
      även ta bort filmerna */ 
      require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
      require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/movies_module.php';

      // Vi skapar ett nytt objekt med movies_module klassen. 
      $module = new MoviesModule(); 

      // Vi hämtar alla filmer med våran funktion vi skapade.
      $movies = $module->getAllMovies(); 

      // Nedan använder vi oss av GET för att ta bort en film från databasen
      if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        /* Vi kollar om värderna existerar först och främst, sedan fortsätter vi genom att använda
         deleteMovie funktionen i movies_module.php */
        $movieId = htmlspecialchars($_GET['id']);
        $status = $module->deleteMovie($movieId);
      }

      // Vi använder oss av POST i formuläret för att lägga till en ny film i databasen
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $year = htmlspecialchars($_POST['year']);
        $category = htmlspecialchars($_POST['category']);
        $status = $module->addMovie($title,$year,$category,$author);
      }
      ?>
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skapa en film</title>
  <!-- CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/css/styles.css">
</head>
<body>

  <div class="header">
    <h1><?= pagetitle // För att lätta printa en defined string kan vi använda oss av <?= ?></h1>
  </div>

<div class="container">
  <h2><br>Lista över filmer</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Titel</th>
        <th>Regissör</th>
        <th>År</th>
        <th>Genre</th>
        <th>Åtgärder</th> <!-- Added a new column for actions -->
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($movies)) : ?>
        <?php foreach ($movies as $movie) : ?>
          <tr>
            <td><?= $movie['title'] ?></td>
            <td><?= $movie['author'] ?></td>
            <td><?= $movie['year'] ?></td>
            <td><?= $movie['category'] ?></td>
            <td>
              <!-- Länk till edit.php med parameter -->
              <a href="edit.php?id=<?= $movie['id'] ?>" class="btn btn-sm btn-primary">Redigera</a>
              <!-- "Ta bort" knapp, med get parametrar -->
              <a href="?action=delete&id=<?= $movie['id'] ?>" class="btn btn-sm btn-danger">Ta bort</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="5"><span style="color:red;">Inga filmer hittades</span></td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div> 

 <!-- Formulär för att skapa ny film i databasen -->
<div class="container form-container"><br>
  <div class="card">
    <div class="card-body">
      <form method="post">
      <h3>Lägg till film</h3><br>
        <div class="form-group">
          <label for="title">Titel:</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Ange filmtitel" required>
        </div>
        <div class="form-group">
          <label for="director">Regissör:</label>
          <input type="text" class="form-control" id="author" name="author" placeholder="Ange regissör" required>
        </div>
        <div class="form-group">
          <label for="year">År:</label>
          <input type="number" class="form-control" id="year" name="year" placeholder="Ange år" required>
        </div>
        <div class="form-group">
    <label for="category">Genre:</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="skrack" name="category" value="1" required>
        <label class="form-check-label" for="skrack">Skräck</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="komedi" name="category" value="2">
        <label class="form-check-label" for="komedi">Komedi</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="animerat" name="category" value="3">
        <label class="form-check-label" for="animerat">Animerat</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="action" name="category" value="4">
        <label class="form-check-label" for="action">Action</label>
    </div>
</div>
        <button type="submit" class="btn btn-primary">Skapa film</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
