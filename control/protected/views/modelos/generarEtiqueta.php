<?php
/* @var $this ModelosController */
/* @var $model Modelos */
/* @var $form CActiveForm */
?>
<h1>Generar etiqueta de modelos</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'etiquetas-form',
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
			<div class="form-group col-md-4 <?php if($form->error($model,'id')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php
						$htmlOptions = array(
							"class" => "form-control",
							"empty"=>"Seleccione una opci&oacute;n",
						);
					?>
					<?php echo $form->dropDownList($model,'id',$model->obtenerModelos(), $htmlOptions); ?>
					<?php echo $form->error($model,'id', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'id_colores')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'id_colores', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'id_colores',$model->obtenerColores(isset($model->id)?$model->id:0), $htmlOptions); ?>
					<?php echo $form->error($model,'id_colores', array('class'=>'help-block')); ?>
				</div>
			</div>
			<div class="form-group col-md-4 <?php if($form->error($model,'numero')!=''){ echo 'has-error'; }?>">
				<?php echo $form->labelEx($model,'numero', array('class'=>'control-label')); ?>
				<div class="input-group">
					<?php echo $form->dropDownList($model,'numero',$model->obtenerNumeros(isset($model->id)?$model->id:0), $htmlOptions); ?>
					<?php echo $form->error($model,'numero', array('class'=>'help-block')); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::submitButton('Imprimir etiqueta', array('class'=>'btn btn-red-stripped')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	jQuery(function($) {
		jQuery('body').on('change','#Modelos_id',function(){
			jQuery.ajax({'url':'../../modelos/coloresPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Modelos_id_colores").html(html)}});
			jQuery.ajax({'url':'../../modelos/numerosPorModelo','type':'POST','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#Modelos_numero").html(html)}});
			return false;
		});
	});
</script>
