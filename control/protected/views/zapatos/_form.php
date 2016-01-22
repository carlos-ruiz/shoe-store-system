<?php
/* @var $this ZapatosController */
/* @var $model Zapatos */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'zapatos-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<hr/>
		<div class="row">
			<div class="form-group col-md-4 <?php if($form->error($zapatoPrecios,'id_modelos')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'id_modelos', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptions = array(
							"class" => "form-control",
							"empty"=>"Seleccione una opci&oacute;n",
						);
					?>
					<?php echo $form->dropDownList($zapatoPrecios,'id_modelos',Modelos::model()->obtenerModelos(), $htmlOptions); ?>
					<?php echo $form->error($zapatoPrecios,'id_modelos', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($zapatoPrecios,'id_suelas')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'id_suelas', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($zapatoPrecios,'id_suelas',Modelos::model()->obtenerSuelas(isset($zapatoPrecios->id_modelos)?$zapatoPrecios->id_modelos:0), $htmlOptions); ?>
					<?php echo $form->error($zapatoPrecios,'id_suelas', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3 <?php if($form->error($zapatoPrecios,'precio_extrachico')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'precio_extrachico', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($zapatoPrecios,'precio_extrachico',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($zapatoPrecios,'precio_extrachico', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($zapatoPrecios,'precio_chico')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'precio_chico', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($zapatoPrecios,'precio_chico',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($zapatoPrecios,'precio_chico', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($zapatoPrecios,'precio_mediano')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'precio_mediano', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($zapatoPrecios,'precio_mediano',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($zapatoPrecios,'precio_mediano', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-3 <?php if($form->error($zapatoPrecios,'precio_grande')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($zapatoPrecios,'precio_grande', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->textField($zapatoPrecios,'precio_grande',array('size'=>60,'maxlength'=>128, 'class'=>'form-control')); ?>
					<?php echo $form->error($zapatoPrecios,'precio_grande', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo CHtml::submitButton('Guardar', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	jQuery(function($) {
		jQuery('body').on('change','#ZapatoPrecios_id_modelos',function(){
			jQuery.ajax({'url':'/controlbom/control/zapatos/suelasPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#ZapatoPrecios_id_suelas").html(html)}});
			return false;
		});
	});
</script>