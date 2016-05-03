<?php

/**
 * This is the model class for table "deudas_pedidos_proveedores".
 *
 * The followings are the available columns in table 'deudas_pedidos_proveedores':
 * @property integer $id
 * @property string $cantidad
 * @property integer $id_provedores
 * @property integer $id_pedidos
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Pedidos $idPedidos
 * @property Provedores $idProvedores
 */
class DeudasPedidosProveedores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'deudas_pedidos_proveedores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad, id_provedores, id_pedidos', 'required'),
			array('id_provedores, id_pedidos', 'numerical', 'integerOnly'=>true),
			array('cantidad', 'length', 'max'=>10),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cantidad, id_provedores, id_pedidos, fecha', 'safe', 'on'=>'search'),
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
			'pedido' => array(self::BELONGS_TO, 'Pedidos', 'id_pedidos'),
			'proveedor' => array(self::BELONGS_TO, 'Provedores', 'id_provedores'),
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
			'id_provedores' => 'Id Provedores',
			'id_pedidos' => 'Id Pedidos',
			'fecha' => 'Fecha',
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
		$criteria->compare('cantidad',$this->cantidad,true);
		$criteria->compare('id_provedores',$this->id_provedores);
		$criteria->compare('id_pedidos',$this->id_pedidos);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeudasPedidosProveedores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
