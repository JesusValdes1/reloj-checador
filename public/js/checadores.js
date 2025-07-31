// Variables y Constantes Globales
let elementToast = document.querySelector('#liveToast');

// TOKEN PARA TODAS LAS PETICIONES AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){

	let tableList = document.getElementById('tablaChecadores');
    let parametros = {
        responsive: true,
        columnDefs: [
            { targets: [0], className: 'text-right' },
            { targets: [2, 6], className: 'text-center' }
        ]
    };

    // LLamar a la funcion fAjaxDataTable() para llenar el Listado
    if ( tableList != null ) fAjaxDataTable('/lista/checadores', '#tablaChecadores', true, parametros);
    else stopLoading();

    // Confirmar la eliminación del Checador
    $(tableList).on("click", "button.eliminar", function (e) {
        e.preventDefault();
        var folio = $(this).attr("folio");
        var form = $(this).parents('form');

        Swal.fire({
            title: '¿Estás Seguro de querer eliminar este Checador (Nombre: '+folio+') ?',
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
    $('.btn-actualizar-registro-checador').click();

});

$(document).ready(function() {
    //
});

$(".btn-actualizar-registro-checador").click(function() {
    let btnActualizar = this;
    const checador_id = $(this).data('checador-id');

    let fechaInicial = $("#fecha_inicial").val();
    let fechaFinal = $("#fecha_final").val();

    let datos = new FormData();
    datos.append('checador_id', checador_id);
    datos.append('fechaInicial', fechaInicial);
    datos.append('fechaFinal', fechaFinal);

    $.ajax({
        url: '/checador/descargaRegistros',
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
                actualizaRegistrosChecador(respuesta.historico, respuesta.columnas);
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

function cleanTableRegistrosChecador() {
    if ($.fn.DataTable.isDataTable('#tablaRegistrosChecador')) {
        $('#tablaRegistrosChecador').DataTable().clear().destroy();
    }
}

function actualizaRegistrosChecador(historico, columnas) {

    cleanTableRegistrosChecador();

    let arrayColumnsTextLeft = [1, 2, 3];
    let arrayColumnsTextCenter = [0, 4, 5];
    let arrayColumnsTextRight = [];

    dataTableListRegistrosChecador = $('#tablaRegistrosChecador').DataTable({
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