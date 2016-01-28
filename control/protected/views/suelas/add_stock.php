<?php
/* @var $this SuelasController */
/* @var $model Suelas */
/* @var $form CActiveForm */
?>
<?php
	$suelasDiferentes = array();
	$contador = 0;
	foreach ($suelas as $suela) { 
		foreach ($suela->suelasColores as $i => $suelaColor) {
			$suelasDiferentes[$contador]['id_suela'] = $suela->id;
			$suelasDiferentes[$contador]['suela'] = $suela->nombre;
			$suelasDiferentes[$contador]['id_color'] = $suelaColor->id_colores;
			$suelasDiferentes[$contador]['color'] = $suelaColor->color->color;
			$suelasDiferentes[$contador]['id_suela_color'] = $suelaColor->id;
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
				<div class="panel-heading">Agregar suelas a inventario</div>
				<div class="panel-body">
					<table class="table table-hover table-striped without-padding-table" summary="Muestra todas las variantes de suelas para agregar a inventarios">
						<thead>
							<tr>
								<th>Suela</th>
								<th>Color</th>
								<?php for ($i=12; $i < 32 ; $i++) { ?>
								<th><?= $i ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody id="ordenes_table">
							<?php foreach ($suelasDiferentes as $index => $row) { 
								$time = microtime();
								$time = str_replace(' ', '', $time);
								$time = str_replace('.', '', $time);
								$suelaNumeros = SuelasNumeros::model()->findAll('id_suelas=?', array($row['id_suela']));
								$numerosPosibles = array();
								foreach ($suelaNumeros as $suelaNumero) {
									array_push($numerosPosibles, $suelaNumero->numero);
								}
								?>

								<tr id="row_<?= $time ?>">
									<td class="suela" data-id="<?= $row['id_suela'] ?>">
										<?= $row['suela'] ?><input type="hidden" name="Inventario[suelacolor][<?= $time ?>]" value="<?= $row['id_suela_color'] ?>">
									</td>
									<td class="color" data-id="<?= $row['id_color'] ?>">
										<?= $row['color'] ?>
									</td>
									<?php for ($i=12; $i < 32; $i++) { ?>
										<td data-numero="<?= $i ?>">
											<input class="input-cantidad" type="text" name="Inventario[numeros][<?= $time ?>][<?= $i ?>]" maxlength="4" size="1" <?php if(!in_array($i, $numerosPosibles)) {echo "disabled value='X'";}else{echo "value='";if(isset($row[''.$i])){echo $row[''.$i];}echo "'";} ?>/>
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