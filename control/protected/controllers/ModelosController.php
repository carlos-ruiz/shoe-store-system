<?php

class ModelosController extends Controller
{
	public $section = 'modelos';
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
				'actions'=>array('create','update', 'delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
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
		$model = $this->loadModel($id);
		$modeloSuelas = ModelosSuelas::model()->findAll('id_modelos=:modelo', array('modelo'=>$id));
		$modeloColores = ModelosColores::model()->findAll('id_modelos=:modelo', array('modelo'=>$id));
		$modeloNumeros = ModelosNumeros::model()->findAll('id_modelos=:modelo', array('modelo'=>$id));
		$modeloMateriales = ModelosMateriales::model()->findAll('id_modelos=:modelo', array('modelo'=>$id));

		$this->render('view',array(
			'model'=>$model,
			'suelas'=>$modeloSuelas,
			'colores'=>$modeloColores,
			'numeros'=>$modeloNumeros,
			'materiales'=>$modeloMateriales,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Modelos;
		$colores = Colores::model()->findAll();
		$suelas = Suelas::model()->findAll();
		$materiales = Materiales::model()->findAll();

		$folderImagesPath = Yii::getPathOfAlias('webroot').'/images/modelos/';
		if(!is_dir($folderImagesPath)) {
			mkdir($folderImagesPath);
			chmod($folderImagesPath, 0755);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Modelos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Modelos'];

				//Guardando la imagen seleccionada
				$uploadedFile = CUploadedFile::getInstance($model,'imagen');
				if(isset($uploadedFile)){
					$tempNameArray = explode('.',$uploadedFile->name);
					$ext = ".".$tempNameArray[sizeof($tempNameArray)-1];
		            $fileName = time().rand(1, 999).$ext;
					$uploadedFile->saveAs($folderImagesPath.$fileName);
					$model->imagen = Yii::app()->request->baseUrl."/images/modelos/".$fileName;
				}
				if($model->save()){
					if(isset($_POST['ModelosSuelas'])){
						foreach ($_POST['ModelosSuelas']['id_suelas'] as $id => $value) {
							$modeloSuela = new ModelosSuelas;
							$modeloSuela->id_modelos = $model->id;
							$modeloSuela->id_suelas = $id;
							$modeloSuela->save();
						}
					}

					if(isset($_POST['ModelosColores'])){
						foreach ($_POST['ModelosColores']['id_colores'] as $id => $value) {
							$modeloColor = new ModelosColores;
							$modeloColor->id_modelos = $model->id;
							$modeloColor->id_colores = $id;
							$modeloColor->save();
						}
					}

					if(isset($_POST['ModelosNumeros'])){
						foreach ($_POST['ModelosNumeros']['numero'] as $numero => $value) {
							$modeloNumero = new ModelosNumeros;
							$modeloNumero->id_modelos = $model->id;
							$modeloNumero->numero = $numero;
							$modeloNumero->save();
						}
					}

					if (isset($_POST['ModelosMateriales'])) {
						foreach ($_POST['ModelosMateriales']['id_materiales'] as $id => $value) {
							$modeloMaterial = new ModelosMateriales;
							$modeloMaterial->id_modelos = $model->id;
							$modeloMaterial->id_materiales = $id;
							$modeloMaterial->cantidad = $_POST['ModelosMateriales']['cantidad'][$id];
							$modeloMaterial->unidad_medida = $_POST['ModelosMateriales']['unidad_medida'][$id];
							$modeloMaterial->save();
						}
					}

					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				$transaction->rollback();
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'colores'=>$colores, 
			'suelas'=>$suelas,
			'materiales'=>$materiales,
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
		$materiales = Materiales::model()->findAll();
		$folderImagesPath = Yii::getPathOfAlias('webroot').'/images/modelos/';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Modelos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				foreach ($model->modelosSuelas as $modeloSuela) {
					$modeloSuela->delete();
				}
				foreach ($model->modelosColores as $modeloColor) {
					$modeloColor->delete();
				}
				foreach ($model->modelosMateriales as $modeloMaterial) {
					$modeloMaterial->delete();
				}
				foreach ($model->modelosNumeros as $modeloNumero) {
					$modeloNumero->delete();
				}

				$model->attributes=$_POST['Modelos'];

				//Guardando la imagen seleccionada
				$uploadedFile = CUploadedFile::getInstance($model,'imagen');
				if (isset($uploadedFile)) {
					$tempNameArray = explode('.',$uploadedFile->name);
					$ext = ".".$tempNameArray[sizeof($tempNameArray)-1];
		            $fileName = time().rand(1, 999).$ext;
					$uploadedFile->saveAs($folderImagesPath.$fileName);
					$model->imagen = Yii::app()->request->baseUrl."/images/modelos/".$fileName;
				}

				if($model->save()){
					if(isset($_POST['ModelosSuelas'])){
						foreach ($_POST['ModelosSuelas']['id_suelas'] as $id => $value) {
							$modeloSuela = new ModelosSuelas;
							$modeloSuela->id_modelos = $model->id;
							$modeloSuela->id_suelas = $id;
							$modeloSuela->save();
						}
					}

					if(isset($_POST['ModelosColores'])){
						foreach ($_POST['ModelosColores']['id_colores'] as $id => $value) {
							$modeloColor = new ModelosColores;
							$modeloColor->id_modelos = $model->id;
							$modeloColor->id_colores = $id;
							$modeloColor->save();
						}
					}

					if(isset($_POST['ModelosNumeros'])){
						foreach ($_POST['ModelosNumeros']['numero'] as $numero => $value) {
							$modeloNumero = new ModelosNumeros;
							$modeloNumero->id_modelos = $model->id;
							$modeloNumero->numero = $numero;
							$modeloNumero->save();
						}
					}

					if (isset($_POST['ModelosMateriales'])) {
						foreach ($_POST['ModelosMateriales']['id_materiales'] as $id => $value) {
							$modeloMaterial = new ModelosMateriales;
							$modeloMaterial->id_modelos = $model->id;
							$modeloMaterial->id_materiales = $id;
							$modeloMaterial->cantidad = $_POST['ModelosMateriales']['cantidad'][$id];
							$modeloMaterial->unidad_medida = $_POST['ModelosMateriales']['unidad_medida'][$id];
							$modeloMaterial->save();
						}
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
			'materiales'=>$materiales,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$transaction = Yii::app()->db->beginTransaction();
		try{
			foreach ($model->modelosSuelas as $modeloSuela) {
				$modeloSuela->delete();
			}
			foreach ($model->modelosColores as $modeloColor) {
				$modeloColor->delete();
			}
			foreach ($model->modelosMateriales as $modeloMaterial) {
				$modeloMaterial->delete();
			}
			foreach ($model->modelosNumeros as $modeloNumero) {
				$modeloNumero->delete();
			}
			$model->delete();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Modelos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Modelos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Modelos']))
			$model->attributes=$_GET['Modelos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Modelos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Modelos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Modelos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='modelos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
