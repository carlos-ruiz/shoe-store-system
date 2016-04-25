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
								<?php for ($i=12; $i < 33 ; $i++) { ?>
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
									<?php for ($i=12; $i < 33; $i++) { ?>
										<td data-numero="<?= $i ?>">
											<input class="input-cantidad" type="text" name="Inventario[numeros][<?= $time ?>][<?= $i ?>]" size="1" <?php if(!in_array($i, $numerosPosibles)) {echo "disabled value='X'";}else{echo "value='";if(isset($row[''.$i])){echo $row[''.$i];}echo "'";} ?>/>
										</td>
									<?php } ?>
								</tr>
							<?php }	?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="Suelas_stock_minimo_check">Aplicar mismo stock minimo a todas las suelas que se agregarán</label>
				<div class="input-group inline-block">
					<input size="45" maxlength="45" name="Suelas[stock_minimo_general]" id="Suelas_stock_minimo_check" value="1" type="checkbox">
				</div>
			</div>
		</div>
		<div class="row" id="stock_minimo_panel">
			<div class="form-group col-md-6">
				<div class="input-group inline-block">
					<input size="45" maxlength="45" name="Suelas[stock_minimo]" id="Suelas_stock_minimo" value="1" type="number" min="0" max="1000">
				</div>
				<label for="Suelas_stock_minimo">Pares</label>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton('Aplicar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$(document).ready(function(){
		if(!$('#Suelas_stock_minimo_check').is(":checked")){
			$('#stock_minimo_panel').hide();
		}
	});

	$('.input-cantidad').change(function(){
		cantidad = $(this).attr('value');
		if(!/^([0-9]*(\.[0-9]+)?)$/.test(cantidad)){
			$(this).css({ "border": '#FF0000 3px solid'});
			return;
		}
		$(this).removeAttr('style');
	});

	$('#Suelas_stock_minimo_check').click(function(){
		$('#stock_minimo_panel').toggle(500);
	});
</script>