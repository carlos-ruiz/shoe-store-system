<?php

/**
 * This is the model class for table "abonos".
 *
 * The followings are the available columns in table 'abonos':
 * @property integer $id
 * @property double $importe
 * @property string $fecha_pago
 * @property integer $id_deudas
 * @property integer $id_formas_pago
 *
 * The followings are the available model relations:
 * @property Deudas $idDeudas
 * @property FormasPago $idFormasPago
 */
class Abonos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'abonos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('importe, fecha_pago, id_deudas, id_formas_pago', 'required'),
			array('id_deudas, id_formas_pago', 'numerical', 'integerOnly'=>true),
			array('importe', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, importe, fecha_pago, id_deudas, id_formas_pago', 'safe', 'on'=>'search'),
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
			'deuda' => array(self::BELONGS_TO, 'Deudas', 'id_deudas'),
			'formaPago' => array(self::BELONGS_TO, 'FormasPago', 'id_formas_pago'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'importe' => 'Importe',
			'fecha_pago' => 'Fecha de pago',
			'id_deudas' => 'Id deuda',
			'id_formas_pago' => 'Forma de pago',
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
		$criteria->compare('importe',$this->importe);
		$criteria->compare('fecha_pago',$this->fecha_pago,true);
		$criteria->compare('id_deudas',$this->id_deudas);
		$criteria->compare('id_formas_pago',$this->id_formas_pago);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Abonos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
