<?php

/**
 * This is the model class for table "modelos".
 *
 * The followings are the available columns in table 'modelos':
 * @property integer $id
 * @property string $nombre
 * @property string $imagen
 *
 * The followings are the available model relations:
 * @property ModelosColores[] $modelosColores
 * @property ModelosMateriales[] $modelosMateriales
 * @property ModelosNumeros[] $modelosNumeros
 * @property ModelosSuelas[] $modelosSuelas
 */
class Modelos extends CActiveRecord
{
	public $id_colores;
	public $numero;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'unique'),
			array('nombre', 'length', 'max'=>128),
			array('imagen', 'file', 'types'=>'jpg, gif, png', 'safe' => false, 'allowEmpty' => false, 'on' => 'insert'),
			array('imagen', 'file', 'types'=>'jpg, gif, png', 'safe' => false, 'allowEmpty' => true, 'on' => 'update'),
			array('id, numero, id_colores', 'required', 'on' => 'generarEtiqueta'),
			array('nombre, imagen', 'safe', 'on'=>'generarEtiqueta'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, imagen', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'modelosColores' => array(self::HAS_MANY, 'ModelosColores', 'id_modelos'),
			'modelosMateriales' => array(self::HAS_MANY, 'ModelosMateriales', 'id_modelos'),
			'modelosNumeros' => array(self::HAS_MANY, 'ModelosNumeros', 'id_modelos'),
			'modelosSuelas' => array(self::HAS_MANY, 'ModelosSuelas', 'id_modelos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Modelo',
			'nombre' => 'Nombre',
			'imagen' => 'Imágen',
			'numero' => 'Número',
			'id_colores'=>'Color',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('imagen',$this->imagen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Modelos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerModelos(){
		return CHtml::listData(Modelos::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
	}

	public function obtenerSuelas($id_modelos){
		$modeloSuelas=ModelosSuelas::model()->findAll("id_modelos=?", array($id_modelos));
		$suelas = array();
		foreach ($modeloSuelas as $modeloSuela) {
			array_push($suelas, $modeloSuela->suela);
		}
		return CHtml::listData($suelas, 'id', 'nombre');
	}

	public function obtenerColores($id_modelos){
		$modeloColores=ModelosColores::model()->findAll("id_modelos=?", array($id_modelos));
		$colores = array();
		foreach ($modeloColores as $modeloColor) {
			array_push($colores, $modeloColor->color);
		}
		return CHtml::listData($colores, 'id', 'color');
	}

	public function obtenerNumeros($id_modelos){
		$modeloNumeros=ModelosNumeros::model()->findAll("id_modelos=?", array($id_modelos));
		$numeros = array();
		foreach ($modeloNumeros as $modeloNumero) {
			array_push($numeros, $modeloNumero);
		}
		return CHtml::listData($numeros, 'id', 'numero');
	}
}
