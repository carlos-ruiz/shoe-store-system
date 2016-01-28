<?php
/* @var $this MaterialesController */
/* @var $model Materiales */
/* @var $form CActiveForm */
?>
<h1>Agregar material</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agregar-materiales-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="form-group <?php if($form->error($model,'id_materiales')!=''){ echo 'has-error'; }?>">
			<?php echo $form->labelEx($model,'id_materiales', array('class'=>'control-label')); ?>
			<div class="input-group">
				<?php 
					$htmlOptions = array(
						"ajax"=>array(
							"url"=>$this->createUrl("inventarios/agregarForm"),
							// "url"=>$this->createUrl("inventarios/unidadMedidaMaterial"),
                            // $('#unidad_medida_label').attr('value',data);
							"type"=>"POST",
							"update"=>"#form_container"
							// "success"=>"function(data)
       //                      {
       //                      	$('#form_container').attr('value',data);
       //                      }"
						),
						"class" => "form-control",
						"empty"=>"Seleccione una opci&oacute;n",
					);
				?>
				<?php echo $form->dropDownList($model,'id_materiales', $model->obtenerMateriales(), $htmlOptions); ?>
				<?php echo $form->error($model,'id_materiales', array('class'=>'help-block')); ?>
			</div>
		</div>
		<div id="form_container">
			
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton('Agregar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->