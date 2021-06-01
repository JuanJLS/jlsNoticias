(function (){
    let createNewsForm = document.getElementById('createNoticiaForm');
    if(createNewsForm) {
        createNewsForm.addEventListener('submit', function(event){
            if(1 == 1){
                //Se valida
            } else {
                alert('fallo al validar');
                event.preventDefault();
            }
        });
    }
    
    let enlacesBorrar = document.getElementsByClassName('enlaceBorrar');
    for (var i = 0; i < enlacesBorrar.length; i++) {
        enlacesBorrar[i].addEventListener('click', getClassConfirmation);
    }
    
    function getClassConfirmation(event) {
        let id = event.target.dataset.id;
        let table = event.target.dataset.table;
        let retVal = confirm('¿Seguro que quiere eliminar el elemento ' + table +  ' con el id # ' + id + '?');
        if(retVal) {
            var formDelete = document.getElementById('formDelete');
            formDelete.action += '/' + id;
            formDelete.submit();
        }
    }
    
    let enlaceBorrar = document.getElementById('enlaceBorrar');
    if(enlaceBorrar){
        enlaceBorrar.addEventListener('click', getConfirmation);
    }
    function getConfirmation(event) {
        let id = event.target.dataset.id;
        let name = event.target.dataset.name;
        let table = event.target.dataset.table;
        var retVal;
        if(table === 'Noticia'){
            retVal = confirm('¿Seguro que desea borrar el elemento '+ table + ' ' + id + ' con el nombre ' + name + '?');
            
        } else {
            retVal = confirm('¿Seguro que desea borrar el elemento '+ table + ' con id# ' + id + '?');
        }
        if(retVal) {
            var formDelete = document.getElementById('formDelete');
            formDelete.submit();
        }
    }
})();