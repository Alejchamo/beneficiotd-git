function showSection(sectionId) {
    // Selecciona todas las secciones de contenido con la clase 'content-section'
    const sections = document.querySelectorAll('.content-section');

    // Itera sobre cada sección y remueve la clase 'visible' para ocultarlas
    sections.forEach(section => {
        section.classList.remove('visible');
    });

    // Selecciona la sección específica que coincide con el ID proporcionado
    const selectedSection = document.getElementById(sectionId);

    // Agrega la clase 'visible' a la sección seleccionada para mostrarla
    if (selectedSection) {
        selectedSection.classList.add('visible');
    } else {
        console.warn(`No se encontró la sección con el ID: ${sectionId}`);
    }

    ocultarContenedor();
    
}



function mostrarInicio() {
    document.getElementById('contenedor-oculto').style.display = 'block'; // Muestra el contenedor
    
}

 // Función para ocultar el contenedor
 function ocultarContenedor() {
    document.getElementById('contenedor-oculto').style.display = 'none';
}

// Llama a mostrarInicio al cargar la página para asegurar que el contenido inicial esté visible
window.onload = mostrarInicio;

// Obtener el año actual
document.addEventListener("DOMContentLoaded", function() {
    // Crear un nuevo objeto Date
    var now = new Date();

    // Formatear la fecha en un formato legible
    var day = now.getDate(); // Día
    var month = now.getMonth() + 1; // Mes (0-11, por eso sumamos 1)
    var year = now.getFullYear(); // Año
    var hours = now.getHours(); // Hora
    var minutes = now.getMinutes(); // Minutos
    var seconds = now.getSeconds(); // Segundos

    // Formatear la fecha y hora como: "Día/Mes/Año Hora:Minutos:Segundos"
    var formattedDate = day + "/" + month + "/" + year + " " + hours + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);

    // Mostrar la fecha formateada en el footer
    document.getElementById("date").textContent = formattedDate;
});

//verificacion de vehiculo

document.getElementById("verificacion-form").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevenir el envío tradicional del formulario

    var vehicleId = document.getElementById("vehicle-id").value; // Obtener el valor de placa o cédula
    var resultadoDiv = document.getElementById("resultado-verificacion"); // Donde se mostrará el resultado

    // Verificar que el campo no esté vacío
    if (!vehicleId) {
        resultadoDiv.textContent = "Por favor, ingrese el número de placa o cédula.";
        resultadoDiv.style.backgroundColor = "#f8d7da";  // Fondo rojo claro
        resultadoDiv.style.display = "block";  // Mostrar el div
        return;
    }

    // Enviar la solicitud al archivo PHP
    fetch('verificarVehiculo.php', {
        method: 'POST',
        body: new FormData(this) // Enviar el formulario con los datos
    })
    .then(response => response.text())  // Obtener el resultado como texto
    .then(result => {
        // Revisar si el resultado contiene "Vehículo encontrado"
        if (result.includes('Vehículo encontrado')) {
            resultadoDiv.textContent = "¡Felicidades! Su vehículo tiene el beneficio de Tarifa Diferencial.";
            resultadoDiv.style.backgroundColor = "#d4edda";  // Fondo verde claro
        } else {
            resultadoDiv.textContent = result;  // Mostrar mensaje de error detallado
            resultadoDiv.style.backgroundColor = "#f8d7da";  // Fondo rojo claro
        }
        resultadoDiv.style.display = "block";  // Asegurar que se muestre el resultado
    })
    .catch(error => {
        resultadoDiv.textContent = "Error al verificar el vehículo. Inténtelo nuevamente.";
        resultadoDiv.style.backgroundColor = "#f8d7da";  // Fondo rojo claro
        resultadoDiv.style.display = "block";  // Mostrar el mensaje de error
    });
});



//final verificación vehiculo

const btnLeft = document.querySelector(".btn-left"),
      btnRight = document.querySelector(".btn-right"), 
      slider = document.querySelector(".carruseles"), // Asegúrate de que el selector sea correcto
      sliderSection = document.querySelectorAll(".slider-section");

