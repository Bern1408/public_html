//document.getElementById('btn').addEventListener('click', testAjax);
//function testAjax(){
//    const options = {
//        method: 'POST',
//        headers: {
//            'Accept': 'application/json; charset=utf-8',
//            'Content-Type': 'application/json'
//        },
//        body: JSON.stringify({"objet" : "testajax", "nom" : "Bernardo"})
//    };
//    fetch("api.php", options);
//}

document.getElementById('add').addEventListener("click", addProduct);
function addProduct(){
    document.getElementById('addForm').classList.remove('hide');
}