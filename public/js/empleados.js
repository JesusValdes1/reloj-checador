// Variables y Constantes Globales
let elementToast = document.querySelector('#liveToast');

// TOKEN PARA TODAS LAS PETICIONES AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	let tableList = document.getElementById('tablaEmpleados');
  let parametros = {
    responsive: true,
    columnDefs: [
      { targets: [0], className: 'text-right' },
      { targets: [2, 9], className: 'text-center' }
    ]
  };

  // LLamar a la funcion fAjaxDataTable() para llenar el Listado
  if ( tableList != null ) fAjaxDataTable('/lista/empleados', '#tablaEmpleados', true, parametros);
  else stopLoading();

  // Confirmar la eliminación del Empledo
  $(tableList).on("click", "button.eliminar", function (e) {

    e.preventDefault();
    var folio = $(this).attr("folio");
    var form = $(this).parents('form');

    Swal.fire({
      title: '¿Estás Seguro de querer eliminar este Empleado (Matricula: '+folio+') ?',
      text: "No podrá recuperar esta información!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, quiero eliminarlo!',
      cancelButtonText:  'No!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    })

  });

	// Envio del formulario para Crear o Editar registros
	function enviar(){
		btnEnviar.disabled = true;
		mensaje.innerHTML = "<span class='list-group-item list-group-item-success'>Enviando Datos ... por favor espere!</span>";

		padre = btnEnviar.parentNode;
		padre.removeChild(btnEnviar);

		formulario.submit(); // Enviar los datos
	}
	let formulario = document.getElementById("formSend");
	let mensaje = document.getElementById("msgSend");
	let btnEnviar = document.getElementById("btnSend");
	if ( btnEnviar != null ) btnEnviar.addEventListener("click", enviar);
    $('.btn-actualizar-registro-empleado').click();

});

var stream = null;

$(document).ready(function() {
    //
});

// Abrir cámara al mostrar modal
$('#cameraModal').on('shown.bs.modal', function () {
    // Solicitar acceso a la cámara
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(function (mediaStream) {
        stream = mediaStream;
        video.srcObject = stream;
        video.play();
    })
    .catch(function (err) {
        alert("No se pudo acceder a la cámara: " + err.message);
    });
});

// Detener cámara al cerrar el modal
$('#cameraModal').on('hidden.bs.modal', function () {
    if (stream) {
        stream.getTracks().forEach(function (track) {
            track.stop();
        });
    }
});

// Capturar foto
$('.capturar-foto').on('click', function () {
    let canvas = document.getElementById('canvas');
    let video = document.getElementById('video');
    let imgFoto = $('#imgFoto');
    let inputFile = $('#foto');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

    let dataURL = canvas.toDataURL('image/jpeg');
    imgFoto.attr('src', dataURL);

    function dataURLtoFile(dataurl, filename) {
        let arr = dataurl.split(',');
        let mime = arr[0].match(/:(.*?);/)[1];
        let bstr = atob(arr[1]);
        let n = bstr.length;
        let u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }

    let archivo = dataURLtoFile(dataURL, 'captura.jpg');
    let contenedor = new DataTransfer();
    contenedor.items.add(archivo);
    inputFile[0].files = contenedor.files;

    $('#cameraModal').modal('hide');
});

$(".btn-actualizar-registro-empleado").click(function() {
    let btnActualizar = this;
    const empleado_id = $(this).data('empleado-id');

    let fechaInicial = $("#fecha_inicial").val();
    let fechaFinal = $("#fecha_final").val();

    let datos = new FormData();
    datos.append('empleado_id', empleado_id);
    datos.append('fechaInicial', fechaInicial);
    datos.append('fechaFinal', fechaFinal);

    $.ajax({
        url: '/empleado/descargaRegistros',
        type: 'POST',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $( btnActualizar ).prop('disabled', true);
            loading();
        },
        success: function(respuesta){
            if ( respuesta.error ) {
                mostrarToast(respuesta.error || "Ocurrió un error inesperado.", "danger");
                return;
            }

            if (respuesta.historico) {
                actualizaRegistrosEmpleado(respuesta.historico, respuesta.columnas);
            }
        },
        error: function(xhr) {
            let errorMessages = "";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.errors) {
                    Object.values(xhr.responseJSON.errors).forEach(function(errorArray) {
                        errorArray.forEach(function(msg) {
                            errorMessages += msg + "<br>";
                        });
                    });
                } else if (xhr.responseJSON.message) {
                    errorMessages = xhr.responseJSON.message;
                }
            }

            mostrarToast(errorMessages || "Ocurrió un error inesperado.", "danger");
        },
        complete: function() {
            $( btnActualizar ).prop('disabled', false);
            stopLoading();
        }
    })
});

function cleanTableRegistrosEmpleado() {
    if ($.fn.DataTable.isDataTable('#tablaRegistrosEmpleado')) {
        $('#tablaRegistrosEmpleado').DataTable().clear().destroy();
    }
}

function actualizaRegistrosEmpleado(historico, columnas) {

    cleanTableRegistrosEmpleado();

    let arrayColumnsTextLeft = [1, 2, 3];
    let arrayColumnsTextCenter = [0, 4, 5];
    let arrayColumnsTextRight = [];

    dataTableListRegistrosChecador = $('#tablaRegistrosEmpleado').DataTable({
        autoWidth: false,
        data: historico,
        columns: columnas,
        columnDefs: [
            { targets: arrayColumnsTextRight, className: 'text-left' },
            { targets: arrayColumnsTextCenter, className: 'text-center' },
            { targets: arrayColumnsTextRight, className: 'text-right' }
        ],
        language: LENGUAJE_DT,
        aaSorting: [],
        dom: "<'row'<'col-md-6'l><'col-md-6'f>>" + // length + search
             "<'row'<'col-12 text-left mt-2'B>>" +  // buttons debajo
             "<'row'<'col-sm-12'tr>>" +             // table
             "<'row'<'col-md-5'i><'col-md-7'p>>",   // info + pagination
        buttons: [
            { extend: 'copy', className: 'btn-info', text: 'Copiar' },
            { extend: 'csv', className: 'btn-info' },
            { extend: 'excel', className: 'btn-info' },
            { extend: 'pdf', className: 'btn-info' },
            { extend: 'print', className: 'btn-info', text: 'Imprimir' },
            { extend: 'colvis', className: 'btn-info', text: 'Columnas' }
        ]
    });
}

function mostrarToast(mensaje, tipo = "success") {
    const color = tipo === "success" ? "bg-success" : "bg-danger";
    $('.toast-header').removeClass().addClass(`toast-header text-white ${color}`);
    $('.toast-body').removeClass().addClass("toast-body text-black bg-white").html(mensaje);
    let toast = new bootstrap.Toast(elementToast, { animation: true, autohide: true, delay: 9000 });
    toast.show();
}