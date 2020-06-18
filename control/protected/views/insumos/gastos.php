<h1>Gastos operativos</h1>
<hr/>
<div class="text-right">
	<a href="javascript:void(0);" class="btn btn-red-stripped" id="agregar_gasto"><i class="fa fa-plus"></i> Agregar</a>
	<br/>
	<br/>
</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tacones-add-stock-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-body">
		<div class="row">
			<div class="panel panel-red panel-ordenes">
				<div class="panel-heading">Gastos</div>
				<div class="panel-body">
					<table class="table table-striped" summary="Muestra los gastos que generan mes con mes">
						<thead>
							<tr>
								<th>Concepto</th>
								<th>Costo</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="body_table">
							<?php foreach ($gastos as $gasto) { ?>
								<tr>
									<td>
										<input class="form-control" type="text" name="GastosOperativos[existentes][<?= $gasto->id ?>][concepto]" value="<?= $gasto->concepto ?>" required />
									</td>
									<td>
										<input class="form-control input-costo" type='number' min='0' step='0.50' name="GastosOperativos[existentes][<?= $gasto->id ?>][costo]" value="<?= $gasto->costo ?>" required />
									</td>
									<td>
										<a class="delete" title="Borrar" href="javascript:void(0);"><img src="../../images/icons/delete.png" alt="Borrar"></a>
									</td>
								</tr>
							<?php }	?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<div class="col-md-6">Total gastos</div>
				<div class="col-md-6">
					<input id="total_gasto" class="form-control" type="text" value="" disabled="disabled" />
				</div>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<div class="col-md-6">Total pares</div>
				<div class="col-md-6">
					<input id="total_pares" class="form-control" type="number" step="1" min="1" name="TotalPares[mes]" value="<?= $total_pares ?>" required />
				</div>
			</div>
		</div>
		<br/>		
		<div class="row">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<div class="col-md-6">Gasto por par</div>
				<div class="col-md-6">
					<input id="gasto_par" name="TotalPares[gasto_par]" class="form-control" type="text" value="" readonly />
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
	if ($('#total_pares').val()==='') {
		$('#total_pares').val(1);
	}
	calcularCosto();

	$('#agregar_gasto').click(function(){
		var rows = $('#body_table tr').length;
		tr = "<tr>";
		tr += "<td><input class='form-control' type='text' name=\"GastosOperativos[nuevo]["+rows+"][concepto]\" value='' required/></td>";
		tr += "<td><input class='form-control input-costo' type='number' min='0' step='0.50' name=\"GastosOperativos[nuevo]["+rows+"][costo]\" value='' required /></td>";
		tr += "<td><a class='delete' title='Borrar' href='javascript:void(0);'><img src='../../images/icons/delete.png' alt='Borrar'></a></td>";
		tr += "</tr>";
		$('#body_table').append(tr);
	});

	jQuery('body').on('change','.input-costo',function(){
		calcularCosto();
		return false;
	});

	jQuery('body').on('click','.delete',function(){
		$(this).parent().parent().remove();
		calcularCosto();
	});

	$('#total_pares').change(function(){
		calcularCostoPorPar();
	});

	function calcularCosto(){
		var total_gastos = 0;
		$('#body_table tr input.input-costo').each(function(){
			if ($(this).val() !== '') {
				total_gastos += parseFloat($(this).val());
			}
		});
		$('#total_gasto').val(total_gastos.toFixed(2));
		calcularCostoPorPar();
	}

	function calcularCostoPorPar(){
		total_gastos = $('#total_gasto').val();
		total_pares = $('#total_pares').val();
		if (total_pares <= 0) {
			$('#gasto_par').val('Incalculable');
			return;
		}
		costoPar = total_gastos/total_pares;
		$('#gasto_par').val(costoPar.toFixed(2));
	}

</script>
