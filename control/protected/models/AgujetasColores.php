<?php

/**
 * This is the model class for table "agujetas_colores".
 *
 * The followings are the available columns in table 'agujetas_colores':
 * @property integer $id
 * @property integer $id_agujetas
 * @property integer $id_colores
 *
 * The followings are the available model relations:
 * @property Agujetas $idAgujetas
 * @property Colores $idColores
 * @property Zapatos[] $zapatoses
 */
class AgujetasColores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agujetas_colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_agujetas, id_colores', 'required'),
			array('id_agujetas, id_colores', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_agujetas, id_colores', 'safe', 'on'=>'search'),
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
			'idAgujetas' => array(self::BELONGS_TO, 'Agujetas', 'id_agujetas'),
			'idColores' => array(self::BELONGS_TO, 'Colores', 'id_colores'),
			'zapatoses' => array(self::HAS_MANY, 'Zapatos', 'id_agujetas_colores'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_agujetas' => 'Id Agujetas',
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
		$criteria->compare('id_agujetas',$this->id_agujetas);
		$criteria->compare('id_colores',$this->id_colores);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AgujetasColores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
