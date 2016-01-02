<?php
/* @var $this ModelosController */
/* @var $model Modelos */
/* @var $form CActiveForm */
?>

<div class="form">

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

			<!-- <div class="form-group col-md-4 <?php if($form->error($model,'imagen')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'imagen', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($model,'imagen',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'imagen', array('class'=>'help-block')); ?>
				</div>
			</div> -->

			<div class="form-group">
				<?php echo $form->labelEx($model,'imagen'); ?>
				<?php echo $form->fileField($model, 'imagen') ?>
				<?php echo $form->error($model,'imagen'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<h4>Suelas</h4>
				<hr/>
				<?php foreach ($suelas as $suela) { ?>
				<div class="form-group col-md-6">
					<label for="ModelosSuelas_id_suelas_<?= $suela->id ?>"><?= $suela->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosSuelas[id_suelas][<?= $suela->id; ?>]" id="ModelosSuelas_id_suelas_<?= $suela->id ?>" value="1" type="checkbox">
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Colores</h4>
				<hr/>
				<?php foreach ($colores as $color) { ?>
				<div class="form-group col-md-6">
					<label for="ModelosColores_id_colores_<?= $color->id ?>"><?= $color->color; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosColores[id_colores][<?= $color->id; ?>]" id="ModelosColores_id_colores_<?= $color->id ?>" value="1" type="checkbox">
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Números</h4>
				<hr/>
				<?php for ($i=15; $i < 32 ; $i++) { ?>
				<div class="form-group col-md-3">
					<label for="ModelosNumeros_numero_<?= $i; ?>"><?= $i; ?></label>
					<div class="input-group inline-block">
						<input name="ModelosNumeros[numero][<?= $i; ?>]" id="ModelosNumeros_numero_<?= $i; ?>" value="1" type="checkbox">
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-3">
				<h4>Materiales</h4>
				<hr/>
				<?php foreach ($materiales as $material) { ?>
				<div class="form-group">
					<label for="ModelosMateriales_id_materiales_<?= $material->id ?>"><?= $material->nombre; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="ModelosMateriales[id_materiales][<?= $material->id; ?>]" id="ModelosMateriales_id_materiales_<?= $material->id ?>" value="1" type="checkbox" class="check_material" data-id="<?= $material->id; ?>">
					</div>
					<div id="inputs_<?= $material->id; ?>" style="display:none;">
						<div class="col-md-6">
							<label for="ModelosMateriales_cantidad_<?= $material->id ?>">Cantidad</label>
							<input name="ModelosMateriales[cantidad][<?= $material->id; ?>]" class="form-control" id="ModelosMateriales_cantidad_<?= $material->id ?>" type="text">
						</div>
						<div class="col-md-6">
							<label for="ModelosMateriales_unidad_medida_<?= $material->id ?>">Unidad/medida</label>
							<input name="ModelosMateriales[unidad_medida][<?= $material->id; ?>]" class="form-control" id="ModelosMateriales_unidad_medida_<?= $material->id ?>" type="text" value="">
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