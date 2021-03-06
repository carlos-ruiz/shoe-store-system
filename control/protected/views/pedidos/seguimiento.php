<script type="text/javascript">
	 /*window.onload = setupRefresh;

	 function setupRefresh() {
	 	setTimeout("refreshPage();", 30000); // milliseconds
	 }
	 */
	 function refreshPage() {
	 	window.location = location.href;
	 }
</script>

<?php
	function rand_color() {
		return sprintf('#%02X', mt_rand(0, 0xAA)).sprintf('%02X', mt_rand(0, 0xAA)).sprintf('%02X', mt_rand(0, 0xAA));
	}
?>

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
<button class="btn btn-red" onclick="refreshPage();">Recargar</button>
<div class="row">
	<?php 
		$ids_clientes = array();
		$todos_color = rand_color();
		$pedidosTerminados = array();
		foreach ($pedidos as $pedido) {
			if(!in_array($pedido->cliente->id, $ids_clientes)){
				$color = rand_color();
				$ids_clientes[$pedido->cliente->id] = $color;
			}
			if ($pedido->estatus->nombre === 'Terminado') {
				array_push($pedidosTerminados, $pedido);
			}
		}
	?>
	<?php foreach ($ids_clientes as $id_cliente => $color) { ?>
		<div class="col-md-2 detalle-cliente" style="background-color:<?= $color ?>;">
			<?= Clientes::model()->findByPk($id_cliente)->obtenerNombreCompleto() ?>
		</div>
	<?php } ?>
		<div class="col-md-2 detalle-cliente" style="background-color:<?= $todos_color ?>;">
			Todos
		</div>
