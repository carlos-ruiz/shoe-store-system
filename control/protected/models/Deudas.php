<?php

/**
 * This is the model class for table "deudas".
 *
 * The followings are the available columns in table 'deudas':
 * @property integer $id
 * @property double $importe
 * @property integer $id_provedores
 * @property string $fecha_compra
 *
 * The followings are the available model relations:
 * @property Abonos[] $abonoses
 * @property Provedores $idProvedores
 */
class Deudas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'deudas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('importe, id_provedores, fecha_compra', 'required'),
			array('id_provedores', 'numerical', 'integerOnly'=>true),
			array('importe', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, importe, id_provedores, fecha_compra', 'safe', 'on'=>'search'),
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
			'abonoses' => array(self::HAS_MANY, 'Abonos', 'id_deudas'),
			'idProvedores' => array(self::BELONGS_TO, 'Provedores', 'id_provedores'),
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
			'id_provedores' => 'Id Provedores',
			'fecha_compra' => 'Fecha Compra',
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
		$criteria->compare('id_provedores',$this->id_provedores);
		$criteria->compare('fecha_compra',$this->fecha_compra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deudas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
