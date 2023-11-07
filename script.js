function playBeerMe(){
    let beerMeSong = document.getElementById("beerMe");

    beerMeSong.currentTime = 50.1;
    beerMeSong.play();

    // Stop playing
    setTimeout(function(){
        beerMeSong.pause();
        beerMeSong.currentTime = 0;
    }, 800);
}

function forml() {
  var form = document.getElementById('form');
  form.addEventListener('submit', function(e) {
      e.preventDefault();
      setTimeout("form.submit()", 1000);
      playBeerMe();
  }); 
}