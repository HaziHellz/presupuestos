document.addEventListener('DOMContentLoaded', function (){
    let botones = document.querySelectorAll('.btnEdit');
    let formulario = document.getElementById('editForm');
    let btnFormulario = document.getElementById('editSubmit');
    console.log(botones);

    function editService(event){
        let data = JSON.parse(event.target.getAttribute('data-client'));
       //let url = event.target.getAttribute('data-url');
        let client = document.getElementById('clientEdit');
        let name = document.getElementById('name');
        let last_name = document.getElementById('last_name');
        let email = document.getElementById('email');
        let telephone = document.getElementById('telephone');

        //formulario.setAttribute('action', url);

        client.value = data.id;
        name.value = data.name;
        last_name.value = data.last_name;
        email.value = data.email;
        telephone.value = data.telephone;
    }

    botones.forEach((boton) => {
        boton.addEventListener('click', editService);
    });

});
