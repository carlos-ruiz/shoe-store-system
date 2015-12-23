<?php

/**
 * This is the model class for table "zapato_cortador".
 *
 * The followings are the available columns in table 'zapato_cortador':
 * @property integer $id
 * @property string $fecha
 * @property integer $cantidad_cortes
 * @property integer $id_pedidos_zapatos
 * @property integer $id_usuarios
 *
 * The followings are the available model relations:
 * @property PedidosZapatos $idPedidosZapatos
 * @property Usuarios $idUsuarios
 */
class ZapatoCortador extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zapato_cortador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, cantidad_cortes, id_pedidos_zapatos, id_usuarios', 'required'),
			array('cantidad_cortes, id_pedidos_zapatos, id_usuarios', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, cantidad_cortes, id_pedidos_zapatos, id_usuarios', 'safe', 'on'=>'search'),
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
			'idPedidosZapatos' => array(self::BELONGS_TO, 'PedidosZapatos', 'id_pedidos_zapatos'),
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
			'fecha' => 'Fecha',
			'cantidad_cortes' => 'Cantidad Cortes',
			'id_pedidos_zapatos' => 'Id Pedidos Zapatos',
			'id_usuarios' => 'Id Usuarios',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('cantidad_cortes',$this->cantidad_cortes);
		$criteria->compare('id_pedidos_zapatos',$this->id_pedidos_zapatos);
		$criteria->compare('id_usuarios',$this->id_usuarios);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZapatoCortador the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
