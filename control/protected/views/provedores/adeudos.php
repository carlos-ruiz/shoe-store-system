<h1>Adeudos con proveedores</h1>

<div class="text-right">
	<?php echo CHtml::link('<i class="fa fa-usd"></i> Reportar pago', array('provedores/pagar'), array('class'=>'btn btn-red-stripped')); ?>
</div>
<br/>
<?php 
	if(isset($deudasPorProveedor) && sizeof($deudasPorProveedor) > 0){ ?>
	<div class="panel panel-red panel-ordenes">
				<div class="panel-heading">Adeudos</div>
				<div class="panel-body">
		<table class="table table-hover table-striped">
			<tbody>
			<tr>
				<th>Proveedor</th>
				<th>Monto de la deuda ($)</th>
			</tr>
<?php
			foreach ($deudasPorProveedor as $nombre => $cantidad) { ?>
				<tr><td><?= $nombre ?></td><td><?= number_format($cantidad, 2) ?></td></tr>
<?php	
		} ?>
			</tbody>
		</table>
		</div>
		</div>
<?php	
	}
	else{
		echo "<p>Sin adeudos que mostrar</p>";
	}
?>