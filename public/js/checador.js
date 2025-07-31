// Variables y Constantes Globales
let elementToast = document.querySelector('#liveToast');

// Cambia el titulo del tooltip cuando se presiona el botón Maximizar del elemento Card
$( 'button[data-card-widget="maximize"]' ).click(function(event) {
    let elementTooltip = this.querySelector('span[data-toggle="tooltip"]');
    let valorActual = elementTooltip.getAttribute('data-original-title');
    elementTooltip.setAttribute('data-original-title', valorActual == 'Maximizar' ? 'Restaurar' : 'Maximizar');
});

// Ejecuta en cuanto la página esté lista
$(document).ready(function() {

    $('button[data-card-widget="maximize"]').trigger('click');

    // Configuracion del Header en las llamadas Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    (async () => {
      await faceapi.nets.ssdMobilenetv1.loadFromUri('/models');
      await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
      await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

      stopLoading();
    })();

    // MANTENER FECHA Y HORA ACTUALIZADA LADO SERVIDOR
    const $reloj = $('.fecha-hora');
    let horaServidor = $reloj.data('hora');
    let fecha = new Date(horaServidor.replace(' ', 'T'));

    $reloj.text(formatearFecha(fecha));

    // Cada segundo, sumar un segundo
    setInterval(() => {
        fecha.setSeconds(fecha.getSeconds() + 1);
        $reloj.text(formatearFecha(fecha));
    }, 1000);

});

$("#inputMatricula").on('input', async function () {
    let matricula = $(this).val().trim();
    const video = document.querySelector("#videoCamara");
    const fechaTexto = $('.fecha-hora').text();
    const tipo = $('input[name="tipo"]:checked').val();
    if (typeof tipo === 'undefined') {
        mostrarToast("Debes seleccionar entrada o salida.", "warning");
        $('#inputMatricula').val('');
        return;
    }
    
    if (matricula.length === 5 && video && video.videoWidth > 0) {
        let matricula = $("#inputMatricula").val().trim();
        const canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext("2d").drawImage(video, 0, 0);

        const blob = await new Promise(resolve => canvas.toBlob(resolve, "image/jpeg"));
        const formData = new FormData();
        formData.append("matricula", matricula);
        formData.append("foto_actual", blob, "actual.jpg");

        $.ajax({
            url: '/checador/validacion',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                loading();
            }
        })
        // CON PYTHON
        // .done(function(response) {
        //     $('#inputMatricula').val('');

        //     if ( response.error ) {
        //         mostrarToast(response.message, "danger");
        //         return;
        //     } else {

        //         $('#inputMatricula').val('');

        //         mostrarToast(response.message, "success");
        //     }
        // })

        // CON JS
        // .done(async function(response) {
        .then(async function(response) {
            $('#inputMatricula').val('');
            
            if ( response.error ) {
                $('#inputMatricula').val('');
                mostrarToast(response.message, "danger");
                return;
            }

            try {
                // 1. Captura la imagen actual desde la cámara
                const video = document.querySelector("#videoCamara");
                const canvas = document.createElement("canvas");
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext("2d").drawImage(video, 0, 0);
                const currentBlob = await new Promise(resolve => canvas.toBlob(resolve, "image/jpeg"));
                const currentImage = await faceapi.bufferToImage(currentBlob);

                // 2. Carga la imagen registrada del empleado
                const registeredImage = await faceapi.fetchImage(response.empleado.foto);

                // 3. Detecta rostro y obtiene descriptores
                const descriptorActual = await faceapi
                    .detectSingleFace(currentImage)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                const descriptorRegistrado = await faceapi
                    .detectSingleFace(registeredImage)
                    .withFaceLandmarks()
                    .withFaceDescriptor();

                if (!descriptorActual || !descriptorRegistrado) {
                    $('#inputMatricula').val('');
                    mostrarToast("No se detectó un rostro.", "danger");
                    return;
                }

                // 4. Compara las caras
                const distancia = faceapi.euclideanDistance(
                    descriptorActual.descriptor,
                    descriptorRegistrado.descriptor
                );

                const umbral = 0.6;
                if (distancia < umbral) {
                    $('#inputMatricula').val('');
                    // storeRegistro(response.empleado.matricula);
                    await storeRegistro(response.empleado.matricula, tipo, fechaTexto);
                    // mostrarToast(`Asistencia registrada: ${response.empleado.nombre}`, "success");
                } else {
                    $('#inputMatricula').val('');
                    mostrarToast("La persona escaneada no coincide con la registrada", "danger");
                }

            } catch (e) {
                $('#inputMatricula').val('');
                mostrarToast("Error en la comparación facial", "danger");
                // console.error(e);
            }
        })
        .fail(function(xhr, status, error) {
            let errorMessages = "";
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                Object.values(xhr.responseJSON.errors).forEach(function(errorArray) {
                    errorArray.forEach(function(errorMessage) {
                        errorMessages += errorMessage + "<br>";
                    });
                });
            }

            mostrarToast(errorMessages || "Ocurrió un error inesperado.", "danger");
            $('#inputMatricula').val('');
        })
        .always(function() {
            stopLoading();
            $('#inputMatricula').focus();
        });
    }
});

