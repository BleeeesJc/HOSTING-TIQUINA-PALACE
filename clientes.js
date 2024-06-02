document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formulario').addEventListener('submit', function(event) {
        event.preventDefault();
        registrarclientes();
    });
});
function registrarclientes() {
    let fechaEntrada = document.getElementById('Enter').value;
    let fechaSalida = document.getElementById('Leave').value;
    let adultos = document.getElementById('Adult').value;
    let ninos = document.getElementById('Child').value;
    let precio = document.getElementById('precioHabitacionPorNoche').value;
    precio = parseFloat(precio.replace(/[^0-9.]/g, ''));
    let tipoTarjeta = document.getElementById('tipo').value;
    let montoTotal = document.getElementById('montoTotal').value;
    montoTotal = parseFloat(montoTotal.replace(/[^0-9.]/g, ''));
    let horaLlegada = document.getElementById('llegada').value; // Hora de llegada agregada
    let nombre = document.getElementById('nombre').value;
    let apellido = document.getElementById('apellido').value;
    let email = document.getElementById('email').value;
    let direccion = document.getElementById('direccion').value;
    let ciudad = document.getElementById('ciudad').value;
    let codigo_postal = document.getElementById('codigo_postal').value;
    let pais = document.getElementById('pais').value;
    let telefono = document.getElementById('telefono').value;
    let peticiones = document.getElementById('peticiones').value;
    let tipoHabitacion = document.getElementById('room').value;
    let servicios = document.getElementById('service').value.split(',');

    console.log("fechaEntrada:", fechaEntrada);
    console.log("fechaSalida:", fechaSalida);
    console.log("adultos:", adultos);
    console.log("ninos:", ninos);
    console.log("precio:", precio);
    console.log("tipoTarjeta:", tipoTarjeta);
    console.log("montoTotal:", montoTotal);
    console.log("horaLlegada:", horaLlegada);
    console.log("nombre:", nombre);
    console.log("apellido:", apellido);
    console.log("email:", email);
    console.log("direccion:", direccion);
    console.log("ciudad:", ciudad);
    console.log("codigo_postal:", codigo_postal);
    console.log("pais:", pais);
    console.log("telefono:", telefono);
    console.log("peticiones:", peticiones);
    console.log("tipoHabitacion:", tipoHabitacion);
    console.log("servicios:", servicios);

    fetch("http://localhost/TiquinaPalaceHotel/clientes.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            fechaEntrada: fechaEntrada,
            fechaSalida: fechaSalida,
            adultos: adultos,
            ninos: ninos,
            precio: precio,
            tipoTarjeta: tipoTarjeta,
            montoTotal: montoTotal,
            horaLlegada: horaLlegada,
            nombre: nombre,
            apellido: apellido,
            email: email,
            direccion: direccion,
            ciudad: ciudad,
            codigo_postal: codigo_postal,
            pais: pais,
            telefono: telefono,
            peticiones: peticiones,
            tipoHabitacion: tipoHabitacion,
            servicios: servicios
        }),
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Error al registrar el cliente');
        }
    })
    .then(data => {
        alert('Cliente registrado correctamente.');
    })
    .catch(error => console.error('Error:', error));
}