<?php

/**
 * This is the model class for table "zapato_precios".
 *
 * The followings are the available columns in table 'zapato_precios':
 * @property integer $id
 * @property string $precio_extrachico
 * @property string $precio_chico
 * @property string $precio_mediano
 * @property string $precio_grande
 * @property integer $id_modelos
 * @property integer $id_suelas
 *
 * The followings are the available model relations:
 * @property Modelos $idModelos
 * @property Suelas $idSuelas
 */
class ZapatoPrecios extends CActiveRecord
{
	public $var_modelo;
	public $var_suela;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zapato_precios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('precio_extrachico, precio_chico, precio_mediano, precio_grande, id_modelos, id_suelas', 'required'),
			array('id_modelos, id_suelas', 'numerical', 'integerOnly'=>true),
			array('precio_extrachico, precio_chico, precio_mediano, precio_grande', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, precio_extrachico, precio_chico, precio_mediano, precio_grande, id_modelos, id_suelas, var_suela, var_modelo', 'safe', 'on'=>'search'),
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
			'suela' => array(self::BELONGS_TO, 'Suelas', 'id_suelas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'precio_extrachico' => 'Precio extra chico (12-17)',
			'precio_chico' => 'Precio chico (18-21)',
			'precio_mediano' => 'Precio mediano (22-24)',
			'precio_grande' => 'Precio grande (25-31)',
			'id_modelos' => 'Modelo',
			'id_suelas' => 'Suela',
			'var_modelo' => 'Modelo',
			'var_suela' => 'Suela',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('precio_extrachico',$this->precio_extrachico,true);
		$criteria->compare('precio_chico',$this->precio_chico,true);
		$criteria->compare('precio_mediano',$this->precio_mediano,true);
		$criteria->compare('precio_grande',$this->precio_grande,true);
		$criteria->compare('id_modelos',$this->id_modelos);
		$criteria->compare('id_suelas',$this->id_suelas);
		$criteria->with = array('modelo', 'suela');
		$criteria->compare('modelo.nombre',$this->var_modelo, true);
		$criteria->compare('suela.nombre',$this->var_suela, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZapatoPrecios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
