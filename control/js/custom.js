function alerta(mensaje, titulo){
	$("#modal_title").html(titulo);
	$("#modal_alert").find(".modal-body").html(mensaje);
	$("#modal_alert").modal("show");
}
