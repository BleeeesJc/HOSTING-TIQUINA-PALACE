document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('Enviar').addEventListener('click', function(event) {
        event.preventDefault();
        registrarcomentarios();
    });
});
function registrarcomentarios() {
    let mensaje = document.getElementById('message').value;
    let nombre = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let asunto = document.getElementById('subject').value;

    console.log("mensaje:", mensaje);
    console.log("nombre:", nombre);
    console.log("email:", email);
    console.log("asunto:", asunto);
   

    fetch("http://localhost/TiquinaPalaceHotel/comentarios.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            mensaje: mensaje,
            nombre: nombre,
            email: email,
            asunto: asunto
        }),
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Error al registrar el comentario');
        }
    })
    .then(data => {
        console.log(data);
        alert('Usuario registrado correctamente. ID de comentario: ' + data.id_comentarios);
    })
    .catch(error => console.error('Error:', error));
}