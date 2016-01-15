<?php

class ZapatoPreciosController extends Controller
{
	public $section = 'extras';
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
				'actions'=>array('admin','delete', 'actualizarPrecios', 'consultarPrecio', 'totalRow'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ZapatoPrecios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ZapatoPrecios'])){
			$model->attributes=$_GET['ZapatoPrecios'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ZapatoPrecios the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ZapatoPrecios::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ZapatoPrecios $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='zapato-precios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionActualizarPrecios()
	{
		$id = $_POST["id"];
		$precio = $_POST["precio"];
		$tipo_precio = $_POST['tipo_precio'];

		$zapatoPrecios = ZapatoPrecios::model()->findByPk($id);

		if ($tipo_precio == 'precio_extrachico') {
			$zapatoPrecios->precio_extrachico = $precio;
		}
		elseif ($tipo_precio == 'precio_chico') {
			$zapatoPrecios->precio_chico = $precio;
		}
		elseif ($tipo_precio == 'precio_mediano') {
			$zapatoPrecios->precio_mediano = $precio;
		}
		elseif ($tipo_precio == 'precio_grande') {
			$zapatoPrecios->precio_grande = $precio;
		}

		$zapatoPrecios->save();
		$this->actualizarPreciosAnteriores($zapatoPrecios->id_modelos, $zapatoPrecios->id_suelas, $tipo_precio, $precio);

		echo $precio;
	}

	public function actualizarPreciosAnteriores($id_modelo, $id_suela, $tipo_precio, $precio)
	{
		$zapatos = Zapatos::model()->findAll('id_modelos=? AND id_suelas=?', array($id_modelo, $id_suela));
		if (isset($zapatos)) {
			foreach ($zapatos as $zapato) {
				if ($tipo_precio == 'precio_extrachico') {
					if($zapato->numero >= 12 && $zapato->numero < 18){
						$zapato->precio = $precio;
					}
				}
				elseif ($tipo_precio == 'precio_chico') {
					if($zapato->numero >= 18 && $zapato->numero < 22){
						$zapato->precio = $precio;
					}
				}
				elseif ($tipo_precio == 'precio_mediano') {
					if($zapato->numero >= 22 && $zapato->numero < 25){
						$zapato->precio = $precio;
					}
				}
				elseif ($tipo_precio == 'precio_grande') {
					if($zapato->numero >= 25 && $zapato->numero < 32){
						$zapato->precio = $precio;
					}
				}

				$zapato->save();
			}
		}
	}

	public function actionConsultarPrecio()
	{
		$id_modelos = $_POST['id_modelos'];
		$id_suelas = $_POST['id_suelas'];
		$numero = $_POST['numero'];

		$zapato = Zapatos::model()->find('id_modelos=? AND id_suelas=? AND numero=?', array($id_modelos, $id_suelas, $numero));

		echo $zapato->precio;
	}

	public function actionTotalRow()
	{
		$clave = 0;
		$id_modelos = 0;
		foreach ($_POST['Pedido']['modelo'] as $key => $value) {
			$clave = $key;
			$id_modelos = $value;
		}
		$id_suelas = $_POST['Pedido']['suela'][$clave];
		$totalRow = 0;
		foreach ($_POST['Pedido']['numeros'][$clave] as $numero => $cantidad) {
			if (isset($cantidad) && $cantidad > 0) {
				$zapato = Zapatos::model()->find('id_modelos=? AND id_suelas=? AND numero=?', array($id_modelos, $id_suelas, $numero));
				if (isset($zapato)) {
					$totalRow += ($cantidad * $zapato->precio);
				}
			}
		}
		echo $totalRow;
	}
}
