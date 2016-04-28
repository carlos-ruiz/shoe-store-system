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

function accentFold(inStr) {
  return inStr.replace(/([àáâãäå])|([ç])|([èéêë])|([ìíîï])|([ñ])|([òóôõöø])|([ß])|([ùúûü])|([ÿ])|([æ])/g, function(str,a,c,e,i,n,o,s,u,y,ae) { if(a) return 'a'; else if(c) return 'c'; else if(e) return 'e'; else if(i) return 'i'; else if(n) return 'n'; else if(o) return 'o'; else if(s) return 's'; else if(u) return 'u'; else if(y) return 'y'; else if(ae) return 'ae'; });
}

