// play BeerMe!
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

// play deleteBeer!
function playDeleteBeer(){
    let deleteBeerSong = document.getElementById("deleteBeer");
    deleteBeerSong.play();
}

function validaEdit(){
    let notes = document.getElementById("notes").value;
    let typeOfBeer = document.getElementById("typeOfBeer").value;

    if(!notes && !typeOfBeer){
        alert("Opa! Nada editado, por favor, indique algo para editar!")
        return;
    }
    alert("Edição feita, cervejeiro!");
    //*** >>> PHP <<< ADICIONE AÇÃO DE EDIÇÃO ***
    
    setTimeout(function(){ document.location.reload(); }, 1000); // refresh page after 1 sec
        // Fiz isso pois não sei o motivo, após tocar o beerMe o código não continua, talvez teha a ver com o o current time do song
    playBeerMe().play();
}

function validaDelete(){
    let texto = "Deletar o cartão! Tem certeza disso?"

    if(confirm(texto) == true){
        
        //*** >>> PHP <<< ADICIONE AÇÃO DE DELETE ****

        setTimeout(function(){ document.location.reload(); }, 600);
        playDeleteBeer().play();
    }else{
        return;
    }
}

