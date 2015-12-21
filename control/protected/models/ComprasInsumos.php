<?php

/**
 * This is the model class for table "compras_insumos".
 *
 * The followings are the available columns in table 'compras_insumos':
 * @property integer $id
 * @property string $fecha_compra
 * @property double $cantidad
 * @property integer $id_insumos
 *
 * The followings are the available model relations:
 * @property Insumos $idInsumos
 */
class ComprasInsumos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'compras_insumos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_compra, cantidad, id_insumos', 'required'),
			array('id_insumos', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha_compra, cantidad, id_insumos', 'safe', 'on'=>'search'),
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
			'idInsumos' => array(self::BELONGS_TO, 'Insumos', 'id_insumos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha_compra' => 'Fecha Compra',
			'cantidad' => 'Cantidad',
			'id_insumos' => 'Id Insumos',
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
		$criteria->compare('fecha_compra',$this->fecha_compra,true);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('id_insumos',$this->id_insumos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ComprasInsumos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
