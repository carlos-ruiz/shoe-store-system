<?php

class ModelosSuelasNumerosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'numeros_suelas_modelos';

	public function actionAdmin()
	{
		$modelos = Modelos::model()->findAll();

		if (isset($_POST['Configuracion'])) {
			$datos = $_POST['Configuracion'];
			if (isset($datos['modelo'])) {
				$modelosSuelasNumerosTodos = ModelosSuelasNumeros::model()->findAll();
				foreach ($modelosSuelasNumerosTodos as $msn) {
					$msn->delete();
				}
				foreach ($datos['modelo'] as $clave => $id_modelo) {
					foreach ($datos['numeros'][$clave] as $numero_modelo => $id_suela_numero) {
						if (isset($id_suela_numero)) {
							$modeloNumero = ModelosNumeros::model()->find('id_modelos=? AND numero=?', array($id_modelo, $numero_modelo));
							$modeloSuelaNumero = new ModelosSuelasNumeros;
							$modeloSuelaNumero->id_modelos_numeros = $modeloNumero->id;
							$modeloSuelaNumero->id_suelas_numeros = $id_suela_numero;
							$modeloSuelaNumero->save();
						}
					}
				}
			}
		}
		$this->render('admin', array(
			'modelos' => $modelos,
		));
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