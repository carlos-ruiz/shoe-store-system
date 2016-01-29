<?php
/* @var $this TaconesController */
/* @var $model Tacones */
/* @var $form CActiveForm */
?>
<?php
	$taconesDiferentes = array();
	$contador = 0;
	foreach ($tacones as $tacon) { 
		foreach ($tacon->taconesColores as $i => $taconColor) {
			$taconesDiferentes[$contador]['id_tacon'] = $tacon->id;
			$taconesDiferentes[$contador]['tacon'] = $tacon->nombre;
			$taconesDiferentes[$contador]['id_color'] = $taconColor->id_colores;
			$taconesDiferentes[$contador]['color'] = $taconColor->color->color;
			$taconesDiferentes[$contador]['id_tacon_color'] = $taconColor->id;
			$contador++;
		}
	}
?>
<h1>Agregar al inventario</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'suelas-add-stock-form',
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
				<div class="panel-heading">Agregar tacones a inventario</div>
				<div class="panel-body">
					<table class="table table-hover table-striped without-padding-table" summary="Muestra todas las variantes de tacones para agregar a inventarios">
						<thead>
							<tr>
								<th>Tacón</th>
								<th>Color</th>
								<?php for ($i=12; $i < 32 ; $i++) { ?>
								<th><?= $i ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody id="ordenes_table">
							<?php foreach ($taconesDiferentes as $index => $row) { 
								$time = microtime();
								$time = str_replace(' ', '', $time);
								$time = str_replace('.', '', $time);
								$taconNumeros = TaconesNumeros::model()->findAll('id_tacones=?', array($row['id_tacon']));
								$numerosPosibles = array();
								foreach ($taconNumeros as $taconNumero) {
									array_push($numerosPosibles, $taconNumero->numero);
								}
								?>

								<tr id="row_<?= $time ?>">
									<td class="tacon" data-id="<?= $row['id_tacon'] ?>">
										<?= $row['tacon'] ?><input type="hidden" name="Inventario[taconColor][<?= $time ?>]" value="<?= $row['id_tacon_color'] ?>">
									</td>
									<td class="color" data-id="<?= $row['id_color'] ?>">
										<?= $row['color'] ?>
									</td>
									<?php for ($i=12; $i < 32; $i++) { ?>
										<td data-numero="<?= $i ?>">
											<input class="input-cantidad" type="number" name="Inventario[numeros][<?= $time ?>][<?= $i ?>]" min="0" max="9999" <?php if(!in_array($i, $numerosPosibles)) {echo "disabled value='X'";}else{echo "value='";if(isset($row[''.$i])){echo $row[''.$i];}echo "'";} ?>/>
										</td>
									<?php } ?>
								</tr>
							<?php }	?>
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