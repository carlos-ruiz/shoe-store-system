<?php

class InventariosController extends Controller
{
	public $section = 'inventarios';
	
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

	public function actionAgregarMaterial(){
		$model = new InventarioMateriales('agregarMaterial');
		if(isset($_POST['InventarioMateriales'])){
			$model->attributes = $_POST['InventarioMateriales'];
			$model->existencia = 0; //Parche porque no se como permitir null solo en este contexto
			if($model->validate()){
				$existente = InventarioMateriales::model()->find('id_materiales=?', array($model->id_materiales));
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
		$this->render('agregar_material', array('model'=>$model));
	}

	public function actionAgregarInsumo(){
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

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}