btnLeft.addEventListener("click", moveToLeft);
btnRight.addEventListener("click", moveToRight);

setInterval(() => {
    moveToRight();
}, 3000);

let operacion = 0,
    counter = 0,
    widthImg = 100 / sliderSection.length;

function moveToRight() {
    counter++;
    if (counter >= sliderSection.length) {
        counter = 0;
        operacion = 0;
        slider.style.transition = "none"; // Desactiva la transición temporalmente
        slider.style.transform = `translateX(0%)`;
        setTimeout(() => slider.style.transition = "all ease 0.6s", 10); // Reactiva la transición
    } else {
        operacion += widthImg;
        slider.style.transform = `translateX(-${operacion}%)`;
        slider.style.transition = "all ease 0.6s";
    }
}

function moveToLeft() {
    counter--;
    if (counter < 0) {
        counter = sliderSection.length - 1;
        operacion = widthImg * (sliderSection.length - 1);
        slider.style.transition = "none";
        slider.style.transform = `translateX(-${operacion}%)`;
        setTimeout(() => slider.style.transition = "all ease 0.6s", 10);
    } else {
        operacion -= widthImg;
        slider.style.transform = `translateX(-${operacion}%)`;
        slider.style.transition = "all ease 0.6s";
    }
}


 // Función para mostrar u ocultar los campos dependiendo del tipo de usuario
 function toggleFields() {
    var tipoUsuario = document.getElementById('tipo_usuario').value;
    
    // Si el tipo de usuario es 'usuario'
    if (tipoUsuario === 'usuario') {
        document.getElementById('usuario-fields').style.display = 'block'; // Mostrar campos de usuario
        document.getElementById('admin-fields').style.display = 'none';  // Ocultar campos de administrador
        // Hacer que los campos de usuario sean obligatorios
        document.getElementById('celular').required = true;
        document.getElementById('municipio').required = true;
        document.getElementById('placa_del_vehiculo').required = true;
        document.getElementById('clase_de_usuario').required = true;
        // Eliminar la obligatoriedad de los campos del administrador
        document.getElementById('cargo').required = false;
        
    } else if (tipoUsuario === 'administrador') {
        document.getElementById('usuario-fields').style.display = 'none';  // Ocultar campos de usuario
        document.getElementById('admin-fields').style.display = 'block';  // Mostrar campos de administrador
        // Hacer que el campo 'cargo' sea obligatorio
        document.getElementById('cargo').required = true;
        // Eliminar la obligatoriedad de los campos de usuario
        document.getElementById('celular').required = false;
        document.getElementById('municipio').required = false;
        document.getElementById('placa_del_vehiculo').required = false;
        document.getElementById('clase_de_usuario').required = false;
    }
}

function metodoAux() {
    fetch('verificar.php')
        .then(response => response.text())
        .then(result => {
            if (result === 'true') {
                document.getElementById("resultado").innerHTML = "<div style='background-color: lightgreen;'>¡La condición es verdadera! Valor de result: " + result + "</div>";
            } else {
                document.getElementById("resultado").innerHTML = "<div style='background-color: lightcoral;'>La condición es falsa. Valor de result: " + result + "</div>";
            }
        });
}



 // Función para mostrar el mensaje de éxito después de enviar el formulario
 function showSuccessMessage(documentType) {
    // Evitar el envío del formulario para mostrar el mensaje
    event.preventDefault();
    
    // Mostrar el mensaje de éxito
    document.getElementById('successMessage').style.display = 'block';

    // Redirigir al usuario a otra página o realizar más acciones si es necesario
    setTimeout(function() {
        // Aquí puedes enviar el formulario si es necesario o redirigir
        document.getElementById("form" + capitalizeFirstLetter(documentType)).submit();
    }, 2000); // Después de 2 segundos, el formulario se enviará
}

// Función auxiliar para capitalizar la primera letra de una palabra
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

