<?php

/**
 * This is the model class for table "tacones_colores".
 *
 * The followings are the available columns in table 'tacones_colores':
 * @property integer $id
 * @property integer $id_colores
 * @property integer $id_tacones
 *
 * The followings are the available model relations:
 * @property Colores $idColores
 * @property Tacones $idTacones
 */
class TaconesColores extends CActiveRecord
{
	public $var_color;
	public $var_tacon;
	public $precio_extrachico;
	public $precio_chico;
	public $precio_mediano;
	public $precio_grande;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tacones_colores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_colores, id_tacones', 'required'),
			array('id_colores, id_tacones', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_colores, id_tacones, var_tacon, var_color', 'safe', 'on'=>'search'),
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
			'tacon' => array(self::BELONGS_TO, 'Tacones', 'id_tacones'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_colores' => 'Color',
			'id_tacones' => 'Tacón',
			'var_tacon' => 'Tacón',
			'var_color' => 'Color',
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
		$criteria->compare('id_colores',$this->id_colores);
		$criteria->compare('id_tacones',$this->id_tacones);
		$criteria->with = array('color', 'tacon');
		$criteria->compare('color.color', $this->var_color, true);
		$criteria->compare('tacon.nombre', $this->var_tacon, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaconesColores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
