<?php

/**
 * This is the model class for table "insumos".
 *
 * The followings are the available columns in table 'insumos':
 * @property integer $id
 * @property string $nombre
 * @property string $unidad_medida
 * @property double $cantidad
 *
 * The followings are the available model relations:
 * @property ComprasInsumos[] $comprasInsumoses
 * @property InventarioInsumos[] $inventarioInsumoses
 */
class Insumos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'insumos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, unidad_medida', 'required'),
			array('cantidad', 'numerical'),
			array('nombre', 'length', 'max'=>128),
			array('unidad_medida', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, unidad_medida, cantidad', 'safe', 'on'=>'search'),
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
			'comprasInsumoses' => array(self::HAS_MANY, 'ComprasInsumos', 'id_insumos'),
			'inventarioInsumoses' => array(self::HAS_MANY, 'InventarioInsumos', 'id_insumos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'unidad_medida' => 'Unidad Medida',
			'cantidad' => 'Cantidad',
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
		$criteria->compare('unidad_medida',$this->unidad_medida,true);
		$criteria->compare('cantidad',$this->cantidad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Insumos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
