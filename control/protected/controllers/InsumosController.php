<?php

class InsumosController extends Controller
{
	public $section = 'insumos';
	public $subsection;
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete', 'gastosOperativos'),
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
		$model=new Insumos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Insumos']))
		{
			$model->attributes=$_POST['Insumos'];
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Insumos']))
		{
			$model->attributes=$_POST['Insumos'];
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
		$dataProvider=new CActiveDataProvider('Insumos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Insumos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Insumos']))
			$model->attributes=$_GET['Insumos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Insumos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Insumos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Insumos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='insumos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Control de todos los gastos diferentes a materias primas
	 * como luz, agua, gasolinas, viaticos, etc.
	 */
	public function actionGastosOperativos()
	{
		$this->section = 'extras';
		$this->subsection = 'gastosoperativos';
		$gastos = GastosOperativos::model()->findAll();
		$costoPar = CostoPar::model()->find();
		if(isset($_POST['GastosOperativos'])){
			foreach ($gastos as $gasto) {
				$gasto->delete();
			}
			if (isset($_POST['GastosOperativos']['existentes'])) {
				$existentes = $_POST['GastosOperativos']['existentes'];
				foreach ($existentes as $existente) {
					$gastoNuevo = new GastosOperativos;
					$gastoNuevo->concepto = $existente['concepto'];
					$gastoNuevo->costo = $existente['costo'];
					$gastoNuevo->save();
				}
			}
			if (isset($_POST['GastosOperativos']['nuevo'])) {
				$nuevos = $_POST['GastosOperativos']['nuevo'];
				foreach ($nuevos as $nuevo) {
					$gastoNuevo = new GastosOperativos;
					$gastoNuevo->concepto = $nuevo['concepto'];
					$gastoNuevo->costo = $nuevo['costo'];
					$gastoNuevo->save();
				}
			}

			if (isset($_POST['TotalPares'])) {
				if(!isset($costoPar)){
					$costoPar = new CostoPar;
				}
				$costoPar->pares_mes = $_POST['TotalPares']['mes'];
				$costoPar->costo_par = $_POST['TotalPares']['gasto_par'];
				$costoPar->save();
			}

			$this->redirect(array('gastosOperativos'));
		}

		$this->render('gastos', array(
			'gastos'=>$gastos,
			'total_pares'=>(isset($costoPar))?$costoPar->pares_mes:0,
			)
		);
	}
}
