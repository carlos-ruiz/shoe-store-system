<?php

class ClientesController extends Controller
{
	public $section = 'clientes';
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
				'actions'=>array('admin','delete'),
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
		$model = new Clientes;
		$direccion = new Direcciones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Clientes']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['Clientes'];
			if (isset($_POST['Direcciones'])) {
				$direccion->attributes=$_POST['Direcciones'];
			}
			$model->id_direcciones = 0;
			if($model->validate() & $direccion->validate()){
				if($direccion->save()){
					$model->id_direcciones = $direccion->id;
					if ($model->save()) {
						$transaction->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}else{
				$transaction->rollback();
			}

		}

		$this->render('create',array(
			'model'=>$model,
			'direccion'=>$direccion,
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
		$direccion = $model->direccion;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Clientes']))
		{
			// $model->attributes=$_POST['Clientes'];
			// if($model->save())
			// 	$this->redirect(array('view','id'=>$model->id));

			$transaction = Yii::app()->db->beginTransaction();
			$model->attributes=$_POST['Clientes'];
			if (isset($_POST['Direcciones'])) {
				$direccion->attributes=$_POST['Direcciones'];
			}
			if($model->validate() & $direccion->validate()){
				if($direccion->save()){
					$model->id_direcciones = $direccion->id;
					if ($model->save()) {
						$transaction->commit();
						$this->redirect(array('view','id'=>$model->id));
					}
				}
			}else{
				$transaction->rollback();
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'direccion'=>$direccion,
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
		$dataProvider=new CActiveDataProvider('Clientes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Clientes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Clientes'])){
			$model->attributes=$_GET['Clientes'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Clientes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Clientes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Clientes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clientes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function obtenerNombreCompleto($data, $row)
	{
		return $data->obtenerNombreCompleto();
	}
}
