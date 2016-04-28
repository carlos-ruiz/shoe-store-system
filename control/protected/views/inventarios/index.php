<?php
/* @var $this InventariosController */

$this->breadcrumbs=array(
	'Inventarios',
);
?>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="col-lg-12">
				<ul id="generalTab" class="nav nav-tabs responsive">
					<li class="active">
						<a href="#materiales-tab" data-toggle="tab">Materiales</a>
					</li>
					<li>
						<a href="#insumos-tab" data-toggle="tab">Insumos</a>
					</li>
					<li>
						<a href="#terminados-tab" data-toggle="tab">Zapatos terminados</a>
					</li>
					<li>
						<a href="<?= Yii::app()->request->baseUrl ?>/inventarios/admin">Todos</a>
					</li>
				</ul>
				<div id="generalTabContent" class="tab-content responsive">
					<div id="materiales-tab" class="tab-pane fade in active">
						<?= $this->renderPartial('_inventario_materiales', array(
							'inventarioMateriales'=>$inventarioMateriales,
						)); ?>
					</div>
					<div id="insumos-tab" class="tab-pane fade">
						<?= $this->renderPartial('_inventario_insumos', array(
							'inventarioInsumos'=>$inventarioInsumos,
						)); ?>
					</div>
					<div id="terminados-tab" class="tab-pane fade">
						<?= $this->renderPartial('_inventario_terminados', array(
							'inventarioTerminados'=>$inventarioTerminados,
						)); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>