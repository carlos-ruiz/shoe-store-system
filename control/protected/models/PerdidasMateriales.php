<?php

/**
 * This is the model class for table "perdidas_materiales".
 *
 * The followings are the available columns in table 'perdidas_materiales':
 * @property integer $id
 * @property double $cantidad
 * @property string $fecha
 * @property integer $id_usuarios
 * @property integer $id_materiales
 *
 * The followings are the available model relations:
 * @property Materiales $idMateriales
 * @property Usuarios $idUsuarios
 */
class PerdidasMateriales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'perdidas_materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, fecha, id_usuarios, id_materiales', 'required'),
			array('id_usuarios, id_materiales', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cantidad, fecha, id_usuarios, id_materiales', 'safe', 'on'=>'search'),
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
			'idMateriales' => array(self::BELONGS_TO, 'Materiales', 'id_materiales'),
			'idUsuarios' => array(self::BELONGS_TO, 'Usuarios', 'id_usuarios'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cantidad' => 'Cantidad',
			'fecha' => 'Fecha',
			'id_usuarios' => 'Id Usuarios',
			'id_materiales' => 'Id Materiales',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuarios',$this->id_usuarios);
		$criteria->compare('id_materiales',$this->id_materiales);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PerdidasMateriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
