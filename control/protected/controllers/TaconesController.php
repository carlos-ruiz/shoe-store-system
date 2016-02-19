<?php

class TaconesController extends Controller
{
	public $section = 'materiaPrima';
	public $subsection = 'tacones';
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
		$model=new Tacones;
		$colores = Colores::model()->findAll();
		$suelas = Suelas::model()->findAll();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tacones']))
		{
			$model->attributes=$_POST['Tacones'];
			if($model->save()){
				foreach ($_POST['TaconesColores']['id_colores'] as $id => $value) {
					$suelaColor = new TaconesColores;
					$suelaColor->id_tacones = $model->id;
					$suelaColor->id_colores = $id;
					$suelaColor->save();
				}
				foreach ($_POST['TaconesNumeros']['numero'] as $numero => $value) {
					$suelaNumero = new TaconesNumeros;
					$suelaNumero->numero = $numero;
					$suelaNumero->id_tacones = $model->id;
					$suelaNumero->save();
				}
				foreach ($_POST['TaconesSuelas']['id_suelas'] as $id_suela => $value) {
					$suelaTacon = new SuelasTacones;
					$suelaTacon->id_suelas = $id_suela;
					$suelaTacon->id_tacones = $model->id;
					$suelaTacon->save();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores,
			'suelas'=>$suelas,
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
		$suelas = Suelas::model()->findAll();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tacones']))
		{
			$model->attributes=$_POST['Tacones'];
			$transaction = Yii::app()->db->beginTransaction();
			try{
				if($model->save()){
					$ids_colores_seleccionados = array();
					if (isset($_POST['TaconesColores']['id_colores'])) {
						foreach ($_POST['TaconesColores']['id_colores'] as $id => $value) {
							array_push($ids_colores_seleccionados, $id);
						}
					}
					foreach ($model->taconesColores as $taconColor) {
						if(!in_array($taconColor->id_colores, $ids_colores_seleccionados)){
							$taconColor->delete();
						}else{
							$ids_colores_seleccionados = array_diff($ids_colores_seleccionados, array($taconColor->id_colores));
						}
					}

					$ids_numeros_seleccionados = array();
					if (isset($_POST['TaconesNumeros']['numero'])) {
						foreach ($_POST['TaconesNumeros']['numero'] as $numero => $value) {
							array_push($ids_numeros_seleccionados, $numero);
						}
					}
					foreach ($model->taconesNumeros as $taconNumero) {
						if(!in_array($taconNumero->numero, $ids_numeros_seleccionados)){
							foreach ($taconNumero->suelasTaconesNumeros as $suelaTaconNumero) {
								$suelaTaconNumero->delete();
							}
							$taconNumero->delete();
						}else{
							$ids_numeros_seleccionados = array_diff($ids_numeros_seleccionados, array($taconNumero->numero));
						}
					}

					$ids_suelas_seleccioandas = array();
					if (isset($_POST['TaconesSuelas']['id_suelas'])) {
						foreach ($_POST['TaconesSuelas']['id_suelas'] as $id => $value) {
							array_push($ids_suelas_seleccioandas, $id);
						}
					}
					foreach ($model->taconesSuelas as $taconSuela) {
						if(!in_array($taconSuela->id_suelas, $ids_suelas_seleccioandas)){
							$taconSuela->delete();
						}
						else{
							$ids_suelas_seleccioandas = array_diff($ids_suelas_seleccioandas, array($taconSuela->id_suelas));
						}
					}
					foreach ($ids_colores_seleccionados as $id) {
						$suelaColor = new TaconesColores;
						$suelaColor->id_tacones = $model->id;
						$suelaColor->id_colores = $id;
						$suelaColor->save();
					}
					foreach ($ids_numeros_seleccionados as $numero) {
						$suelaNumero = new TaconesNumeros;
						$suelaNumero->numero = $numero;
						$suelaNumero->id_tacones = $model->id;
						$suelaNumero->save();
					}
					foreach ($ids_suelas_seleccioandas as $id_suela) {
						$suelaTacon = new SuelasTacones;
						$suelaTacon->id_suelas = $id_suela;
						$suelaTacon->id_tacones = $model->id;
						$suelaTacon->save();
					}
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				$transaction->rollback();
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'colores'=>$colores,
			'suelas'=>$suelas,
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
		$dataProvider=new CActiveDataProvider('Tacones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tacones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tacones']))
			$model->attributes=$_GET['Tacones'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tacones the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tacones::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tacones $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tacones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAgregarInventario()
	{
		$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?',array('Tacones'));
		$tacones = Tacones::model()->findAll();
		if (isset($_POST['Inventario'])) {
			if (isset($_POST['Tacones']['stock_minimo'])) {
				$stock_minimo_suelas = $_POST['Tacones']['stock_minimo'];
			}
			if (isset($_POST['Inventario']['taconColor'])) {
				$taconesColores = $_POST['Inventario']['taconColor'];
				foreach ($taconesColores as $clave => $id_tacon_color) {
					$taconColor = TaconesColores::model()->findByPk($id_tacon_color);
					if (isset($_POST['Inventario']['numeros'][$clave])) {
						$numeros = $_POST['Inventario']['numeros'][$clave];
						foreach ($numeros as $numero => $cantidad) {
							if($cantidad != 0){
								$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=? AND numero=?', array($tipoArticulo->id, $taconColor->id_tacones, $taconColor->id_colores, $numero));
								if (!isset($inventario)) {
									$inventario = new Inventarios;
									$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
									$inventario->id_articulo = $taconColor->id_tacones;
									$inventario->nombre_articulo = $taconColor->tacon->nombre;
									$inventario->id_colores = $taconColor->id_colores;
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
				$this->redirect(array('admin'));
			}
		}
		$this->render('add_stock',array(
			'tacones'=>$tacones,
		));
	}

	public function actionDefinirPrecios()
	{
		$model=new TaconesColores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TaconesColores'])){
			$model->attributes=$_GET['TaconesColores'];
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

		$taconColor = TaconesColores::model()->findByPk($id);
		$tacon = Tacones::model()->findByPk($taconColor->id_tacones);
		$tipoArticulo = TiposArticulosInventario::model()->find('tipo=?', array('Tacones'));

		foreach ($tacon->taconesNumeros as $taconNumero) {
			$inventario = Inventarios::model()->find('id_tipos_articulos_inventario=? AND id_articulo=? AND id_colores=? AND numero=?', array($tipoArticulo->id, $tacon->id, $taconColor->id_colores, $taconNumero->numero));
			if (!isset($inventario)) {
				$inventario = new Inventarios;
				$inventario->id_tipos_articulos_inventario = $tipoArticulo->id;
				$inventario->id_articulo = $tacon->id;
				$inventario->id_colores = $taconColor->id_colores;
				$inventario->numero = $taconNumero->numero;
				$inventario->nombre_articulo = $tacon->nombre;
				$inventario->cantidad_existente = 0;
				$inventario->cantidad_apartada = 0;
				$inventario->unidad_medida = 'Pares';
			}
			if ($tipo_precio == 'precio_extrachico') {
				if($taconNumero->numero >= 12 && $taconNumero->numero < 18){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_chico') {
				if($taconNumero->numero >= 18 && $taconNumero->numero < 22){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_mediano') {
				if($taconNumero->numero >= 22 && $taconNumero->numero < 25){
					$inventario->ultimo_precio = $precio;
				}
			}
			elseif ($tipo_precio == 'precio_grande') {
				if($taconNumero->numero >= 25 && $taconNumero->numero < 32){
					$inventario->ultimo_precio = $precio;
				}
			}
			$inventario->save();
		}

		echo $precio;
	}
}
