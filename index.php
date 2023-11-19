<?php
session_start();

$_SESSION["login"] = "root"; // TEST USER
$USER_ID = 1; // TEST USER
include_once("dbconn.php");
$getinfo = array("family", "abv", "ibu", "color", "body", "type", "label");

function clearSession()
{
  global $getinfo;
  foreach ($getinfo as $key => $value) {
    unset($_GET[$value]);
    unset($_SESSION[$value]);
  }
}

function checkFamily()
{
  if (isset($_SESSION["family"])) {
    return true;
  }
}

function returnField($field, $table, $id)
{
  global $conn;
  $query = "SELECT $field FROM $table WHERE id = $id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  return $row[$field];
}

function onSubmit()
{
  global $getinfo;
  global $USER_ID;
  global $conn;
  if (isset($_POST["submit"])) {
    foreach ($getinfo as $key => $value) {
      if (!isset($_SESSION[$value])) {
        echo "<script>alert('Top fields missing!')</script>";
        return;
      }
    }
    $family = returnField("DESCRICAO", "familiacerveja", $_SESSION["family"]);
    $abv = returnField("TEORALCOOLICO", "tipocerveja", $_SESSION["abv"]);
    $ibu = returnField("NIVELAMARGOR", "tipocerveja", $_SESSION["ibu"]);
    $color = returnField("COR", "tipocerveja", $_SESSION["color"]);
    $body = returnField("DESCRICAO", "corpo", $_SESSION["body"]);
    $type = returnField("DESCRICAO", "tipocerveja", $_SESSION["type"]);
    $label = returnField("DESCRICAO", "rotulo", $_SESSION["label"]);
    $beerdate = $_POST["beer-date"];
    $notes = $_POST["beer-notes"];
    $brewery = $_POST["beer-brewery"];
    $rating = $_POST["rating"];
    echo "<script>alert('submitted')</script>";

    // TODO: RUN QUERY TO ADD USER REVIEW
    $query = "INSERT INTO avaliacaousuario
    (
      ROTULO, TIPO, NOTA, COMENTARIO, FAMILIA, ABV, IBU, COR, CORPO, DATA
    )
    VALUES
    (
      '$label', '$type', '$rating', '$notes', '$family', '$abv', '$ibu', '$color', '$body', '$beerdate'
    )";
    mysqli_query($conn, $query);

    // CLEAR SESSION VALUES
    clearSession();
    echo "<script>window.location.replace('index.php')</script>";
  }
  
}

