<?php

class ZapatosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'zapatos';
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
			// 'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete', 'suelasPorModelo', 'coloresPorModelo', 'numerosPorModelo'),
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
		$model=new Zapatos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Zapatos']))
		{
			$model->attributes=$_POST['Zapatos'];
			$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($model->id_modelos, $model->id_colores));
			$model->id_modelos_colores = $modeloColor->id;
			$modeloNumero = ModelosNumeros::model()->findByPk($model->numero);
			$model->numero = $modeloNumero->numero;
			$model->codigo_barras = $model->id_modelos.$model->id_colores.'00000';
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model->id_modelos = $model->modeloColor->modelo->id;
		$model->id_colores = $model->modeloColor->color->id;
		$modeloNumero = ModelosNumeros::model()->find('id_modelos=? AND numero=?', array($model->id_modelos, $model->numero));
		$model->numero = $modeloNumero->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Zapatos']))
		{
			$model->attributes=$_POST['Zapatos'];
			$modeloColor = ModelosColores::model()->find('id_modelos=? AND id_colores=?', array($model->id_modelos, $model->id_colores));
			$model->id_modelos_colores = $modeloColor->id;
			$modeloNumero = ModelosNumeros::model()->findByPk($model->numero);
			$model->numero = $modeloNumero->numero;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Zapatos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Zapatos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Zapatos']))
			$model->attributes=$_GET['Zapatos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Zapatos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Zapatos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Zapatos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='zapatos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSuelasPorModelo()
	{
		$list = ModelosSuelas::model()->findAll("id_modelos=?",array($_POST["Zapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->suela->id}\">{$data->suela->nombre}</option>";
	}

	public function actionColoresPorModelo()
	{
		$list = ModelosColores::model()->findAll("id_modelos=?",array($_POST["Zapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->color->id}\">{$data->color->color}</option>";
	}

	public function actionNumerosPorModelo()
	{
		$list = ModelosNumeros::model()->findAll("id_modelos=?",array($_POST["Zapatos"]["id_modelos"]));
		foreach($list as $data)
			echo "<option value=\"{$data->id}\">{$data->numero}</option>";
	}
}
