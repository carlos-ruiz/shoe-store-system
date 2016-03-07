<?php

class ModelosMaterialesPredeterminadosController extends Controller
{
	public $section = 'modelos_materiales_default';
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
				'actions'=>array('admin','delete', 'suelasPorModelo', 'coloresPorModelo', 'coloresPorSuela', 'coloresPorAgujeta', 'coloresPorOjillo', 'revisarSiTieneAgujetas', 'revisarSiSuelaTieneTacon', 'taconesPorSuela', 'coloresPorTacon', 'materialesDeColores'),
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
		$model=new ModelosMaterialesPredeterminados('nuevo');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ModelosMaterialesPredeterminados']))
		{
			$datos = $_POST['ModelosMaterialesPredeterminados'];
			$model->attributes=$_POST['ModelosMaterialesPredeterminados'];
			$modeloColor = ModelosColores::model()->find('id_modelos=:modelo AND id_colores=:color', array('modelo'=>$datos['id_modelos'], 'color'=>$datos['id_color_modelo']));
			$suelaColor = SuelasColores::model()->find('id_suelas=:suela AND id_colores=:color', array('suela'=>$datos['id_suelas'], 'color'=>$datos['id_color_suela']));
			$model->id_modelos_colores = $modeloColor->id;
			$model->id_suelas_colores = $suelaColor->id;

			if (isset($datos['id_tacones']) && $datos['id_tacones'] > 0 && isset($datos['id_color_tacon']) && $datos['id_color_tacon'] > 0) {
				$taconColor = TaconesColores::model()->find('id_tacones=? AND id_colores=?', array($datos['id_tacones'], $datos['id_color_tacon']));
				$model->id_tacones_colores = $taconColor->id;
			}
			if (isset($datos['id_agujetas']) && $datos['id_agujetas'] && isset($datos['id_color_agujetas']) && $datos['id_color_agujetas'] > 0) {
				$agujetasColor = AgujetasColores::model()->find('id_agujetas=? AND id_colores=?', array($datos['id_agujetas'], $datos['id_color_agujetas']));
				$model->id_agujetas_colores = $agujetasColor->id;
			}
			if (isset($datos['id_ojillos']) && $datos['id_ojillos'] && isset($datos['id_color_ojillos']) && $datos['id_color_ojillos']) {
				$ojillosColor = OjillosColores::model()->find('id_ojillos=? AND id_colores=?', array($datos['id_ojillos'], $datos['id_color_ojillos']));
				$model->id_ojillos_colores = $ojillosColor->id;
			}

			$configuracionExistente = ModelosMaterialesPredeterminados::model()->find('id_modelos_colores=?' , $model->id_modelos_colores);
			
			if (isset($configuracionExistente)) {
				foreach ($configuracionExistente->materialesColoresPredeterminados as $mcp) {
					$mcp->delete();
				}
				$configuracionExistente->delete();
			}

			if($model->save()){
				if (isset($_POST['ModelosMaterialesPredeterminados']['MaterialesColores'])) {
					$materialesColores = $_POST['ModelosMaterialesPredeterminados']['MaterialesColores'];

					foreach ($materialesColores as $id_material => $id_color) {
						$materialColoresPredeterminados = new MaterialesColoresPredeterminados;
						$materialColoresPredeterminados->id_modelos_materiales_predeterminados = $model->id;
						$materialColoresPredeterminados->id_materiales = $id_material;
						$materialColoresPredeterminados->id_colores = $id_color;
						$materialColoresPredeterminados->save();
					}
				}
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
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

		$model->id_modelos = $model->modeloColor->id_modelos;
		$model->id_color_modelo = $model->modeloColor->id_colores;
		$model->id_suelas = $model->suelaColor->id_suelas;
		$model->id_color_suela = $model->suelaColor->id_colores;
		if (isset($model->taconColor)) {
			$model->id_tacones = $model->taconColor->id_tacones;
			$model->id_color_tacon = $model->taconColor->id_colores;
		}
		if (isset($model->agujetaColor)) {
			$model->id_agujetas = $model->agujetaColor->id_agujetas;
			$model->id_color_agujetas = $model->agujetaColor->id_colores;
		}
		if (isset($model->ojillosColor)) {
			$model->id_ojillos = $model->ojillosColor->id_ojillos;
			$model->id_color_ojillos = $model->ojillosColor->id_colores;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ModelosMaterialesPredeterminados']))
		{
			// $transaction = Yii::app()->db->beginTransaction();
			$datos = $_POST['ModelosMaterialesPredeterminados'];
			$model->attributes=$_POST['ModelosMaterialesPredeterminados'];
			$modeloColor = ModelosColores::model()->find('id_modelos=:modelo AND id_colores=:color', array('modelo'=>$datos['id_modelos'], 'color'=>$datos['id_color_modelo']));
			$suelaColor = SuelasColores::model()->find('id_suelas=:suela AND id_colores=:color', array('suela'=>$datos['id_suelas'], 'color'=>$datos['id_color_suela']));
			$model->id_modelos_colores = $modeloColor->id;
			$model->id_suelas_colores = $suelaColor->id;

			if (isset($datos['id_tacones']) && $datos['id_tacones'] > 0 && isset($datos['id_color_tacon']) && $datos['id_color_tacon'] > 0) {
				$taconColor = TaconesColores::model()->find('id_tacones=? AND id_colores=?', array($datos['id_tacones'], $datos['id_color_tacon']));
				$model->id_tacones_colores = $taconColor->id;
			}
			if (isset($datos['id_agujetas']) && $datos['id_agujetas'] && isset($datos['id_color_agujetas']) && $datos['id_color_agujetas'] > 0) {
				$agujetasColor = AgujetasColores::model()->find('id_agujetas=? AND id_colores=?', array($datos['id_agujetas'], $datos['id_color_agujetas']));
				$model->id_agujetas_colores = $agujetasColor->id;
			}
			if (isset($datos['id_ojillos']) && $datos['id_ojillos'] && isset($datos['id_color_ojillos']) && $datos['id_color_ojillos']) {
				$ojillosColor = OjillosColores::model()->find('id_ojillos=? AND id_colores=?', array($datos['id_ojillos'], $datos['id_color_ojillos']));
				$model->id_ojillos_colores = $ojillosColor->id;
			}
			
			$configuracionExistente = ModelosMaterialesPredeterminados::model()->find('id_modelos_colores=? AND id!=?' , array($model->id_modelos_colores, $model->id));
			if (isset($configuracionExistente)) {
				foreach ($configuracionExistente->materialesColoresPredeterminados as $mcp) {
					$mcp->delete();
				}
				$configuracionExistente->delete();
			}

			$materialesColoresPredeterminados = MaterialesColoresPredeterminados::model()->findAll('id_modelos_materiales_predeterminados=?', array($model->id));
			
			foreach ($materialesColoresPredeterminados as $mcp) {
				$mcp->delete();
			}

			if($model->save()){
				if (isset($_POST['ModelosMaterialesPredeterminados']['MaterialesColores'])) {
					$materialesColores = $_POST['ModelosMaterialesPredeterminados']['MaterialesColores'];

					foreach ($materialesColores as $id_material => $id_color) {
						$materialColoresPredeterminados = new MaterialesColoresPredeterminados;
						$materialColoresPredeterminados->id_modelos_materiales_predeterminados = $model->id;
						$materialColoresPredeterminados->id_materiales = $id_material;
						$materialColoresPredeterminados->id_colores = $id_color;
						$materialColoresPredeterminados->save();
					}
				}
				// $transaction->commit();
				$this->redirect(array('admin'));
			}else{
				// $transaction->rollback();
			}
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('ModelosMaterialesPredeterminados');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ModelosMaterialesPredeterminados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ModelosMaterialesPredeterminados']))
			$model->attributes=$_GET['ModelosMaterialesPredeterminados'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ModelosMaterialesPredeterminados the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ModelosMaterialesPredeterminados::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ModelosMaterialesPredeterminados $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='modelos-materiales-predeterminados-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSuelasPorModelo()
	{
		$list = ModelosSuelas::model()->findAll("id_modelos=?",array($_POST["ModelosMaterialesPredeterminados"]["id_modelos"]));
		foreach($list as $i => $data){
			if ($i==0) {
				echo "<option value=\"{$data->suela->id}\" selected>{$data->suela->nombre}</option>";
			}
			else{
				echo "<option value=\"{$data->suela->id}\">{$data->suela->nombre}</option>";
			}
		}
	}

	public function actionTaconesPorSuela()
	{
		$list = SuelasTacones::model()->findAll("id_suelas=?",array($_POST["ModelosMaterialesPredeterminados"]["id_suelas"]));
		foreach($list as $i => $data){
			if ($i==0) {
				echo "<option value=\"{$data->tacon->id}\" selected>{$data->tacon->nombre}</option>";
			}
			else{
				echo "<option value=\"{$data->tacon->id}\">{$data->tacon->nombre}</option>";
			}
		}
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["ModelosMaterialesPredeterminados"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionColoresPorSuela()
	{
		$list = SuelasColores::model()->findAll("id_suelas=?",array($_POST["ModelosMaterialesPredeterminados"]["id_suelas"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionColoresPorTacon()
	{
		$list = TaconesColores::model()->findAll("id_tacones=?",array($_POST["ModelosMaterialesPredeterminados"]["id_tacones"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionRevisarSiTieneAgujetas()
	{
		$id_modelo = $_POST['ModelosMaterialesPredeterminados']['id_modelos'];
		$modelo = Modelos::model()->findByPk($id_modelo);
		$materialAgujeta = Materiales::model()->find('nombre=?', array('Agujetas'));
		$materialOjillos = Materiales::model()->find('nombre=?', array('Ojillos'));
		$modeloMaterial = ModelosMateriales::model()->find('id_modelos=? AND (id_materiales=? OR id_materiales=? )', array($modelo->id, $materialAgujeta->id, $materialOjillos->id));
		if (isset($modeloMaterial)) {
			echo 'true';
		}else{
			echo 'false';
		}
	}

	public function actionRevisarSiSuelaTieneTacon()
	{
		$id_suela = $_POST['ModelosMaterialesPredeterminados']['id_suelas'];
		$suelaTacones = SuelasTacones::model()->find('id_suelas=?', array($id_suela));
		if (isset($suelaTacones)) {
			echo 'true';
		}else{
			echo 'false';
		}
	}

	public function actionColoresPorAgujeta()
	{
		$id_agujeta = $_POST['ModelosMaterialesPredeterminados']['id_agujetas'];
		$agujetaColores = AgujetasColores::model()->findAll('id_agujetas=?', array($id_agujeta));
		foreach($agujetaColores as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionColoresPorOjillo()
	{
		$id_ojillo = $_POST['ModelosMaterialesPredeterminados']['id_ojillos'];
		$ojillosColores = OjillosColores::model()->findAll('id_ojillos=?', array($id_ojillo));
		foreach($ojillosColores as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionMaterialesDeColores()
	{
		$modelo = Modelos::model()->findByPk($_POST['id_modelo']);
		if (!isset($modelo)) {
			echo "";
			return;
		}
		foreach ($modelo->modelosMateriales as $modeloMaterial) {
			if (isset($modeloMaterial->material->colores) && sizeof($modeloMaterial->material->colores) > 0) {
				echo '
					<div class="form-group col-md-3 ">
						<label class="control-label required" for="material_'.$modeloMaterial->id_materiales.'">'.$modeloMaterial->material->nombre.' <span class="required">*</span></label>
						<div class="input-group">
							<select class="form-control" name="ModelosMaterialesPredeterminados[MaterialesColores]['.$modeloMaterial->id_materiales.']" id="material_'.$modeloMaterial->id_materiales.'" required>
								<option value="">Seleccione una opción</option>';
								foreach ($modeloMaterial->material->colores as $materialColor) {
									echo '<option value="'.$materialColor->id_colores.'">'.$materialColor->color->color.'</option>';
								}
				echo '
							</select>
						</div>
					</div>
				';
			}
		}
	}
}
