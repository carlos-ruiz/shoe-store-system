<?php

/**
 * This is the model class for table "modelos_numeros".
 *
 * The followings are the available columns in table 'modelos_numeros':
 * @property integer $id
 * @property double $numero
 * @property integer $id_modelos
 *
 * The followings are the available model relations:
 * @property Modelos $idModelos
 */
class ModelosNumeros extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelos_numeros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, id_modelos', 'required'),
			array('id_modelos', 'numerical', 'integerOnly'=>true),
			array('numero', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero, id_modelos', 'safe', 'on'=>'search'),
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
			'modelo' => array(self::BELONGS_TO, 'Modelos', 'id_modelos'),
			'suelasNumeros' => array(self::HAS_MANY, 'ModelosSuelasNumeros', 'id_modelos_numeros'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numero' => 'Numero',
			'id_modelos' => 'Id Modelos',
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
		$criteria->compare('id_modelos',$this->id_modelos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelosNumeros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
