<?php

/**
 * This is the model class for table "modelos_colores".
 *
 * The followings are the available columns in table 'modelos_colores':
 * @property integer $id
 * @property integer $id_modelos
 * @property integer $id_colores
 *
 * The followings are the available model relations:
 * @property Colores $idColores
 * @property Modelos $idModelos
 * @property Zapatos[] $zapatoses
 */
class ModelosColores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelos_colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelos, id_colores', 'required'),
			array('id_modelos, id_colores', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_modelos, id_colores', 'safe', 'on'=>'search'),
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
			'color' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'modelo' => array(self::BELONGS_TO, 'Modelos', 'id_modelos'),
			'zapatos' => array(self::HAS_MANY, 'Zapatos', 'id_modelos_colores'),
			'materialesPredeterminados' => array(self::HAS_ONE, 'ModelosMaterialesPredeterminados', 'id_modelos_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_modelos' => 'Id Modelos',
			'id_colores' => 'Id Colores',
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
		$criteria->compare('id_modelos',$this->id_modelos);
		$criteria->compare('id_colores',$this->id_colores);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelosColores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
