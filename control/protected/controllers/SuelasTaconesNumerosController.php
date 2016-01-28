<?php

class SuelasTaconesNumerosController extends Controller
{
	public $section = 'extras';
	public $subsection = 'numeros_suelas_tacones';

	public function actionAdmin()
	{
		$suelas = Suelas::model()->findAll();
		if (isset($_POST['Configuracion'])) {
			$datos = $_POST['Configuracion'];
			if (isset($datos['suela'])) {
				$suelasTaconesnumeros = SuelasTaconesNumeros::model()->findAll();
				foreach ($suelasTaconesnumeros as $stn) {
					$stn->delete();
				}
				foreach ($datos['suela'] as $clave => $id_suela) {
					foreach ($datos['numeros'][$clave] as $numero_suela => $id_tacon_numero) {
						if (isset($id_tacon_numero)) {
							$suelaNumero = SuelasNumeros::model()->find('id_suelas=? AND numero=?', array($id_suela, $numero_suela));
							$suelaTaconNumero = new SuelasTaconesNumeros;
							$suelaTaconNumero->id_suelas_numeros = $suelaNumero->id;
							$suelaTaconNumero->id_tacones_numeros = $id_tacon_numero;
							$suelaTaconNumero->save();
						}
					}
				}
			}
		}
		$this->render('admin', array(
			'suelas' => $suelas,
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