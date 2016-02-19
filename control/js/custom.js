function alerta(mensaje, titulo){
	$("#modal_title").html(titulo);
	$("#modal_alert").find(".modal-body").html(mensaje);
	$("#modal_alert").modal("show");
}

function alerta(mensaje, titulo, destino){
	$("#modal_title").html(titulo);
	$("#modal_alert").find(".modal-body").html(mensaje);
	$("#modal_alert").modal("show");
	$("#modal_button").attr('href', destino);
}
