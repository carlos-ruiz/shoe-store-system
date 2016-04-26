<?php
/* @var $this SuelasController */
/* @var $model Suelas */
/* @var $form CActiveForm */
?>

<h1>Agregar al inventario</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agujetas-ojillos-add-stock-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="row">
			<div class="panel panel-red panel-ordenes">
				<div class="panel-heading">Agregar agujetas y ojillos al inventario</div>
				<div class="panel-body">
					<table class="table table-hover table-striped without-padding-table" summary="Muestra todas las variantes de agujetas y ojillos para agregar a inventarios">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Nombre</th>
								<th>Color</th>
								<th>Cantidad</th>
								<th>Cantidad mínima</th>
								<th>Unidad de medida</th>
								<th>Precio</th>
							</tr>
						</thead>
						<tbody id="ordenes_table">
							<?php foreach ($agujetas as $agujeta) { 
								$tipoArticulo = TiposArticulosInventario::model()->find('tipo="Agujetas"');
								foreach ($agujeta->agujetasColores as $agujetaColor) {
									$time = microtime();
									$time = str_replace(' ', '', $time);
									$time = str_replace('.', '', $time);
									$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=?', array($tipoArticulo->id, $agujeta->id, $agujetaColor->id_colores));
									$precioActual = isset($inventario)?$inventario->ultimo_precio:0;
									$stock = isset($inventario)?$inventario->stock_minimo:0;
								?>
									<tr id="row_<?= $time ?>">
										<td class="tipo">Agujeta<input type="hidden" name="Inventario[agujeta][<?= $time ?>][id]" value="<?= $agujeta->id ?>">
										</td>
										<td class="nombre">
											<?= $agujeta->nombre ?>
											<input type="hidden" name="Inventario[agujeta][<?= $time ?>][nombre]" value="<?= $agujeta->nombre ?>">
										</td>
										<td class="color">
											<?= $agujetaColor->color->color ?>
											<input type="hidden" name="Inventario[agujeta][<?= $time ?>][id_color]" value="<?= $agujetaColor->color->id ?>">
										</td>
										<td>
											<input class="input-cantidad" type="number" name="Inventario[agujeta][<?= $time ?>][cantidad]" min="0" required value="0"/>
										</td>
										<td>
											<input class="input-stock" type="number" name="Inventario[agujeta][<?= $time ?>][stock]" min="0" value="<?= $stock ?>" required/>
										</td>
										<td>Piezas</td>
										<td>
											<input class="input-precio" type="number" name="Inventario[agujeta][<?= $time ?>][precio]" min="0" max="9999" step="0.001" value="<?= $precioActual ?>" required/>
										</td>
									</tr>
							<?php
								}
							}
							?>
							<?php foreach ($ojillos as $ojillo) { 
								$tipoArticulo = TiposArticulosInventario::model()->find('tipo="Ojillos"');
								foreach ($ojillo->ojillosColores as $ojilloColor) {
									$time = microtime();
									$time = str_replace(' ', '', $time);
									$time = str_replace('.', '', $time);
									$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=?', array($tipoArticulo->id, $ojillo->id, $ojilloColor->id_colores));
									$precioActual = isset($inventario)?$inventario->ultimo_precio:0;
									$stock = isset($inventario)?$inventario->stock_minimo:0;
								?>
									<tr id="row_<?= $time ?>">
										<td class="tipo">Ojillo<input type="hidden" name="Inventario[ojillo][<?= $time ?>][id]" value="<?= $ojillo->id ?>">
										</td>
										<td class="nombre">
											<?= $ojillo->nombre ?>
											<input type="hidden" name="Inventario[ojillo][<?= $time ?>][nombre]" value="<?= $ojillo->nombre ?>">
										</td>
										<td class="color">
											<?= $ojilloColor->color->color ?>
											<input type="hidden" name="Inventario[ojillo][<?= $time ?>][id_color]" value="<?= $ojilloColor->color->id ?>">
										</td>
										<td>
											<input class="input-cantidad" type="number" name="Inventario[ojillo][<?= $time ?>][cantidad]" min="0" value="0"/>
										</td>
										<td>
											<input class="input-stock" type="number" name="Inventario[ojillo][<?= $time ?>][stock]" min="0" value="<?= $stock ?>"/>
										</td>
										<td>Piezas</td>
										<td>
											<input class="input-precio" type="number" name="Inventario[ojillo][<?= $time ?>][precio]" min="0" max="9999" step="0.001" value="<?= $precioActual ?>"/>
										</td>
									</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton('Aplicar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->