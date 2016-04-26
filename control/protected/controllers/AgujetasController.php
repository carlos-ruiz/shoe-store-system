<?php

class AgujetasController extends Controller
{
	public $section = 'materiaPrima';
	public $subsection = 'agujetas';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete', 'agregarInventario'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Agujetas;
		$colores = Colores::model()->findAll();
		$mensaje_error = null;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agujetas']))
		{
			$coloresSeleccionados = array();
			if (isset($_POST['AgujetasColores'])) {
				if(isset($_POST['AgujetasColores']['id_colores'])){
					$coloresSeleccionados = $_POST['AgujetasColores']['id_colores'];
				}
			}

			$model->attributes=$_POST['Agujetas'];
			if (sizeof($coloresSeleccionados)>0 & $model->validate()) {
				if($model->save()){
					foreach ($coloresSeleccionados as $id_color => $value) {
						$agujetaColor = new AgujetasColores;
						$agujetaColor->id_colores = $id_color;
						$agujetaColor->id_agujetas = $model->id;
						$agujetaColor->save();
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else{
				if(sizeof($coloresSeleccionados)<1){
					$mensaje_error = 'Debe seleccionar al menos un color';
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores,
			'mensaje_error'=>$mensaje_error,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$colores = Colores::model()->findAll();
		$mensaje_error = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agujetas']))
		{
			$model->attributes=$_POST['Agujetas'];
			$coloresSeleccionados = array();
			if (isset($_POST['AgujetasColores'])) {
				if(isset($_POST['AgujetasColores']['id_colores'])){
					$coloresSeleccionados = $_POST['AgujetasColores']['id_colores'];
				}
			}
			if (sizeof($coloresSeleccionados)>0 & $model->validate()) {
				$id_colores_seleccionados = array();
				foreach ($coloresSeleccionados as $id_color => $value) {
					array_push($id_colores_seleccionados, $id_color);
				}
				foreach ($model->agujetasColores as $agujetaColor) {
					if(!in_array($agujetaColor->color->id, $id_colores_seleccionados)){
						$agujetaColor->delete();
					}
					else{
						$id_colores_seleccionados = array_diff($id_colores_seleccionados, array($agujetaColor->color->id));
					}
				}
				if($model->save()){
					foreach ($id_colores_seleccionados as $id_color) {
						$agujetaColor = new AgujetasColores;
						$agujetaColor->id_colores = $id_color;
						$agujetaColor->id_agujetas = $model->id;
						$agujetaColor->save();
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else{
				if(sizeof($coloresSeleccionados)<1){
					$mensaje_error = 'Debe seleccionar al menos un color';
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'colores'=>$colores,
			'mensaje_error'=>$mensaje_error,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Agujetas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Agujetas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Agujetas']))
			$model->attributes=$_GET['Agujetas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Agujetas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Agujetas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Agujetas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='agujetas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAgregarInventario()
	{
		$agujetas = Agujetas::model()->findAll();
		$ojillos = Ojillos::model()->findAll();

		if (isset($_POST['Inventario'])) {
			if(isset($_POST['Inventario']['agujeta'])){
				$tipoArticulo = TiposArticulosInventario::model()->find('tipo="Agujetas"');
				foreach ($_POST['Inventario']['agujeta'] as $clave => $datos) {
					if($datos['cantidad'] >= 0){
						$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=?', array($tipoArticulo->id, $datos['id'], $datos['id_color']));
						if (!isset($inventario)) {
							$inventario = new Inventarios;
							$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
							$inventario->id_articulo = $datos['id'];
							$inventario->nombre_articulo = $datos['nombre'];
							$inventario->id_colores = $datos['id_color'];
							$inventario->cantidad_existente = 0;
							$inventario->cantidad_apartada = 0;
							$inventario->unidad_medida = 'Piezas';
						}
						$inventario->ultimo_precio = $datos['precio'];
						$inventario->stock_minimo = $datos['stock'];
						$inventario->cantidad_existente += $datos['cantidad'];
						$inventario->save();
					}
				}
			}
			if(isset($_POST['Inventario']['ojillo'])){
				$tipoArticulo = TiposArticulosInventario::model()->find('tipo="Ojillos"');
				foreach ($_POST['Inventario']['ojillo'] as $clave => $datos) {
					if($datos['cantidad'] >= 0){
						$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=?', array($tipoArticulo->id, $datos['id'], $datos['id_color']));
						if (!isset($inventario)) {
							$inventario = new Inventarios;
							$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
							$inventario->id_articulo = $datos['id'];
							$inventario->nombre_articulo = $datos['nombre'];
							$inventario->id_colores = $datos['id_color'];
							$inventario->cantidad_existente = 0;
							$inventario->cantidad_apartada = 0;
							$inventario->unidad_medida = 'Piezas';
						}
						$inventario->ultimo_precio = $datos['precio'];
						$inventario->stock_minimo = $datos['stock'];
						$inventario->cantidad_existente += $datos['cantidad'];
						$inventario->save();
					}
				}
			}
			$this->redirect(array('inventarios/admin'));
		}

		$this->render('add_stock_agujetas_ojillos', 
			array(
				'agujetas' => $agujetas,
				'ojillos' => $ojillos,
			)
		);
	}
}
