<?php
/* @var $this ModelosController */
/* @var $model Modelos */
/* @var $form CActiveForm */
?>

<div class="form">
	<?php if(isset($mensaje_error)){ ?>
		<div class="alert alert-danger alert-dismissable">
		    <button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
		    <strong>Error!</strong> <?= $mensaje_error ?>
		</div>
	<?php } ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'modelos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	
	<div class="form-body">
		<hr/>
		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($model,'nombre')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'nombre', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'nombre', array('class'=>'help-block')); ?>
				</div>
			</div>

			<div class="form-group col-md-4 <?php if($form->error($model,'imagen')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'imagen', array('class'=>'control-label')); ?>
				<?php echo $form->fileField($model, 'imagen', array('class'=>'form-control')) ?>
				<?php echo $form->error($model,'imagen', array('class'=>'help-block')); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Suelas</h4>
				<hr/>
				<?php
					$suelasSeleccionadas = array();
					foreach ($model->modelosSuelas as $modeloSuela) {
					 	array_push($suelasSeleccionadas, $modeloSuela->suela);
					} 
				?>
				<?php foreach ($suelas as $suela) { ?>
				<div class="form-group col-md-6">
					<label for="ModelosSuelas_id_suelas_<?= $suela->id ?>"><?= $suela->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosSuelas[id_suelas][<?= $suela->id; ?>]" id="ModelosSuelas_id_suelas_<?= $suela->id ?>" value="1" type="checkbox" <?php if(in_array($suela, $suelasSeleccionadas)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Colores</h4>
				<hr/>
				<?php 
					$coloresSeleccionados = array();
					foreach ($model->modelosColores as $modeloColor) {
						array_push($coloresSeleccionados, $modeloColor->color);
					}
				?>
				<?php foreach ($colores as $color) { ?>
				<div class="form-group col-md-6">
					<label for="ModelosColores_id_colores_<?= $color->id ?>"><?= $color->color; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosColores[id_colores][<?= $color->id; ?>]" id="ModelosColores_id_colores_<?= $color->id ?>" value="1" type="checkbox" <?php if(in_array($color, $coloresSeleccionados)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Números</h4>
				<hr/>
				<?php
					$numerosSeleccionados = array();
					foreach ($model->modelosNumeros as $modeloNumero) {
						array_push($numerosSeleccionados, $modeloNumero->numero);
					}
				?>
				<?php for ($i=12; $i < 32 ; $i = $i + 0.5) { ?>
				<div class="form-group col-md-4 align-right">
					<label for="ModelosNumeros_numero_<?= $i; ?>"><?= $i; ?></label>
					<div class="input-group inline-block">
						<input name="ModelosNumeros[numero][<?= $i; ?>]" id="ModelosNumeros_numero_<?= $i; ?>" value="1" type="checkbox" <?php if(in_array($i, $numerosSeleccionados)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Materiales</h4>
				<hr/>
				<?php
					$materialesSeleccionados = array();
					$cantidadesMaterial = array();
					$unidadesMedidaMaterial = array();

					foreach ($model->modelosMateriales as $modeloMaterial) {
						array_push($materialesSeleccionados, $modeloMaterial->material);
						$cantidadesMaterial[$modeloMaterial->material->id] = array('extrachico'=>$modeloMaterial->cantidad_extrachico, 'chico'=>$modeloMaterial->cantidad_chico, 'mediano'=>$modeloMaterial->cantidad_mediano, 'grande'=>$modeloMaterial->cantidad_grande);
						$unidadesMedidaMaterial[$modeloMaterial->material->id] = $modeloMaterial->unidad_medida;
					}
				?>
				<?php foreach ($materiales as $material) { ?>
				<div class="form-group">
					<label for="ModelosMateriales_id_materiales_<?= $material->id ?>"><?= $material->nombre.' ('.$material->unidad_medida.')' ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosMateriales[id_materiales][<?= $material->id; ?>]" id="ModelosMateriales_id_materiales_<?= $material->id ?>" value="1" type="checkbox" class="check_material" data-id="<?= $material->id; ?>" <?php if(in_array($material, $materialesSeleccionados)){echo "checked";} ?>>
					</div>
					<div id="inputs_<?= $material->id; ?>" style="display:none;">
							<h5>Cantidades</h5>
						<div class="col-md-6">
							<label for="ModelosMateriales_cantidad_extrachico_<?= $material->id ?>">Extrachico</label>
							<input name="ModelosMateriales[cantidades][<?= $material->id; ?>][cantidad_extrachico]" class="form-control" id="ModelosMateriales_cantidad_extrachico_<?= $material->id ?>" type="text" <?php if(isset($cantidadesMaterial[$material->id]['extrachico'])){echo "value='".$cantidadesMaterial[$material->id]['extrachico']."'"; } ?>>
						</div>
						<div class="col-md-6">
							<label for="ModelosMateriales_cantidad_chico_<?= $material->id ?>">Chico</label>
							<input name="ModelosMateriales[cantidades][<?= $material->id; ?>][cantidad_chico]" class="form-control" id="ModelosMateriales_cantidad_chico_<?= $material->id ?>" type="text" <?php if(isset($cantidadesMaterial[$material->id]['chico'])){echo "value='".$cantidadesMaterial[$material->id]['chico']."'"; } ?>>
						</div>
						<div class="col-md-6">
							<label for="ModelosMateriales_cantidad_mediano_<?= $material->id ?>">Mediano</label>
							<input name="ModelosMateriales[cantidades][<?= $material->id; ?>][cantidad_mediano]" class="form-control" id="ModelosMateriales_cantidad_mediano_<?= $material->id ?>" type="text" <?php if(isset($cantidadesMaterial[$material->id]['mediano'])){echo "value='".$cantidadesMaterial[$material->id]['mediano']."'"; } ?>>
						</div>
						<div class="col-md-6">
							<label for="ModelosMateriales_cantidad_grande_<?= $material->id ?>">Grande</label>
							<input name="ModelosMateriales[cantidades][<?= $material->id; ?>][cantidad_grande]" class="form-control" id="ModelosMateriales_cantidad_grande_<?= $material->id ?>" type="text" <?php if(isset($cantidadesMaterial[$material->id]['grande'])){echo "value='".$cantidadesMaterial[$material->id]['grande']."'"; } ?>>
						</div>
					</div>
					<script type="text/javascript">
						check = $('#ModelosMateriales_id_materiales_' + <?= $material->id ?>).is(":checked");
						if (check) {
							$("#inputs_"+<?= $material->id; ?>).show();
						}else{
							$("#inputs_"+<?= $material->id; ?>).hide();
						}
					</script>
				</div>
				<?php } ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$(document).ready(function(){

	});

	$('.check_material').click(function(){
		$('#inputs_'+$(this).data('id')).toggle(500);
	});
</script>