$('.opcion-registro').on('click', function () {
    setTimeout(() => {
        $('#inputMatricula').focus();
    }, 100);
});

async function storeRegistro(matricula, entrada, fecha) {

    await fetch('/checador/registro', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
                matricula: matricula,
                entrada: entrada == "0" ? true : false,
                fecha: fecha
            }) // body data type must match "Content-Type" header
    })
    .then( response => response.json() )
    .then( data => {
        // console.log( data )
        if ( data.error ) {
            mostrarToast(data.message, "danger");
        } else {
            // mostrarToast(`Asistencia registrada: ${data.empleado.nombre}`, "success");
            // Deseleccionar radios y quitar clase 'active' de entrada o salida
            $('input[name="tipo"]').prop('checked', false);
            $('.opcion-registro').removeClass('active');

            // Mostrar registro en la tabla
            const hora = new Date(data.empleado.fecha).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

            const nuevaFila = `
                <tr>
                    <td>${data.empleado.registro.toUpperCase()}</td>
                    <td>${hora}</td>
                    <td class="text-left">${data.empleado.nombre.toUpperCase()}</td>
                </tr>
            `;
            $('#tabla-registros tbody').prepend(nuevaFila);
        }
    }) // .then( data => {
    .catch( error => {
        // console.log('Error:', error)
        mostrarToast(error, "danger");
    });

}

function storeRegistroResp(matricula){
    return; // No se usa
    $.ajax({
        url: '/checador/registro',
        type: 'POST',
        data: {
            matricula: matricula
        },
        beforeSend: function() {
            loading();
        }
    })
    .done(function(response) {
        
        if ( response.error ) {
            $('#inputMatricula').val('');
            mostrarToast(response.message, "danger");
            return;
        } else {
            $('#inputMatricula').val('');
            mostrarToast(`Asistencia registrada: ${response.empleado.nombre.toUpperCase()}`, "success");
        }
    })
    .fail(function(xhr, status, error) {
        let errorMessages = "";
        if (xhr.responseJSON && xhr.responseJSON.errors) {
            Object.values(xhr.responseJSON.errors).forEach(function(errorArray) {
                errorArray.forEach(function(errorMessage) {
                    errorMessages += errorMessage + "<br>";
                });
            });
        }

        mostrarToast(errorMessages || "Ocurrió un error inesperado.", "danger");
        $('#inputMatricula').val('');
    })
    .always(function() {
        $('#inputMatricula').val('');
        stopLoading();
    });
}

function mostrarToast(mensaje, tipo = "success") {
    const color = tipo === "success" ? "bg-success" : "bg-danger";
    $('.toast-header').removeClass().addClass(`toast-header text-white ${color}`);
    $('.toast-body').removeClass().addClass("toast-body text-black bg-white").html(mensaje);
    let toast = new bootstrap.Toast(elementToast, { animation: true, autohide: true, delay: 9000 });
    toast.show();
}

function formatearFecha(fecha) {
    const pad = (num) => num.toString().padStart(2, '0');
    return `${pad(fecha.getDate())}/${pad(fecha.getMonth() + 1)}/${fecha.getFullYear()} `
         + `${pad(fecha.getHours())}:${pad(fecha.getMinutes())}:${pad(fecha.getSeconds())}`;
}