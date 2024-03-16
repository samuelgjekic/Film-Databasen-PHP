<?php 
      /* Detta är sidan där man redigerar en existerande film i databasen, den laddar in alla values från rätt ID
      och visar dom infyllda i formuläret, man kan sedan ändra värderna och spara i databasen */ 
      require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
      require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/movies_module.php';
      
      $module = new MoviesModule();
      // Om ingen ID angivits när URL har slagits in avbryt scriptet.
      if (!isset($_GET['id'] ) || $_GET['id'] == '') { exit('Ingen id som parameter, avbryter script...'); }

      /*  Eftersom ovan kod avbryter scriptet om ingen id hittats, kan vi anta att nedan endast körs
      om id har hittats */
      $id = htmlspecialchars($_GET['id']);
      $movie = $module->getMovieById($id);
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = htmlspecialchars($_POST['title']);
        $year = htmlspecialchars($_POST['year']);
        $category = htmlspecialchars($_POST['category']);
        $author = htmlspecialchars($_POST['author']);
        $status = $module->updateMovieById($id,$title,$year,$category,$author); // Kör funktionen i movies_module.php för att uppdatera filmen i db.
      }
?>
      
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skapa en film</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/css/styles.css">
</head>
<body>

  <div class="header">
    <h1><?= pagetitle // För att lätta printa en defined string kan vi använda oss av <?= ?></h1>
  </div>

  <!-- Formulär för att redigera en film, värderna hämtas först och fylls i för snyggare upplevelse -->
<div class="container form-container"><br>
  <div class="card">
    <div class="card-body">
      <form method="post">
        <h3>Redigera film</h3><br>
        <?php if (!empty($movie)) : ?>
        <div class="form-group">
          <label for="title">Titel:</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Ange filmtitel" value="<?= $movie['title'];?>" required>
        </div>
        <div class="form-group">
          <label for="director">Regissör:</label>
          <input type="text" class="form-control" id="author" name="author" placeholder="Ange regissör" value="<?= $movie['author'];?>" required>
        </div>
        <div class="form-group">
          <label for="year">År:</label>
          <input type="number" class="form-control" id="year" name="year" placeholder="Ange år" value="<?= $movie['year'];?>" required>
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
        <button type="submit" class="btn btn-primary">Spara ändringar</button>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>
</body>
</html>
