<?php

/**
 * This is the model class for table "suelas_tacones".
 *
 * The followings are the available columns in table 'suelas_tacones':
 * @property integer $id_suelas
 * @property integer $id_tacones
 */
class SuelasTacones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suelas_tacones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_suelas, id_tacones', 'required'),
			array('id_suelas, id_tacones', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_suelas, id_tacones', 'safe', 'on'=>'search'),
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
			'suela' => array(self::BELONGS_TO, 'Suelas', 'id_suelas'),
			'tacon' => array(self::BELONGS_TO, 'Tacones', 'id_tacones'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_suelas' => 'Id Suelas',
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

		$criteria->compare('id_suelas',$this->id_suelas);
		$criteria->compare('id_tacones',$this->id_tacones);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuelasTacones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function obtenerTaconesPorSuela($id_suelas){
		$suelaTacones=SuelasTacones::model()->findAll("id_suelas=?", array($id_suelas));
		$tacones = array();
		foreach ($suelaTacones as $suelaTacon) {
			array_push($tacones, $suelaTacon->tacon);
		}
		return CHtml::listData($tacones, 'id', 'nombre');
	}
}
