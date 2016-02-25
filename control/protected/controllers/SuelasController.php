<?php

class SuelasController extends Controller
{
	public $section = 'materiaPrima';
	public $subsection = 'suelas';
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'agregarInventario', 'definirPrecios', 'actualizarPrecios'),
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
		$model=new Suelas;
		$colores = Colores::model()->findAll();
		$mensaje_error = null;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Suelas']))
		{
			$model->attributes=$_POST['Suelas'];
			$todo_bien = true;
			if (!isset($_POST['SuelasColores']['id_colores'])) {
				$todo_bien = false;
				$mensaje_error = '<br/> - Debe elegir al menos un color de suela.';
			}
			if (!isset($_POST['SuelasNumeros']['numero'])) {
				$todo_bien = false;
				$mensaje_error .= '<br/> - Debe elegir al menos un número de suela.';
			}
			if($todo_bien && $model->save()){
				foreach ($_POST['SuelasColores']['id_colores'] as $id => $value) {
					$suelaColor = new SuelasColores;
					$suelaColor->id_suelas = $model->id;
					$suelaColor->id_colores = $id;
					$suelaColor->save();
				}
				foreach ($_POST['SuelasNumeros']['numero'] as $numero => $value) {
					$suelaNumero = new SuelasNumeros;
					$suelaNumero->numero = $numero;
					$suelaNumero->id_suelas = $model->id;
					$suelaNumero->save();
				}
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Suelas']))
		{
			$todo_bien = true;
			$model->attributes=$_POST['Suelas'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$ids_colores_actuales = array();
				if (isset($_POST['SuelasColores']['id_colores'])) {
					foreach ($_POST['SuelasColores']['id_colores'] as $id => $value) {
						array_push($ids_colores_actuales, $id);
					}
				}
				if (sizeof($ids_colores_actuales)<1) {
					$todo_bien = false;
					$mensaje_error = '<br/> - Dede elegir al menos un color de suela.';
				}
				$numeros_actuales = array();
				if (isset($_POST['SuelasNumeros']['numero'])) {
					foreach ($_POST['SuelasNumeros']['numero'] as $numero => $value) {
						array_push($numeros_actuales, $numero);
					}
				}
				if (sizeof($numeros_actuales)<1) {
					$todo_bien = false;
					$mensaje_error .= '<br/> - Dede elegir al menos un número de suela.';
				}
				if($todo_bien){
					foreach ($model->suelasColores as $suelaColor) {
						if(!in_array($suelaColor->color->id, $ids_colores_actuales)){
							$suelaColor->delete();
						}else{
							$ids_colores_actuales = array_diff($ids_colores_actuales, array($suelaColor->color->id));
						}
					}
					foreach ($model->suelaNumeros as $suelaNumero) {
						if(!in_array($suelaNumero->numero, $numeros_actuales)){
							$suelaNumero->delete();
						}
						else{
							$numeros_actuales = array_diff($numeros_actuales, array($suelaNumero->numero));
						}
					}
					if($model->save()){
						foreach ($ids_colores_actuales as $id) {
							$suelaColor = new SuelasColores;
							$suelaColor->id_suelas = $model->id;
							$suelaColor->id_colores = $id;
							$suelaColor->save();
						}
						foreach ($numeros_actuales as $numero) {
							$suelaNumero = new SuelasNumeros;
							$suelaNumero->numero = $numero;
							$suelaNumero->id_suelas = $model->id;
							$suelaNumero->save();
						}
						$transaction->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}catch(Exception $ex){
				$transaction->rollback();
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
		$dataProvider=new CActiveDataProvider('Suelas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Suelas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Suelas']))
			$model->attributes=$_GET['Suelas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Suelas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Suelas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Suelas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='suelas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAgregarInventario()
	{
		$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?',array('Suelas'));
		$suelas = Suelas::model()->findAll();

		if (isset($_POST['Inventario'])) {
			if (isset($_POST['Suelas']['stock_minimo_general'])) {
				$stock_minimo_suelas = $_POST['Suelas']['stock_minimo'];
			}

			if (isset($_POST['Inventario']['suelacolor'])) {
				$suelasColores = $_POST['Inventario']['suelacolor'];
				foreach ($suelasColores as $clave => $id_suela_color) {
					$suelaColor = SuelasColores::model()->findByPk($id_suela_color);
					if (isset($_POST['Inventario']['numeros'][$clave])) {
						$numeros = $_POST['Inventario']['numeros'][$clave];
						foreach ($numeros as $numero => $cantidad) {
							if($cantidad != 0){
								$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=? AND numero=?', array($tipoArticulo->id, $suelaColor->id_suelas, $suelaColor->id_colores, $numero));
								if (!isset($inventario)) {
									$inventario = new Inventarios;
									$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
									$inventario->id_articulo = $suelaColor->id_suelas;
									$inventario->nombre_articulo = $suelaColor->suela->nombre;
									$inventario->id_colores = $suelaColor->id_colores;
									$inventario->numero = $numero;
									$inventario->cantidad_existente = 0;
									$inventario->cantidad_apartada = 0;
									$inventario->unidad_medida = 'Pares';
									$inventario->ultimo_precio = 0;
								}
								if (isset($stock_minimo_suelas)) {
									$inventario->stock_minimo = $stock_minimo_suelas;
								}
								$inventario->cantidad_existente += $cantidad;
								$inventario->save();
							}
						}
					}
				}
				$this->redirect(array('inventarios/admin'));
			}
		}
		$this->render('add_stock',array(
			'suelas'=>$suelas,
		));
	}

	public function actionDefinirPrecios()
	{
		$model=new SuelasColores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SuelasColores'])){
			$model->attributes=$_GET['SuelasColores'];
		}

		$this->render('set_prices', array(
			'model'=>$model,
		));
	}

	public function actionActualizarPrecios()
	{
		$id = $_POST["id"];
		$precio = $_POST["precio"];
		$tipo_precio = $_POST['tipo_precio'];

		$suelaColor = SuelasColores::model()->findByPk($id);
		$suela = Suelas::model()->findByPk($suelaColor->id_suelas);
		$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Suelas'));

		foreach ($suela->suelaNumeros as $suelaNumero) {
			$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=? AND numero=?', array($tipoArticulo->id, $suela->id, $suelaColor->id_colores, $suelaNumero->numero));
			if (!isset($inventario)) {
				$inventario = new Inventarios;
				$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
				$inventario->id_articulo = $suela->id;
				$inventario->id_colores = $suelaColor->id_colores;
				$inventario->numero = $suelaNumero->numero;
				$inventario->nombre_articulo = $suela->nombre;
				$inventario->cantidad_existente = 0;
				$inventario->cantidad_apartada = 0;
				$inventario->unidad_medida = 'Pares';
			}
			if ($tipo_precio == 'precio_extrachico') {
				if($suelaNumero->numero >= 12 && $suelaNumero->numero < 18){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_chico') {
				if($suelaNumero->numero >= 18 && $suelaNumero->numero < 22){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_mediano') {
				if($suelaNumero->numero >= 22 && $suelaNumero->numero < 25){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_grande') {
				if($suelaNumero->numero >= 25 && $suelaNumero->numero < 32){
					$inventario->ultimo_precio = $precio;
				}
			}
			$inventario->save();
		}

		echo $precio;
	}
}
