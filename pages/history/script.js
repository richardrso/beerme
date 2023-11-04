function validaEdit(){
    let notes = document.getElementById("notes").value;
    let typeOfBeer = document.getElementById("typeOfBeer").value;

    if(!notes && !typeOfBeer){
        alert("Opa! Nada editado, por favor, indique algo para editar!")
        return;
    }

    alert("Edição feita, cervejeiro!");

    //*** >>> PHP <<< ADICIONE AÇÃO DE EDIÇÃO ***

    document.location.reload(); //refresh page
}

function validaDelete(){
    let texto = "Deletar o cartão! Tem certeza disso?"

    if(confirm(texto) == true){

        //*** >>> PHP <<< ADICIONE AÇÃO DE DELETE ****
        
        document.location.reload();
    }else{
        return;
    }
}