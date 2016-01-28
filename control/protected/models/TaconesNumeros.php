<?php

/**
 * This is the model class for table "tacones_numeros".
 *
 * The followings are the available columns in table 'tacones_numeros':
 * @property integer $id
 * @property double $numero
 * @property integer $id_tacones
 *
 * The followings are the available model relations:
 * @property SuelasNumeros[] $suelasNumeroses
 * @property Tacones $idTacones
 */
class TaconesNumeros extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tacones_numeros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numero, id_tacones', 'required'),
			array('id_tacones', 'numerical', 'integerOnly'=>true),
			array('numero', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numero, id_tacones', 'safe', 'on'=>'search'),
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
			'suelasNumeros' => array(self::MANY_MANY, 'SuelasNumeros', 'suelas_tacones_numeros(id_tacones_numeros, id_suelas_numeros)'),
			'tacon' => array(self::BELONGS_TO, 'Tacones', 'id_tacones'),
			'suelasTaconesNumeros' => array(self::HAS_MANY, 'SuelasTaconesNumeros', 'id_tacones_numeros'),

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
			'id_tacones' => 'Id Tacones',
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
		$criteria->compare('id_tacones',$this->id_tacones);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaconesNumeros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
