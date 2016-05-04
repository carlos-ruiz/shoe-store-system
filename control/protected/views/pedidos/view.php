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
			'label'=>'Cliente',
			'value'=>$model->cliente->obtenerNombreCompleto().' ('.$model->cliente->direccion->ciudad.')',
		),
		array(
			'name'=>'fecha_pedido',
			'value'=>date_format(date_create($model->fecha_pedido), 'd-m-Y H:i:s'),
		),
		array(
			'label'=>'Fecha de entrega',
			'value'=>date_format(date_create($model->fecha_entrega), 'd-m-Y'),
		),
		'descuento',
		array(
			'label'=>'Decuento por cliente (%)',
			'value'=>$model->cliente->descuento,
		),
		array(
			'name'=>'gastos_envio',
			'value'=>$model->gastos_envio,
		),
		array(
			'label'=>'Cantidad total',
			'value'=>'$'.number_format($model->total, 2),
		),
		'prioridad',
		array(
			'label'=>'Forma de pago',
			'value'=>$model->formaPago->nombre,
		),
		array(
			'label'=>'Estatus del pedido',
			'value'=>$model->estatus->nombre,
		),
		array(
			'label'=>'Estatus del pago',
			'value'=>$model->estatusPago->nombre,
		),
		array(
			'label'=>'Cantidad por pagar',
			'value'=>'$'.number_format($model->obtenerAdeudo(), 2),
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
							<th>Color de suela</th>

							<th>Agujetas</th>
							<th>Color de agujetas</th>

							<th>Ojillos</th>
							<th>Color de ojillos</th>
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
							$id_color_suela = 0;
							$id_agujeta = 0;
							$id_color_agujeta = 0;
							$id_ojillo = 0;
							$id_color_ojillo = 0;
							$contador = 0;
							$caracteristicas_especiales = '';
							foreach ($model->pedidosZapatos as $pedidoZapato) { 
								if(
									$pedidoZapato->zapato->modelo->id != $id_modelo ||
									$pedidoZapato->zapato->color->id != $id_color ||
									$pedidoZapato->zapato->suelaColor->suela->id != $id_suela || 
									$pedidoZapato->zapato->suelaColor->color->id != $id_color_suela || 
									$pedidoZapato->caracteristicas_especiales != $caracteristicas_especiales
								) {
									if (isset($pedidoZapato->zapato->agujetaColor)) {
										if (
											$pedidoZapato->zapato->agujetaColor->agujeta->id != $id_agujeta || 
											$pedidoZapato->zapato->agujetaColor->color->id != $id_color_agujeta || 
											$pedidoZapato->zapato->ojilloColor->ojillo->id != $id_ojillo || 
											$pedidoZapato->zapato->ojilloColor->color->id != $id_color_ojillo) {
											$contador++;
											
											$zapatosDiferentes[$contador]['agujeta'] = $pedidoZapato->zapato->agujetaColor->agujeta->nombre;
											$zapatosDiferentes[$contador]['coloragujeta'] = $pedidoZapato->zapato->agujetaColor->color->color;
											$zapatosDiferentes[$contador]['ojillo'] = $pedidoZapato->zapato->ojilloColor->ojillo->nombre;
											$zapatosDiferentes[$contador]['colorojillo'] = $pedidoZapato->zapato->ojilloColor->color->color;		
										}
									}
									else{
										$contador++;
										$zapatosDiferentes[$contador]['agujeta'] = 'N/A';
										$zapatosDiferentes[$contador]['coloragujeta'] = 'N/A';
										$zapatosDiferentes[$contador]['ojillo'] = 'N/A';
										$zapatosDiferentes[$contador]['colorojillo'] = 'N/A';
									}
									$zapatosDiferentes[$contador]['modelo'] = $pedidoZapato->zapato->modelo->nombre;
									$zapatosDiferentes[$contador]['color'] = $pedidoZapato->zapato->color->color;
									$zapatosDiferentes[$contador]['suela'] = $pedidoZapato->zapato->suelaColor->suela->nombre;
									$zapatosDiferentes[$contador]['colorsuela'] = $pedidoZapato->zapato->suelaColor->color->color;
									$zapatosDiferentes[$contador]['especial'] = $pedidoZapato->caracteristicas_especiales;
									$id_modelo = $pedidoZapato->zapato->modelo->id;
									$id_suela = $pedidoZapato->zapato->suelaColor->suela->id;
									$id_color_suela = $pedidoZapato->zapato->suelaColor->color->id;
									$id_color = $pedidoZapato->zapato->color->id;
									$caracteristicas_especiales = $pedidoZapato->caracteristicas_especiales;
								}
								if(!isset($zapatosDiferentes[$contador][''.$pedidoZapato->zapato->numero])){
									$zapatosDiferentes[$contador][''.$pedidoZapato->zapato->numero] = 0;

								}
								$zapatosDiferentes[$contador][''.$pedidoZapato->zapato->numero] += $pedidoZapato->cantidad_total;
							}
						?>

						<?php foreach ($zapatosDiferentes as $index => $row) { ?>
							<?php $rowOdd = (($index % 2)==0)?1:0; ?>

							<tr class="<?= $rowOdd==1?'odd':'' ?>">
								<td><?= $row['modelo'] ?></td>
								<td><?= $row['color'] ?></td>
								<td><?= $row['suela'] ?></td>
								<td><?= $row['colorsuela'] ?></td>
								<td><?= $row['agujeta'] ?></td>
								<td><?= $row['coloragujeta'] ?></td>
								<td><?= $row['ojillo'] ?></td>
								<td><?= $row['colorojillo'] ?></td>
								<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
									<?php if(isset($row[''.$i])){ ?>
										<td><b><?= $row[''.$i] ?></b></td>
									<?php } else { ?>
										<td></td>
									<?php } ?>
								<?php } ?>
							</tr>
							<?php if (isset($row[4])) { ?>
								<tr class="<?= $rowOdd==1?'odd':'' ?>">
									<td colspan="100" class="td-caracteristicas-especiales">
										<?= $row[4] ?>
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

<div class="row">
	<h4 class="col-md-12">Cantidad de pares: <?= $total_pares ?></h4>
</div>

<div class="pago-proveedores">
	<h3>Por pagar a proveedores:</h3>
	<?php 
		$deudasProveedores = DeudasPedidosProveedores::model()->findAll('id_pedidos=?', array($model->id));
		$total = 0;
		foreach ($deudasProveedores as $deudaPedidoProveedor) { 
			$total += $deudaPedidoProveedor->cantidad;	?>
			<div class="col-md-3"><?= $deudaPedidoProveedor->proveedor->nombre ?>: <?= $deudaPedidoProveedor->cantidad ?></div>
	<?php
		}
	?>
		<h4 class="col-md-12">Total: <?= $total ?></h4>
</div>

<?php if(!Yii::app()->user->isGuest) { ?>
	<div class="row">
		<div class="col-md-12 padding-top">
			<?php echo CHtml::link('<i class="fa fa-print"></i> Imprimir etiquetas', array('pedidos/imprimirEtiquetasPedido/'.$model->id), array('class'=>'link-button', 'target'=>'_blank')); ?>
		</div>
	</div>
<?php } ?>
