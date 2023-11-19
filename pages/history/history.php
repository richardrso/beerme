
<?php
include_once("../../dbconn.php");

unset($_SESSION);
session_start();
$_SESSION["login"] = "root"; // TEST USER

if(isset($_POST["id"])){
  $_SESSION["id"] = $_POST["id"];
}

if (isset($_POST["form-delete"])) {
  $id = $_SESSION["id"];
  $query = "DELETE FROM avaliacaousuario WHERE ID = $id";
  $result = mysqli_query($conn, $query);
}

if (isset($_POST["form-edit"])) {
  $id = $_SESSION["id"];
  $notes = $_POST["beer-notes"];
  $rating = $_POST["rating"];

  if(!empty($notes)){
    $query = "UPDATE avaliacaousuario SET COMENTARIO = '$notes' WHERE ID = $id";
    $result = mysqli_query($conn, $query);
  }
  if(!empty($rating)){
    $query = "UPDATE avaliacaousuario SET NOTA = '$rating' WHERE ID = $id";
    $result = mysqli_query($conn, $query);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Beerme CSS -->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/history.css" />

  <title>beerme!</title>
</head>

<body>
  <header>
    <section class="top-nav">
      
        <!-- logo configuration -->
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <a href="/index.php"
                  ><img id="logo" src="/img/beerme-logo.svg" alt="Logo"
                /></a>
              </li>
            </ul>
          </div>
        </nav>

      <!-- menu hamb colapse + content -->
      <input id="menu-toggle" type="checkbox" />
      <label class="menu-button-container" for="menu-toggle">
        <div class="menu-button"></div>
      </label>
      <ul class="menu">
        <li>
          <a style="text-decoration: none; color: #ffffff" href="/index.php">home</a>
        </li>
        <li>
          <a style="text-decoration: none; color: #ffffff" href="/pages/history/history.php">history</a>
        </li>
        <li>
          <a href="/pages/about/about.html" style="text-decoration: none; color: #ffffff">about</a>
        </li>
      </ul>

    </section>
  </header>
  <main>
<!-- audio -->
      <audio id="beerMe" src="/song/beerMeSong.mp4"></audio>
      <audio id="deleteBeer" src="/song/deleteBeer.mp3"></audio>
      
    <section class="beer-card">
      <div class="card-deck">
        <?php
        function createRatingElement($rating, $id)
        {
          $element = "<div class='rating rating_history' id='rating" . $id . "'>";
          for ($i = 0; $i < $rating; $i++) {
            $element .= "<span class='fa fa-star checked'></span>";
          }
          for ($i = $rating; $i < 5; $i++) {
            $element .= "<span class='fa fa-star'></span>";
          }
          $element .= "</div>";
          return $element;
        }

        $avaliacao = "SELECT * FROM avaliacaousuario ORDER BY id DESC";
        $result = mysqli_query($conn, $avaliacao);
        while ($row = mysqli_fetch_assoc($result)) {
          $ROTULO = $row["ROTULO"];
          $imagem = mysqli_fetch_array(mysqli_query(
            $conn,
            "SELECT rotulo.IMAGEM from rotulo WHERE rotulo.DESCRICAO = '$ROTULO'"
          ));

          echo " <div class='card'>";
          echo "
                <a href='#editBeerCard' data-toggle='modal' onClick='sendId(" . $row["ID"] . ")'>
                  <img 
                    src='/img/button--edit.png' 
                    alt='Imagem do botão de edição ou deleção'>
                </a>";
          echo "<img class='card-img-top' src='" . $imagem["IMAGEM"] . "'>";
          echo "<div class='card-body'>
                  <h5 class='card-title'>" . $ROTULO . " - <strong>(" . $row["TIPO"] . ") " . $row["FAMILIA"] . "</strong></h5>";
          echo createRatingElement($row["NOTA"], $row["ID"]);
          echo "<p class='card-text'>" . $row["COMENTARIO"] . "</p>";
          echo "</div>
                <!-- bs info colapser -->
                <p class='d-inline-flex gap-1'>";
          echo "<a class='btn btn-primary' id='button-seeMore' data-bs-toggle='collapse' href='#card".$row["ID"]."' role='button' aria-expanded='false' aria-controls='collapseExample'>";
          echo"     See more info
                  </a>
                </p>";
          echo "<div class='collapse' id='card".$row["ID"]."'>";
          echo"
                  <!-- colapsed info -->";
          echo "<div class='card-footer'>
                  <small class='text-muted'>Beer Family: " . $row["FAMILIA"] . "</small>
                  </div>";
          echo "<div class='card-footer'>
                    <small class='text-muted'>ABV: " . $row["ABV"] . "%</small>
                  </div>";
          echo "<div class='card-footer'>
                    <small class='text-muted'>IBU: " . $row["IBU"] . "</small>
                  </div>";
          echo "<div class='card-footer'>
                    <small class='text-muted'>Color: " . $row["COR"] . "</small>
                  </div>";
          echo "<div class='card-footer'>
                    <small class='text-muted'>Body: " . $row["CORPO"] . "</small>
                  </div>";
          echo "<div class='card-footer'>
                    <small class='text-muted'>Date cons.: " . $row["DATA"] . "</small>
                  </div>
                </div>
              </div>
            ";
        }

        ?>
      </div>
    </section>
  </main>

  <!-- Edit modal content (Bootstrap live demo) -->

  <div class="modal fade" id="editBeerCard">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit this card!</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <!-- Start inner modal form fields -->
            <div class="form-group">
              <label for="notes">Notes:</label>
              <textarea id="notes" name="beer-notes" rows="4"></textarea>
            </div>
            <div class="rating-container">
              <p class="rating-label">Star Rating: </p>
              <div class="rating">
                <input type="radio" name="rating" value="5" id="5" /><label for="5">☆</label>
                <input type="radio" name="rating" value="4" id="4" /><label for="4">☆</label>
                <input type="radio" name="rating" value="3" id="3" /><label for="3">☆</label>
                <input type="radio" name="rating" value="2" id="2" /><label for="2">☆</label>
                <input type="radio" name="rating" value="1" id="1" /><label for="1">☆</label>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="submit" name="form-delete" class="btn btn-warning" value="Delete"></input>
          <input type="submit" name="form-edit" class="btn btn-warning" value="Edit"></input>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootrstrap's js: jQuery / Popper.js / Bootstrap JS -->
  
  <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- authors js -->
  <script src="/pages/history/script.js"></script>
  <script>
    function sendId(id) {
      $.ajax({
        type: "POST",
        url: "history.php",
        data: {
          id: id
        },
        success: function() {
          console.log("success");
        }
      })
    }
  </script>

</body>

</html>