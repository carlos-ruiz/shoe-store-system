<?php

class InventariosController extends Controller
{
	public $section = 'inventarios';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'agregarMaterial', 'agregarInsumo', 'unidadMedidaMaterial', 'agregarForm'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$inventarioMateriales = InventarioMateriales::model()->findAll();
		$inventarioInsumos = InventarioInsumos::model()->findAll();
		$inventarioTerminados = InventarioZapatosTerminados::model()->findAll();
		$this->render('index', array(
			'inventarioMateriales'=>$inventarioMateriales,
			'inventarioInsumos'=>$inventarioInsumos,
			'inventarioTerminados'=>$inventarioTerminados,
		));
	}

	public function actionAdmin()
	{
		$model=new Inventarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventarios']))
			$model->attributes=$_GET['Inventarios'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionAgregarMaterial()
	{
		$model = new InventarioMateriales('agregarMaterial');
		if(isset($_POST['InventarioMateriales'])){
			$model->attributes = $_POST['InventarioMateriales'];
			$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Materiales'));
			if (isset($_POST['MaterialesColores'])) {
				foreach ($_POST['MaterialesColores']['cantidad'] as $id_color => $cantidad) {
					$inventarioMaterial = InventarioMateriales::model()->find('id_materiales=? AND id_colores=?', array($model->id_materiales, $id_color));
					if (isset($inventarioMaterial)) {
						$inventarioMaterial->existencia += $cantidad;
						$inventarioMaterial->stock_minimo = $_POST['MaterialesColores']['stock_minimo'][$id_color];
						$inventarioMaterial->ultimo_precio = $_POST['MaterialesColores']['precio'][$id_color];
						$inventarioMaterial->save();
					}else{
						$inventarioMaterial = new InventarioMateriales;
						$inventarioMaterial->existencia = $cantidad;
						$inventarioMaterial->cantidad_apartada = 0;
						$inventarioMaterial->id_materiales = $model->id_materiales;
						$inventarioMaterial->id_colores = $id_color;
						$inventarioMaterial->stock_minimo = $_POST['MaterialesColores']['stock_minimo'][$id_color];
						$inventarioMaterial->ultimo_precio = $_POST['MaterialesColores']['precio'][$id_color];
						$inventarioMaterial->save();
					}

					// Agregando en el inventario general
					$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=?', array($tipoArticulo->id, $model->id_materiales, $id_color));
					if (!isset($inventario)) {
						$inventario = new Inventarios;
						$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
						$inventario->id_articulo = $model->id_materiales;
						$inventario->id_colores = $id_color;
						$inventario->cantidad_existente = 0;
						$inventario->cantidad_apartada = 0;
						$inventario->nombre_articulo = $model->material->nombre;
						$inventario->unidad_medida = $model->material->unidad_medida;
					}
					$inventario->stock_minimo = $_POST['MaterialesColores']['stock_minimo'][$id_color];
					$inventario->ultimo_precio = $_POST['MaterialesColores']['precio'][$id_color];
					$inventario->cantidad_existente = $inventarioMaterial->existencia;
					$inventario->save();
				}
			}else{
				$model->existencia = 0; //Parche porque no se como permitir null solo en este contexto
				if($model->validate()){
					$existente = InventarioMateriales::model()->find('id_materiales=?', array($model->id_materiales));
					if (isset($existente)) {
						$existente->existencia += $model->cantidad;
						$existente->ultimo_precio = $model->ultimo_precio;
						$existente->stock_minimo = $model->stock_minimo;
						$existente->save();
						$model->existencia = $existente->existencia;
					}else{
						$model->existencia = $model->cantidad;
						$model->save();
					}
				}
				// Agregando al inventario general
				$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=?', array($tipoArticulo->id, $model->id_materiales));
				if (!isset($inventario)) {
					$inventario = new Inventarios;
					$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
					$inventario->id_articulo = $model->id_materiales;
					$inventario->nombre_articulo = $model->material->nombre;
					$inventario->unidad_medida = $model->material->unidad_medida;
				}
				$inventario->stock_minimo = $model->stock_minimo;
				$inventario->ultimo_precio = $model->ultimo_precio;
				$inventario->cantidad_existente = $model->existencia;
				$inventario->save();
			}
			$this->redirect(array('admin'));
		}
		$this->render('agregar_material', array('model'=>$model));
	}

	public function actionAgregarInsumo()
	{
		$model = new InventarioInsumos('agregarInsumo');
		if(isset($_POST['InventarioInsumos'])){
			$model->attributes = $_POST['InventarioInsumos'];
			$model->existencia = 0; //Parche porque no se como permitir null solo en este contexto
			if($model->validate()){
				$existente = InventarioInsumos::model()->find('id_insumos=?', array($model->id_insumos));
				if (isset($existente)) {
					$existente->existencia += $model->cantidad;
					$existente->save();
				}else{
					$model->existencia = $model->cantidad;
					$model->save();
				}
				$this->redirect(array('index'));
			}
		}
		$this->render('agregar_insumo', array('model'=>$model));
	}

	public function obtenerArticulo($data, $row)
	{
		$nombreArticulo = null;
		switch ($data->tipoArticulo->tipo) {
			case 'Suelas':
				$nombreArticulo = Suelas::model()->findByPk($data->id_articulo)->nombre;
				break;
			case 'Tacones':
				$nombreArticulo = Tacones::model()->findByPk($data->id_articulo)->nombre;
				break;
			case 'Ojillos':
				$nombreArticulo = Ojillos::model()->findByPk($data->id_articulo)->nombre;
				break;
			case 'Agujetas':
				$nombreArticulo = Agujetas::model()->findByPk($data->id_articulo)->nombre;
				break;
			case 'Materiales':
				$nombreArticulo = Materiales::model()->findByPk($data->id_articulo)->nombre;
				break;
		}
		return $nombreArticulo;
	}

	public function actionUnidadMedidaMaterial()
	{
		if (isset($_POST['InventarioMateriales']['id_materiales'])) {
			$id_material = $_POST['InventarioMateriales']['id_materiales'];
			$material = Materiales::model()->findByPk($id_material);
			echo $material->unidad_medida;
		}
	}

	public function actionAgregarForm()
	{
		if (isset($_POST['InventarioMateriales']['id_materiales'])) {
			$id_material = $_POST['InventarioMateriales']['id_materiales'];
			$material = Materiales::model()->findByPk($id_material);
			if (isset($material->colores) && sizeof($material->colores) > 0) {
				echo '
					<div class="panel panel-red panel-ordenes">
						<div class="panel-heading">Agregar a inventario</div>
						<div class="panel-body">
							<table class="table table-hover table-striped ordenes-pedido-table without-padding-table" id="table_configurar_numeros" summary="Tabla de configuracion de número de suela que lleva cada modelo.">
								<thead>
									<tr>
										<th>Material</th>
										<th>Color</th>
										<th>Cantidad</th>
										<th>Unidad de medida</th>
										<th>Precio</th>
										<th>Cantidad mínima en bodega</th>
									</tr>
								</thead>
								<tbody id="ordenes_table">';
								foreach ($material->colores as $materialColor) {
									$inventarioMaterial = InventarioMateriales::model()->find('id_materiales=? AND id_colores=?', array($id_material, $materialColor->id_colores));
									$stock_minimo = 0;
									$precio = 0;
									if (isset($inventarioMaterial) && sizeof($inventarioMaterial)>0) {
										$stock_minimo = $inventarioMaterial->stock_minimo;
										$precio = $inventarioMaterial->ultimo_precio;
									}
									echo '
										<tr>
											<td>'.$material->nombre.'</td>
											<td>'.$materialColor->color->color.'</td>
											<td><input type="text" name="MaterialesColores[cantidad]['.$materialColor->id_colores.']" /></td>
											<td>'.$material->unidad_medida.'</td>
											<td><input type="text" value="'.$precio.'" name="MaterialesColores[precio]['.$materialColor->id_colores.']" /></td>
											<td><input type="text" value="'.$stock_minimo.'" name="MaterialesColores[stock_minimo]['.$materialColor->id_colores.']" /></td>
										</tr>
									';
								}
				echo '
								</tbody>
							</table>
						</div>
					</div>
				';
			}
			else{ 
				echo '
				<div class="row">
					<div class="form-group col-md-4 ">
						<label class="control-label required" for="InventarioMateriales_cantidad">Cantidad <span class="required">*</span></label>				<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="InventarioMateriales[cantidad]" id="InventarioMateriales_cantidad" type="text">									</div>
					</div>
					<div class="form-group col-md-2">
						<label for="unidad_medida_label">Unidad de medida</label>
						<div class="input-group">
							<input class="form-control" type="text" value="'.$material->unidad_medida.'" id="unidad_medida_label" disabled="disabled">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label class="control-label" for="InventarioMateriales_ultimo_precio">Último precio</label>			
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="InventarioMateriales[ultimo_precio]" id="InventarioMateriales_ultimo_precio" type="text">
						</div>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="InventarioMateriales_stock_minimo">Cantidad mínima en bodega</label>			
						<div class="input-group">
							<input size="45" maxlength="45" class="form-control" name="InventarioMateriales[stock_minimo]" id="InventarioMateriales_stock_minimo" type="text">
						</div>
					</div>
				</div>
				';
			}
		}
	}
}