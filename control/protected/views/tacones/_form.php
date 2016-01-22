<?php
/* @var $this TaconesController */
/* @var $model Tacones */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tacones-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
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
			<div class="col-md-4">
				<h4>Colores</h4>
				<hr/>
				<?php 
					$coloresSeleccionados = array();
					foreach ($model->taconesColores as $taconColor) {
						array_push($coloresSeleccionados, $taconColor->color);
					}
				?>
				<?php foreach ($colores as $color) { ?>
				<div class="form-group col-md-6">
					<label for="TaconesColores_id_colores_<?= $color->id ?>"><?= $color->color; ?></label>
					<div class="input-group inline-block">
						<input size="45" maxlength="45" name="TaconesColores[id_colores][<?= $color->id; ?>]" id="TaconesColores_id_colores_<?= $color->id ?>" value="1" type="checkbox" <?php if(in_array($color, $coloresSeleccionados)){echo "checked";} ?>>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-4">
				<h4>Números</h4>
				<hr/>
				<?php
					$numerosSeleccionados = array();
					foreach ($model->taconesNumeros as $taconNumero) {
						array_push($numerosSeleccionados, $taconNumero->numero);
					}
				?>
				<?php for ($i=12; $i < 32 ; $i++) { ?>
				<div class="form-group col-md-4 align-right">
					<label for="TaconesNumeros_numero_<?= $i; ?>"><?= $i; ?></label>
					<div class="input-group inline-block">
						<input name="TaconesNumeros[numero][<?= $i; ?>]" id="TaconesNumeros_numero_<?= $i; ?>" value="1" type="checkbox" <?php if(in_array($i, $numerosSeleccionados)){echo "checked";} ?>>
					</div>
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