foreach ($getinfo as $key => $value) {
  if (isset($_GET[$value])) {
    $_SESSION[$value] = $_GET[$value];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="/css/style.css" />
  <title>beerme!</title>
  <link rel="icon" type="image/x-icon" href="/img/favicon--icon.png" />
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <header>
    <section class="top-nav">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="/index.php"><img id="logo" src="/img/beerme-logo.svg" alt="Logo" /></a>
            </li>
          </ul>
        </div>
      </nav>

      <input id="menu-toggle" type="checkbox" />
      <label class="menu-button-container" for="menu-toggle">
        <div class="menu-button"></div>
      </label>
      <ul class="menu">
        <li>
          <a style="text-decoration: none; color: #ffffff" href="/index.php">home</a>
        </li>
        <li>
          <a style="text-decoration: none; color: #ffffff" href="pages/history/history.php">history</a>
        </li>
        <li>
          <a href="pages/about/about.html" style="text-decoration: none; color: #ffffff">about</a>
        </li>
      </ul>
    </section>
  </header>

  <main>
    <!-- Section for user beer reviews -->
    <section>
      <div class="user-review">
        <form method="post" id="form">
          <div class="dropdown-container">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!checkFamily()) {
                  echo "Beer Family";
                } else echo "Beer Family: " . returnField("DESCRICAO", "familiacerveja", $_SESSION["family"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                $query = "SELECT ID,DESCRICAO FROM familiacerveja";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<li><a class='dropdown-item' href='?family=" . $row["ID"] . "'>" . $row["DESCRICAO"] . "</a></li>";
                }
                ?>

              </ul>
            </div>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["abv"])) {
                  echo "ABV (Alcohol by Volume) (%)";
                } else echo "ABV: " . returnField("TEORALCOOLICO", "tipocerveja", $_SESSION["abv"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (checkFamily()) {
                  $FAMILIA_ID = $_SESSION["family"];
                  $query = "SELECT ID, TEORALCOOLICO FROM tipocerveja WHERE FAMILIACERVEJAID = '$FAMILIA_ID'";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a class='dropdown-item' href='?abv=" . $row["ID"] . "'>" . $row["TEORALCOOLICO"] . "</a></li>";
                  }
                } else {
                  echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                }

                ?>
              </ul>
            </div>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["ibu"])) {
                  echo "IBU (International Bitterness Units)";
                } else echo "IBU: " . returnField("NIVELAMARGOR", "tipocerveja", $_SESSION["ibu"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (checkFamily()) {
                  $FAMILIA_ID = $_SESSION["family"];
                  $query = "SELECT ID, NIVELAMARGOR FROM tipocerveja WHERE FAMILIACERVEJAID = '$FAMILIA_ID'";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a class='dropdown-item' href='?ibu=" . $row["ID"] . "'>" . $row["NIVELAMARGOR"] . "</a></li>";
                  }
                } else {
                  echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                }
                ?>
              </ul>
            </div>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["color"])) {
                  echo "Color";
                } else echo "Color: " . returnField("COR", "tipocerveja", $_SESSION["color"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (checkFamily()) {
                  $FAMILIA_ID = $_SESSION["family"];
                  $query = "SELECT ID, COR FROM tipocerveja WHERE FAMILIACERVEJAID = '$FAMILIA_ID'";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a class='dropdown-item' href='?color=" . $row["ID"] . "'>" . $row["COR"] . "</a></li>";
                  }
                } else {
                  echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                }
                ?>
              </ul>
            </div>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["body"])) {
                  echo "Body";
                } else echo "Body: " . returnField("DESCRICAO", "corpo", $_SESSION["body"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (checkFamily()) {
                  $FAMILIA_ID = $_SESSION["family"];
                  $query = "SELECT DISTINCT CP.ID, CP.DESCRICAO FROM TIPOCERVEJA TC INNER JOIN CORPO CP ON TC.CORPOID = CP.ID WHERE
                  TC.CORPOID = '$FAMILIA_ID'";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a class='dropdown-item' href='?body=" . $row["ID"] . "'>" . $row["DESCRICAO"] . "</a></li>";
                  }
                } else {
                  echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                }
                ?>
              </ul>
            </div>
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["type"])) {
                  echo "Type of Beer";
                } else echo "Type: " . returnField("DESCRICAO", "tipocerveja", $_SESSION["type"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (checkFamily()) {
                  $FAMILIA_ID = $_SESSION["family"];
                  $query = "SELECT ID, DESCRICAO FROM tipocerveja WHERE FAMILIACERVEJAID = '$FAMILIA_ID'";
                  $result = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a class='dropdown-item' href='?type=" . $row["ID"] . "'>" . $row["DESCRICAO"] . "</a></li>";
                  }
                } else {
                  echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                }
                ?>
              </ul>
            </div>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!isset($_SESSION["label"])) {
                  echo "Label";
                } else echo "Label: " . returnField("DESCRICAO", "rotulo", $_SESSION["label"]); ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                if (!isset($_SESSION["type"])) {
                  echo "<li class='dropdown-item'>Tipo de cerveja não selecionada!</li>";
                } else {
                  if (checkFamily()) {

                    $TYPE_ID = $_SESSION["type"];
                    $query = "SELECT RO.ID, RO.DESCRICAO FROM TIPOCERVEJA TC INNER JOIN ROTULO RO ON TC.ROTULOID = RO.ID WHERE
                  TC.ROTULOID = '$TYPE_ID'";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<li><a class='dropdown-item' href='?label=" . $row["ID"] . "'>" . $row["DESCRICAO"] . "</a></li>";
                    }
                  } else {
                    echo "<li class='dropdown-item'>Família de cerveja não selecionada!</li>";
                  }
                }
                ?>
              </ul>
            </div>
          </div>

          <label for="beer-date">Date Consumption:</label>
          <input type="date" id="beer-date" name="beer-date" required />

          <label for="beer-notes">Notes:</label>
          <textarea id="beer-notes" name="beer-notes" rows="4" required></textarea>
          <label for="beer-brewery">Brewery:</label>
          <input type="text" id="beer-brewery" name="beer-brewery" required />

          <label for="beer-rating">Star Rating:</label>
          <div class="rating">
            <input type="radio" name="rating" value="5" id="5" required/><label for="5">☆</label>
            <input type="radio" name="rating" value="4" id="4" /><label for="4">☆</label>
            <input type="radio" name="rating" value="3" id="3" /><label for="3">☆</label>
            <input type="radio" name="rating" value="2" id="2" /><label for="2">☆</label>
            <input type="radio" name="rating" value="1" id="1" /><label for="1">☆</label>
          </div>
          <audio id="beerMe" src="/song/beerMeSong.mp4"></audio>
          <button type="submit" name="submit">Submit Review</button>
        </form>
      </div>
    </section>
  </main>
  <?php
  onSubmit();
  ?>
</body>
<!-- authors js -->
<!-- <script src="/script.js"></script> -->

</html>