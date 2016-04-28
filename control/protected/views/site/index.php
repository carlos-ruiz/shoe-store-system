<?php
if(Yii::app()->user->isGuest){
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'htmlOptions'=>array('class' => 'login-form'),
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	));
?>


		<h3 class="form-title" style="color:#1e90ff !important;">Iniciar sesión</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Introduce usuario y contraseña </span>
		</div>


		<div class="form-group ">
			<?php echo $form->labelEx($model,'usuario', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
			<?php echo $form->textField($model,'usuario',array('size'=>60,'maxlength'=>200, 'class'=>'form-control form-control-solid placeholder-no-fix', 'placeholder'=>'Usuario')); ?>
			<?php echo $form->error($model,'usuario', array('class'=>'help-block')); ?>
		</div>

		<div class="form-group ">
			<?php echo $form->labelEx($model,'contrasenia', array('class'=>'control-label visible-ie8 visible-ie9')); ?>
			<?php echo $form->passwordField($model,'contrasenia',array('class'=>'form-control form-control-solid placeholder-no-fix', 'type'=>'password', 'placeholder'=>'Contraseña')); ?>
			<?php echo $form->error($model,'contrasenia', array('class'=>'help-block')); ?>

		</div>

		<div class="form-actions" style="color:black !important;">
		<?php echo CHtml::submitButton('Entrar',array('class'=>'btn blue-stripe uppercase')); ?>
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe',array('class'=>'rememberme check', 'style'=>'color: black !important;')); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>

<?php $this->endWidget();

}
else{
	$mesActual = date('m');
	$anioActual = date('Y');
	$fechaInicial = date('Y-m-d H:i:s', mktime(0, 0, 0, $mesActual, 1,   $anioActual));
	$fechaFinal = date('Y-m-d H:i:s', mktime(23, 59, 59, $mesActual+1, 0, $anioActual));
	$pedidosDelMes = Pedidos::model()->findAll('fecha_pedido BETWEEN ? AND ?', array($fechaInicial, $fechaFinal));
	$pedidosDelMes = Pedidos::model()->findAll('fecha_pedido BETWEEN ? AND ?', array($fechaInicial, $fechaFinal));
	$ventasDelMes = 0;
	$porCobrar = 0;
	foreach ($pedidosDelMes as $pedido) {
		$ventasDelMes += $pedido->total;
		$porCobrar += $pedido->total;
		foreach ($pedido->pagos as $pago) {
			$porCobrar -= $pago->importe;
		}
	}

?>
<div id="tab-general">
    <div id="sum_box" class="row mbl">
        <div class="col-sm-6 col-md-4">
            <div class="panel profit db mbm">
                <div class="panel-body">
                    <p class="icon">
                        <i class="icon fa fa-shopping-cart"></i>
                    </p>
                    <h4 class="value">
                        <span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0"><?= number_format($ventasDelMes, 2) ?></span><span>$</span></h4>
                    <p class="description">
                        Ventas del mes</p>
                    <div class="progress progress-sm mbn">
                        <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;" class="progress-bar progress-bar-success">
                            <span class="sr-only">80% Complete (success)</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel income db mbm">
                <div class="panel-body">
                    <p class="icon">
                        <i class="icon fa fa-money"></i>
                    </p>
                    <h4 class="value">
                        <span><?= number_format($porCobrar, 2) ?></span><span>$</span></h4>
                    <p class="description">
                        Por cobrar</p>
                    <div class="progress progress-sm mbn">
                        <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;" class="progress-bar progress-bar-info">
                            <span class="sr-only">60% Complete (success)</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="panel task db mbm">
                <div class="panel-body">
                    <p class="icon">
                        <i class="icon fa fa-signal"></i>
                    </p>
                    <h4 class="value">
                        <span><?= sizeof($pedidosDelMes) ?></span></h4>
                    <p class="description">
                        Pedidos del mes</p>
                    <div class="progress progress-sm mbn">
                        <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;" class="progress-bar progress-bar-danger">
                            <span class="sr-only">50% Complete (success)</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
