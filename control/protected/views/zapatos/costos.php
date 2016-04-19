<h1>Costos</h1>
<hr/>
<div class="search">
	<div class="form-group">
		<div class="input-group">
			<input id="search_input" class="form-control" type="text" value="" placeholder="Buscar..." />
		</div>
	</div>
</div>
<div class="panel panel-red">
	<div class="panel-heading">Costos por modelo</div>
	<div class="panel-body">
		<table id="table_costos" class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Modelo</th>
					<th>Suela</th>
					<th>Extrachico</th>
					<th>Chico</th>
					<th>Mediano</th>
					<th>Grande</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($zapatosDiferentes as $zapato) { ?>
				<tr>
					<td><?= $zapato['modelo'] ?></td>
					<td><?= $zapato['suela'] ?></td>
					<td><?= '$'.number_format($zapato['extrachico'], 2) ?></td>
					<td><?= '$'.number_format($zapato['chico'], 2) ?></td>
					<td><?= '$'.number_format($zapato['mediano'], 2) ?></td>
					<td><?= '$'.number_format($zapato['grande'], 2) ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$('#search_input').change(function (){
		var textSearch = accentFold($("#search_input").val()).toLowerCase();
		if(textSearch.length>0){
			$('#table_costos tbody tr').each(function(){
				var textoProducto = accentFold($(this).text()).toLowerCase();
				if(textoProducto.indexOf(textSearch)<0){
					$(this).hide(500);
				}else{
					$(this).show(500);
				}
			});
		}else{
			$("#table_costos tbody tr").show(500);
		}
	});
</script>