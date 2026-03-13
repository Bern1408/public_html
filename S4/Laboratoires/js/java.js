document.getElementById('submit').addEventListener('click', addProduct);
async function addProduct(evt){
    evt.preventDefault();
    $data = {'produit' : document.getElementById('produit').value, 'id_categorie' : document.getElementById('id_categorie').value, 'description' : document.getElementById('description').value};
    const options = {
        method: 'POST',
        headers: {
            'Accept': 'application/json; charset=utf-8',
            'Content-Type': 'application/json'
        },
//        body: JSON.stringify({"objet" : "produit", "nom" : "Bernardo"})
        body: JSON.stringify($data)
    };
    await fetch("api.php?objet=produit", options)
        .then(response =>{
            if(response.ok){
                alert("SUCCÈS : le produit a bien été ajouté.");
                return response.json();
            }
            throw new Error("Erreur lors de la requête")        
        })
        .then(jsonData => {
            console.log(jsonData);
        })
        .catch(error => {
            console.log(error)
            alert("ÉCHEC : le produit n'a pas été ajouté.");
        });
}

edit = document.getElementsByClassName('edit')
for (let i=0, l = edit.length; i < l; i++){
    edit[i].addEventListener('click', editProduct);
}
async function editProduct(evt){
    alert(evt.target.value);

        evt.preventDefault();

    const options = {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json; charset=utf-8',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'id' : evt.target.value})
    };
    await fetch("api.php?objet=produit", options)
        .then(response =>{
            if(response.ok)
                if (confirm("Souhaitez-vous vraiment supprimer ce produit?") == true) {
                    alert("SUCCÈS : le produit a bien été supprimé.");
                    return response.json();
                }
            throw new Error("Erreur lors de la requête")
        })
        .then(jsonData => {
            console.log(jsonData);
        })
        .catch(error => {
            console.log(error)
            alert("ÉCHEC : le produit n'a pas été supprimé.");
        });
}

remove = document.getElementsByClassName('remove')
for (let i=0, l = remove.length; i < l; i++){
    remove[i].addEventListener('click', removeProduct);
}
async function removeProduct(evt){
    evt.preventDefault();

    const options = {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json; charset=utf-8',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'id' : evt.target.value})
    };
    await fetch("api.php?objet=produit", options)
        .then(response =>{
            if(response.ok)
                if (confirm("Souhaitez-vous vraiment supprimer ce produit?") == true) {
                    alert("SUCCÈS : le produit a bien été supprimé.");
                    return response.json();
                }
            throw new Error("Erreur lors de la requête")
        })
        .then(jsonData => {
            console.log(jsonData);
        })
        .catch(error => {
            console.log(error)
            alert("ÉCHEC : le produit n'a pas été supprimé.");
        });
}

document.getElementById('add').addEventListener("click", productForm);
function productForm(){
    document.getElementById('addForm').classList.remove('hide');
}