<?php

/**
 * This is the model class for table "suelas_tacones_numeros".
 *
 * The followings are the available columns in table 'suelas_tacones_numeros':
 * @property integer $id_suelas_numeros
 * @property integer $id_tacones_numeros
 */
class SuelasTaconesNumeros extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suelas_tacones_numeros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_suelas_numeros, id_tacones_numeros', 'required'),
			array('id_suelas_numeros, id_tacones_numeros', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_suelas_numeros, id_tacones_numeros', 'safe', 'on'=>'search'),
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
			'suelaNumero' => array(self::BELONGS_TO, 'SuelasNumeros', 'id_suelas_numeros'),
			'taconNumero' => array(self::BELONGS_TO, 'TaconesNumeros', 'id_tacones_numeros'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_suelas_numeros' => 'Suela número',
			'id_tacones_numeros' => 'Tacon número',
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

		$criteria->compare('id_suelas_numeros',$this->id_suelas_numeros);
		$criteria->compare('id_tacones_numeros',$this->id_tacones_numeros);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuelasTaconesNumeros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
