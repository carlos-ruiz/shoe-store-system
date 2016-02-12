<div class="row">
	<div class="col-md-8"><h1>Seguimiento de todos los pedidos</h1></div>
	<div class="col-md-4">
		<div class="input-group col-md-12 search-panel">
            <input type="text" class="form-control input-lg" placeholder="Buscar" />
            <span class="input-group-btn">
                <button class="btn btn-red btn-lg" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
	</div>
</div>
<hr/>
<div class="row flex-parent" style="width: 1600px;">
	<div class="flex-item seguimiento_pedidos_panel pedidos_pendientes" id="pendientes">
		<h3>Pendientes</h3>
		<hr/>
		<div class="draggable-content droptrue primera-etapa">
			<?php 
			$estatusZapatoPendiente = EstatusZapatos::model()->find('nombre=?', array('Pendiente'));
			foreach ($pedidos as $pedido) { 
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					if($pedidoZapato->id_estatus_zapatos == $estatusZapatoPendiente->id){ ?>
						<div class="seguimiento_pedido_detalle" data-id="<?= $pedidoZapato->id ?>">
							<div class="pedido-detalle-header">
								<?= 'Pedido '.$pedido->id.' - Cliente: '.$pedido->cliente->obtenerNombreCompleto() ?>
								<hr/>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
									<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
									<p><?= 'Número: '.$pedidoZapato->zapato->numero ?></p>
								</div>
								<div class="col-md-6">
									<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
									<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
									<p><?= 'Cantidad: '.$pedidoZapato->cantidad_total ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->agujetaColor) { ?>
										<p><?= 'Agujeta: '.$pedidoZapato->zapato->agujetaColor->agujeta->nombre ?></p>
										<p><?= 'Color agujeta: '.$pedidoZapato->zapato->agujetaColor->color->color ?></p>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->ojilloColor) { ?>
										<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
										<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
			<?php   }
				}
			} ?>
		</div>
	</div>
	<div class="flex-item seguimiento_pedidos_panel pedidos_corte" id="corte">
		<h3>Corte</h3>
		<hr/>
		<div class="draggable-content primera-etapa segunda-etapa">
			<?php 
			$estatusZapatoCorte = EstatusZapatos::model()->find('nombre=?', array('En corte'));
			foreach ($pedidos as $pedido) { 
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					if($pedidoZapato->id_estatus_zapatos == $estatusZapatoCorte->id){ ?>
						<div class="seguimiento_pedido_detalle" data-id="<?= $pedidoZapato->id ?>">
							<div class="pedido-detalle-header">
								<?= 'Pedido '.$pedido->id.' - Cliente: '.$pedido->cliente->obtenerNombreCompleto() ?>
								<hr/>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
									<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
									<p><?= 'Número: '.$pedidoZapato->zapato->numero ?></p>
								</div>
								<div class="col-md-6">
									<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
									<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
									<p><?= 'Cantidad: '.$pedidoZapato->cantidad_total ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->agujetaColor) { ?>
										<p><?= 'Agujeta: '.$pedidoZapato->zapato->agujetaColor->agujeta->nombre ?></p>
										<p><?= 'Color agujeta: '.$pedidoZapato->zapato->agujetaColor->color->color ?></p>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->ojilloColor) { ?>
										<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
										<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
			<?php	}
				}
			} ?>
		</div>
	</div>
	<div class="flex-item seguimiento_pedidos_panel pedidos_pespunte" id="pespunte">
		<h3>Pespunte</h3>
		<hr/>
		<div class="draggable-content segunda-etapa tercera-etapa">
			<?php 
			$estatusZapatoPespunte = EstatusZapatos::model()->find('nombre=?', array('En pespunte'));
			foreach ($pedidos as $pedido) { 
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					if($pedidoZapato->id_estatus_zapatos == $estatusZapatoPespunte->id){ ?>
						<div class="seguimiento_pedido_detalle" data-id="<?= $pedidoZapato->id ?>">
							<div class="pedido-detalle-header">
								<?= 'Pedido '.$pedido->id.' - Cliente: '.$pedido->cliente->obtenerNombreCompleto() ?>
								<hr/>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
									<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
									<p><?= 'Número: '.$pedidoZapato->zapato->numero ?></p>
								</div>
								<div class="col-md-6">
									<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
									<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
									<p><?= 'Cantidad: '.$pedidoZapato->cantidad_total ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->agujetaColor) { ?>
										<p><?= 'Agujeta: '.$pedidoZapato->zapato->agujetaColor->agujeta->nombre ?></p>
										<p><?= 'Color agujeta: '.$pedidoZapato->zapato->agujetaColor->color->color ?></p>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->ojilloColor) { ?>
										<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
										<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
			<?php	}
				}
			} ?>
		</div>
	</div>
	<div class="flex-item seguimiento_pedidos_panel pedidos_ensuelado" id="ensuelado">
		<h3>Ensuelado</h3>
		<hr/>
		<div class="draggable-content tercera-etapa cuarta-etapa">
			<?php 
			$estatusZapatoEnsuelado = EstatusZapatos::model()->find('nombre=?', array('En ensuelado'));
			foreach ($pedidos as $pedido) { 
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					if($pedidoZapato->id_estatus_zapatos == $estatusZapatoEnsuelado->id){ ?>
						<div class="seguimiento_pedido_detalle" data-id="<?= $pedidoZapato->id ?>">
							<div class="pedido-detalle-header">
								<?= 'Pedido '.$pedido->id.' - Cliente: '.$pedido->cliente->obtenerNombreCompleto() ?>
								<hr/>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
									<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
									<p><?= 'Número: '.$pedidoZapato->zapato->numero ?></p>
								</div>
								<div class="col-md-6">
									<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
									<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
									<p><?= 'Cantidad: '.$pedidoZapato->cantidad_total ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->agujetaColor) { ?>
										<p><?= 'Agujeta: '.$pedidoZapato->zapato->agujetaColor->agujeta->nombre ?></p>
										<p><?= 'Color agujeta: '.$pedidoZapato->zapato->agujetaColor->color->color ?></p>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->ojilloColor) { ?>
										<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
										<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
			<?php	}
				}
			} ?>
		</div>
	</div>
	<div class="flex-item seguimiento_pedidos_panel pedidos_terminado" id="terminado">
		<h3>Terminados</h3>
		<hr/>
		<div class="draggable-content cuarta-etapa">
			<?php 
			$estatusZapatoTerminado = EstatusZapatos::model()->find('nombre=?', array('Terminado'));
			foreach ($pedidos as $pedido) { 
				foreach ($pedido->pedidosZapatos as $pedidoZapato) {
					if($pedidoZapato->id_estatus_zapatos == $estatusZapatoTerminado->id){ ?>
						<div class="seguimiento_pedido_detalle" data-id="<?= $pedidoZapato->id ?>">
							<div class="pedido-detalle-header">
								<?= 'Pedido '.$pedido->id.' - Cliente: '.$pedido->cliente->obtenerNombreCompleto() ?>
								<hr/>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
									<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
									<p><?= 'Número: '.$pedidoZapato->zapato->numero ?></p>
								</div>
								<div class="col-md-6">
									<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
									<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
									<p><?= 'Cantidad: '.$pedidoZapato->cantidad_total ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->agujetaColor) { ?>
										<p><?= 'Agujeta: '.$pedidoZapato->zapato->agujetaColor->agujeta->nombre ?></p>
										<p><?= 'Color agujeta: '.$pedidoZapato->zapato->agujetaColor->color->color ?></p>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php if($pedidoZapato->zapato->ojilloColor) { ?>
										<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
										<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
									<?php } ?>
								</div>
							</div>
						</div>
			<?php	}
				}
			} ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$( ".primera-etapa" ).sortable({
			connectWith: "div.primera-etapa",
	        receive: function(event, ui) {
	           actualizarEstatus($(this).parent().attr('id'), ui.item.data("id"));
	        }
		});
		$( ".segunda-etapa" ).sortable({
			connectWith: ".segunda-etapa, .primera-etapa",
	        receive: function(event, ui) {
	           actualizarEstatus($(this).parent().attr('id'), ui.item.data("id"));
	        }
		});
		$( ".tercera-etapa" ).sortable({
			connectWith: ".tercera-etapa, .segunda-etapa",
	        receive: function(event, ui) {
	           actualizarEstatus($(this).parent().attr('id'), ui.item.data("id"));
	        }
		});
		$( ".cuarta-etapa" ).sortable({
			connectWith: ".cuarta-etapa, .tercera-etapa",
	        receive: function(event, ui) {
	           actualizarEstatus($(this).parent().attr('id'), ui.item.data("id"));
	        }
		});

		$( ".pedidos_pendientes, .pedidos_corte, .pedidos_pespunte, .pedidos_ensuelado, .pedidos_terminado" ).disableSelection();
	});

	function actualizarEstatus(idEtapa, idPedidoZapato)
	{
		var estatus = '';
		switch(idEtapa){
			case 'pendientes':
				estatus = 'Pendiente';
			break;
			case 'corte':
				estatus = 'En corte';
			break;
			case 'pespunte':
				estatus = 'En pespunte';
			break;
			case 'ensuelado':
				estatus = 'En ensuelado';
			break;
			case 'terminado':
				estatus = 'Terminado';
			break;
		}

		jQuery.ajax({
			'url':'/controlbom/control/pedidos/actualizarEstatusZapatos',
			'type':'POST',
			'cache':false,
			'data':{ 'estatus': estatus, 'id': idPedidoZapato },
			'success':function(response){
				console.log(response);
			}
		});
	}

	function accentFold(inStr) 
	{
		return inStr.replace(/([àáâãäå])|([ç])|([èéêë])|([ìíîï])|([ñ])|([òóôõöø])|([ß])|([ùúûü])|([ÿ])|([æ])/g, function(str,a,c,e,i,n,o,s,u,y,ae) { if(a) return 'a'; else if(c) return 'c'; else if(e) return 'e'; else if(i) return 'i'; else if(n) return 'n'; else if(o) return 'o'; else if(s) return 's'; else if(u) return 'u'; else if(y) return 'y'; else if(ae) return 'ae'; });
	}

	$('.search-panel button').click(function(){
		var textSearch = accentFold($(".search-panel input").val()).toLowerCase();
		if(textSearch.length>0){
			$(".seguimiento_pedido_detalle").each(function(){
				var textoProducto = accentFold($(this).text()).toLowerCase();
				if(textoProducto.indexOf(textSearch)<0){
					$(this).hide(500);
				}else{
					$(this).show(500);
				}
			});
		}else{
			$(".seguimiento_pedido_detalle").show(500);
		}
	});
</script>