</div>
<!-- style="width: 1600px;" -->
<div class="row flex-parent">
	<?php if (in_array(Yii::app()->user->getState('perfil'), array('Cortador', 'Administrador'))) { ?>
	<div class="flex-item seguimiento_pedidos_panel pedidos_corte" id="corte">
		<h3>Corte</h3>
		<hr/>
		<div class="draggable-content primera-etapa">
			<?php 
			foreach ($tarjetasCorte as $pedidoZapato) {
					$color = $ids_clientes[$pedidoZapato->pedido->id_clientes];
				 ?>
					<div class="seguimiento_pedido_detalle" style="background-color:<?= $color ?>" data-id="<?= $pedidoZapato->id ?>">
						<div class="pedido-detalle-header">
							<?= 'Pedido '.$pedidoZapato->pedido->id.' - Cliente: '.$pedidoZapato->pedido->cliente->obtenerNombreCompleto() ?>
							<hr/>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
								<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
								<p><?= 'N??mero: '.$pedidoZapato->zapato->numero ?></p>
								<p class="cantidad"><?= 'Cantidad: '.($pedidoZapato->cantidad_total - $pedidoZapato->completos) ?></p>
								<?php if(isset($pedidoZapato->caracteristicas_especiales)){ ?>
									<div class="tarjeta-especial" data-especial="<?= $pedidoZapato->caracteristicas_especiales ?>">Especial</div>
								<?php } ?>
							</div>
						</div>
					</div>
		<?php
			} ?>
		</div>
	</div>
	<?php } ?>
	<?php if (in_array(Yii::app()->user->getState('perfil'), array('Cortador', 'Pespuntador', 'Administrador'))) { ?>
	<div class="flex-item seguimiento_pedidos_panel pedidos_pespunte" id="pespunte">
		<h3>Pespunte</h3>
		<hr/>
		<div class="draggable-content primera-etapa segunda-etapa">
			<?php
			foreach ($tarjetasPespunte as $pedidoZapato) {
				$color = $ids_clientes[$pedidoZapato->pedido->id_clientes];
			 ?>
				<div class="seguimiento_pedido_detalle" style="background-color:<?= $color ?>" data-id="<?= $pedidoZapato->id ?>">
					<div class="pedido-detalle-header">
						<?= 'Pedido '.$pedidoZapato->pedido->id.' - Cliente: '.$pedidoZapato->pedido->cliente->obtenerNombreCompleto() ?>
						<hr/>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
							<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
							<p><?= 'N??mero: '.$pedidoZapato->zapato->numero ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if($pedidoZapato->zapato->ojilloColor) { ?>
								<p><?= 'Ojillos: '.$pedidoZapato->zapato->ojilloColor->ojillo->nombre ?></p>
								<p><?= 'Color ojillos: '.$pedidoZapato->zapato->ojilloColor->color->color ?></p>
							<?php } ?>
							<p class="cantidad"><?= 'Cantidad: '.($pedidoZapato->cantidad_total - $pedidoZapato->completos) ?></p>
							<?php if(isset($pedidoZapato->caracteristicas_especiales)){ ?>
								<div class="tarjeta-especial" data-especial="<?= $pedidoZapato->caracteristicas_especiales ?>">Especial</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php
			} ?>
		</div>
	</div>
	<?php } ?>
	<?php if (in_array(Yii::app()->user->getState('perfil'), array('Pespuntador', 'Ensuelador', 'Administrador'))) { ?>
	<div class="flex-item seguimiento_pedidos_panel pedidos_ensuelado" id="ensuelado">
		<h3>Ensuelado</h3>
		<hr/>
		<?php if(Yii::app()->user->getState('perfil') === 'Ensuelador') { ?>
		<div class="etiquetas-faltantes">
			<div class="pares-faltantes-titulo">Pares faltantes</div>
			<div class="falta falta-1" data-faltantes="1">1</div>
			<div class="falta falta-2" data-faltantes="2">2</div>
			<div class="falta falta-3" data-faltantes="3">3</div>
			<div class="falta falta-4" data-faltantes="4">4</div>
			<div class="falta falta-5" data-faltantes="5">5</div>
		</div>
		<?php } ?>
		<div class="draggable-content segunda-etapa tercera-etapa">
			<?php 
				foreach ($tarjetasEnsuelado as $pedidoZapato) {
					$color = $ids_clientes[$pedidoZapato->pedido->id_clientes];
					?>
					<div class="seguimiento_pedido_detalle"  id="seguimiento_pedido_detalle_<?= $pedidoZapato->id ?>" style="background-color:<?= $color ?>" data-id="<?= $pedidoZapato->id ?>">
						<div class="pedido-detalle-header">
							<?= 'Pedido '.$pedidoZapato->pedido->id.' - Cliente: '.$pedidoZapato->pedido->cliente->obtenerNombreCompleto() ?>
							<hr/>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
								<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
								<p><?= 'N??mero: '.$pedidoZapato->zapato->numero ?></p>
								<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
								<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
								<p class="cantidad"><?= 'Cantidad: '.($pedidoZapato->cantidad_total - $pedidoZapato->completos) ?></p>
								<?php if(isset($pedidoZapato->caracteristicas_especiales)){ ?>
									<div class="tarjeta-especial" data-especial="<?= $pedidoZapato->caracteristicas_especiales ?>">Especial</div>
								<?php } ?>
							</div>
						</div>
					</div>
			<?php
				} ?>
		</div>
	</div>
	<?php } ?>
	<?php if (in_array(Yii::app()->user->getState('perfil'), array('Ensuelador', 'Adornador', 'Administrador'))) { ?>
	<div class="flex-item seguimiento_pedidos_panel pedidos_adorno" id="adorno">
		<h3>Adorno</h3>
		<hr/>
		<div class="draggable-content tercera-etapa cuarta-etapa">
			<?php 
				foreach ($tarjetasAdornado as $pedidoZapato) {
					$color = $ids_clientes[$pedidoZapato->pedido->id_clientes];
					?>
					<div class="seguimiento_pedido_detalle" style="background-color: <?= $color ?>" data-id="<?= $pedidoZapato->id ?>">
						<div class="pedido-detalle-header">
							<?= 'Pedido '.$pedidoZapato->pedido->id.' - Cliente: '.$pedidoZapato->pedido->cliente->obtenerNombreCompleto() ?>
							<hr/>
						</div>
						<div class="row">
							<div class="col-md-12">
								<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
								<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
								<p><?= 'N??mero: '.$pedidoZapato->zapato->numero ?></p>
								<p class="cantidad"><?= 'Cantidad: '.($pedidoZapato->cantidad_total - $pedidoZapato->completos) ?></p>
								<?php if(isset($pedidoZapato->caracteristicas_especiales)){ ?>
									<div class="tarjeta-especial" data-especial="<?= $pedidoZapato->caracteristicas_especiales ?>">Especial</div>
								<?php } ?>
							</div>
						</div>
					</div>
			<?php	
				} ?>
		</div>
	</div>
	<?php } ?>
	<?php if (in_array(Yii::app()->user->getState('perfil'), array('Adornador', 'Administrador'))) { ?>
	<div class="flex-item seguimiento_pedidos_panel pedidos_terminado" id="terminado">
		<h3>Terminado</h3>
		<hr/>
		<div class="draggable-content cuarta-etapa">
			<?php
				foreach ($pedidosTerminados as $pedido) {
					$color = $ids_clientes[$pedido->id_clientes]; ?>
				<div class="seguimiento_pedido_detalle" style="background-color: <?= $color ?>">
					<div class="row">
						<div class="col-md-6">
							<p>Cliente: <?= $pedido->cliente->obtenerNombreCompleto() ?></p>
						</div>
						<div class="col-md-6">
							<p>Fecha de entrega: <?= $pedido->fecha_entrega ?></p>
							<p>Fecha de pedido: <?= $pedido->fecha_pedido ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php if(Yii::app()->user->getState('perfil') === 'Administrador'){ ?>
							<a class="btn-entregar" href="<?= Yii::app()->request->baseUrl ?>/pedidos/entregarpedido/<?= $pedido->id ?>">Entregar</a>
							<?php } ?>
							<a class="btn-entregar" href="<?= Yii::app()->request->baseUrl ?>/pedidos/<?= $pedido->id ?>">Ver</a>
						</div>
					</div>
				</div>
			<?php
				}
				foreach ($tarjetasTerminado as $pedidoZapato) {
					$color = $ids_clientes[$pedidoZapato->pedido->id_clientes];
					?>
					<div class="seguimiento_pedido_detalle" style="background-color: <?= $color ?>" data-id="<?= $pedidoZapato->id ?>">
						<div class="pedido-detalle-header">
							<?= 'Pedido '.$pedidoZapato->pedido->id.' - Cliente: '.$pedidoZapato->pedido->cliente->obtenerNombreCompleto() ?>
							<hr/>
						</div>
						<div class="row">
							<div class="col-md-6">
								<p><?= 'Modelo: '.$pedidoZapato->zapato->modelo->nombre ?></p>
								<p><?= 'Color: '.$pedidoZapato->zapato->color->color ?></p>
								<p><?= 'N??mero: '.$pedidoZapato->zapato->numero ?></p>
							</div>
							<div class="col-md-6">
								<p><?= 'Suela: '.$pedidoZapato->zapato->suelaColor->suela->nombre ?></p>
								<p><?= 'Color suela: '.$pedidoZapato->zapato->suelaColor->color->color ?></p>
								<p class="cantidad"><?= 'Cantidad: '.($pedidoZapato->cantidad_total - $pedidoZapato->completos) ?></p>
								<?php if(isset($pedidoZapato->caracteristicas_especiales)){ ?>
									<div class="tarjeta-especial" data-especial="<?= $pedidoZapato->caracteristicas_especiales ?>">Especial</div>
								<?php } ?>
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
			<?php	
				} ?>
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.draggable-content').each(function(){
			diferenciaAlto = $('.draggable-content').offset().top - $('.seguimiento_pedidos_panel').offset().top;
			altoPadre = $('.seguimiento_pedidos_panel ').height()-diferenciaAlto+10;
			//alert(parentHeight);
			$(this).css('height', altoPadre);

		});
	});

	$(function() {
		$( ".primera-etapa" ).sortable({
			connectWith: ".primera-etapa",
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

		$(".etiquetas-faltantes div").draggable({ revert: true });
		$(".pedidos_ensuelado .seguimiento_pedido_detalle").droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			drop: function(event, ui) {
				idPedidoZapato = $(this).data('id');
				faltantes = ui.draggable.data('faltantes');
				definirFaltantes(idPedidoZapato, faltantes);
			}
	    });

		$( ".pedidos_pendientes, .pedidos_corte, .pedidos_pespunte, .pedidos_ensuelado, .pedidos_adorno, .pedidos_terminado, .etiquetas-faltantes" ).disableSelection();
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
			case 'adorno':
				estatus = 'En adorno';
			break;
			case 'terminado':
				estatus = 'Terminado';
			break;
		}

		jQuery.ajax({
			'url':'../../pedidos/actualizarEstatusZapatos',
			'type':'POST',
			'cache':false,
			'data':{ 'estatus': estatus, 'id': idPedidoZapato },
			'success':function(response){
				console.log(response);
			}
		});
	}

	function definirFaltantes(idPedidoZapato, faltantes)
	{
		jQuery.ajax({
			'url':'../../pedidos/actualizarFaltantes',
			'type':'POST',
			'cache':false,
			'data':{ 'faltantes': faltantes, 'id': idPedidoZapato },
			'success':function(response){
				if (response === 'ERROR') {
					alerta('La cantidad total es menor que la cantidad faltante', 'ERROR');
					return;
				}
				$('#seguimiento_pedido_detalle_'+idPedidoZapato).find('.cantidad').text('Cantidad: '+faltantes);
			}
		});
	}

	function accentFold(inStr) 
	{
		return inStr.replace(/([????????????])|([??])|([????????])|([????????])|([??])|([????????????])|([??])|([????????])|([??])|([??])/g, function(str,a,c,e,i,n,o,s,u,y,ae) { if(a) return 'a'; else if(c) return 'c'; else if(e) return 'e'; else if(i) return 'i'; else if(n) return 'n'; else if(o) return 'o'; else if(s) return 's'; else if(u) return 'u'; else if(y) return 'y'; else if(ae) return 'ae'; });
	}

	$('.search-panel button').click(function(){
		search();
	});

	$('.search-panel input').change(function (){
		search();
	});

	function search() {
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
	}

	$('.detalle-cliente').click(function(){
		var textSearch = accentFold($(this).text().trim()).toLowerCase();
		$(".seguimiento_pedido_detalle").each(function(){
			var textoProducto = accentFold($(this).text()).toLowerCase();
			if(textSearch === 'todos') {
				$(this).show(500);
			}
			else if(textoProducto.indexOf(textSearch)<0){
				$(this).hide(500);
			}else{
				$(this).show(500);
			}
		});
	});

	$('.tarjeta-especial').click(function(){
		alert($(this).data('especial'));
	});
</script>