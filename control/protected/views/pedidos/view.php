<?php
/* @var $this PedidosController */
/* @var $model Pedidos */
setlocale (LC_TIME, "es_ES");
$this->breadcrumbs=array(
	'Pedidoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pedidos', 'url'=>array('index')),
	array('label'=>'Create Pedidos', 'url'=>array('create')),
	array('label'=>'Update Pedidos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pedidos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pedidos', 'url'=>array('admin')),
);
?>

<h1>Pedido #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'Cliente',
			'value'=>$model->cliente->obtenerNombreCompleto().' ('.$model->cliente->direccion->ciudad.')',
		),
		array(
			'name'=>'fecha_pedido',
			'value'=>date_format(date_create($model->fecha_pedido), 'd-m-Y H:i:s'),
		),
		array(
			'name'=>'Fecha de entrega',
			'value'=>date_format(date_create($model->fecha_entrega), 'd-m-Y'),
		),
		array(
			'name'=>'Descuento al cliente (%)',
			'value'=>$model->cliente->descuento,
		),
		'descuento',
		'total',
		'prioridad',
		array(
			'name'=>'Forma de pago',
			'value'=>$model->formaPago->nombre,
		),
		array(
			'name'=>'Estatus del pedido',
			'value'=>$model->estatus->nombre,
		),
	),
)); ?>
<div class="descripcion-pedido form-body">
	<h3>Descripción del pedido</h3>
	<hr/>
	<div class="row">
		<div class="panel panel-red panel-ordenes">
			<div class="panel-heading">Ordenes</div>
			<div class="panel-body">
				<table class="table table-hover ordenes-pedido-table table-bordered">
					<thead>
						<tr>
							<th>Modelo</th>
							<th>Color</th>
							<th>Suela</th>
							<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
							<th><?php if(fmod($i ,1)==0){ echo $i;} else{echo "-";} ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody id="ordenes_table">
						<?php 
							$zapatosDiferentes = array();
							$datos = array();
							$id_modelo = 0;
							$id_color = 0;
							$id_suela = 0;
							$contador = 0;
							$caracteristicas_especiales = '';
							foreach ($model->pedidosZapatos as $pedidoZapato) { 
								if(
									$pedidoZapato->zapato->modelo->id != $id_modelo ||
									$pedidoZapato->zapato->color->id != $id_color ||
									$pedidoZapato->zapato->suela->id != $id_suela || 
									$pedidoZapato->caracteristicas_especiales != $caracteristicas_especiales
								) {
									$contador++;
									$zapatosDiferentes[$contador][] = $pedidoZapato->zapato->modelo->nombre;
									$zapatosDiferentes[$contador][] = $pedidoZapato->zapato->color->color;
									$zapatosDiferentes[$contador][] = $pedidoZapato->zapato->suela->nombre;
									$zapatosDiferentes[$contador][] = $pedidoZapato->caracteristicas_especiales;
									$id_modelo = $pedidoZapato->zapato->modelo->id;
									$id_suela = $pedidoZapato->zapato->suela->id;
									$id_color = $pedidoZapato->zapato->color->id;
									$caracteristicas_especiales = $pedidoZapato->caracteristicas_especiales;
								}
								
								$zapatosDiferentes[$contador][''.$pedidoZapato->zapato->numero] = $pedidoZapato->cantidad_total;
							}
						?>

						<?php foreach ($zapatosDiferentes as $index => $row) { ?>
							<?php $rowOdd = (($index % 2)==0)?1:0; ?>

							<tr class="<?= $rowOdd==1?'odd':'' ?>">
								<td><?= $row[0] ?></td>
								<td><?= $row[1] ?></td>
								<td><?= $row[2] ?></td>
								<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
									<?php if(isset($row[''.$i])){ ?>
										<td><b><?= $row[''.$i] ?></b></td>
									<?php } else { ?>
										<td></td>
									<?php } ?>
								<?php } ?>
							</tr>
							<?php if (isset($row[3])) { ?>
								<tr class="<?= $rowOdd==1?'odd':'' ?>">
									<td colspan="100" class="td-caracteristicas-especiales">
										<?= $row[3] ?>
									</td>
								</tr>
							<?php } ?>
						<?php }	?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
