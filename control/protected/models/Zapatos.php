<?php

/**
 * This is the model class for table "zapatos".
 *
 * The followings are the available columns in table 'zapatos':
 * @property integer $id
 * @property double $numero
 * @property double $precio
 * @property string $codigo_barras
 * @property integer $id_modelos_colores
 * @property integer $id_suelas
 *
 * The followings are the available model relations:
 * @property InventarioZapatosTerminados[] $inventarioZapatosTerminadoses
 * @property PedidosZapatos[] $pedidosZapatoses
 * @property ModelosColores $idModelosColores
 * @property Suelas $idSuelas
 */
class Zapatos extends CActiveRecord
{
	public $id_modelos;
	public $id_colores;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zapatos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelos, id_colores, numero, precio, codigo_barras, id_suelas', 'required'),
			array('id_modelos, id_colores, id_modelos_colores, id_suelas', 'numerical', 'integerOnly'=>true),
			array('numero, precio', 'numerical'),
			array('codigo_barras', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero, precio, codigo_barras, id_modelos_colores, id_suelas', 'safe', 'on'=>'search'),
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
			'inventarioZapatosTerminados' => array(self::HAS_MANY, 'InventarioZapatosTerminados', 'id_zapatos'),
			'pedidosZapatos' => array(self::HAS_MANY, 'PedidosZapatos', 'id_zapatos'),
			'modeloColor' => array(self::BELONGS_TO, 'ModelosColores', 'id_modelos_colores'),
			'suela' => array(self::BELONGS_TO, 'Suelas', 'id_suelas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero' => 'Número',
			'precio' => 'Precio',
			'codigo_barras' => 'Código de barras',
			'id_modelos_colores' => 'Id Modelos Colores',
			'id_suelas' => 'Suela',
			'id_colores' => 'Color',
			'id_modelos' => 'Modelo',
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
		$criteria->compare('numero',$this->numero);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('codigo_barras',$this->codigo_barras,true);
		$criteria->compare('id_modelos_colores',$this->id_modelos_colores);
		$criteria->compare('id_suelas',$this->id_suelas);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zapatos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
