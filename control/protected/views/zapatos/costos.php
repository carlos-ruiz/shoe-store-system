<h1>Costos</h1>
<hr/>
<div class="panel panel-red">
	<div class="panel-heading">Costos por modelo</div>
	<div class="panel-body">
		<table class="table table-hover table-striped">
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