// Variables y Constantes Globales



// Ejecuta en cuanto la página esté lista
$(document).ready(function() {

	$(".select2").select2({
		language: "es",
		theme: "bootstrap4",
		tags: false // No crea nuevos items
	});

	// Configuracion del Header en las llamadas Ajax
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('input[name="_token"]').val()
	    }
	});

	stopLoading();

});



// ---------------------------
// --- Funciones Genéricas ---
// ---------------------------


