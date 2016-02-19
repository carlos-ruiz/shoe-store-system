<?php

/**
 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $id
 * @property integer $id_clientes
 * @property string $fecha_pedido
 * @property string $fecha_entrega
 * @property integer $id_formas_pago
 * @property string $total
 * @property integer $id_estatus_pedidos
 * @property string $prioridad
 * @property integer $descuento
 * @property integer $estatus_pagos_id
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 *
 * The followings are the available model relations:
 * @property MaterialesApartadosPedido[] $materialesApartadosPedidos
 * @property Pagos[] $pagos
 * @property Clientes $cliente
 * @property EstatusPagos $estatusPago
 * @property EstatusPedidos $estatusPedido
 * @property FormasPago $formaPago
 * @property PedidosZapatos[] $pedidosZapatos
 */
class Pedidos extends CActiveRecord
{
	public $var_cliente_nombre;
	public $var_estatus;
	public $var_estatus_pago;
	public $var_forma_pago;
	public $var_adeudo;
	public $pagado;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedidos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_clientes, fecha_pedido, id_formas_pago, total, id_estatus_pedidos, estatus_pagos_id', 'required'),
			array('id_clientes, id_formas_pago, id_estatus_pedidos, descuento, estatus_pagos_id', 'numerical', 'integerOnly'=>true),
			array('pagado', 'numerical'),
			array('total', 'length', 'max'=>10),
			array('prioridad', 'length', 'max'=>45),
			array('fecha_entrega, total, fecha_creacion, fecha_modificacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_clientes, fecha_pedido, fecha_entrega, id_formas_pago, total, id_estatus_pedidos, prioridad, descuento, var_cliente_nombre, var_estatus, var_estatus_pago, var_forma_pago, estatus_pagos_id, pagado', 'safe', 'on'=>'search'),
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
			'pagos' => array(self::HAS_MANY, 'Pagos', 'id_pedidos'),
			'cliente' => array(self::BELONGS_TO, 'Clientes', 'id_clientes'),
			'estatus' => array(self::BELONGS_TO, 'EstatusPedidos', 'id_estatus_pedidos'),
			'formaPago' => array(self::BELONGS_TO, 'FormasPago', 'id_formas_pago'),
			'pedidosZapatos' => array(self::HAS_MANY, 'PedidosZapatos', 'id_pedidos', 'order'=>'caracteristicas_especiales ASC'),
			'estatusPago' => array(self::BELONGS_TO, 'EstatusPagos', 'estatus_pagos_id'),
			'materialesApartados' => array(self::HAS_MANY, 'MaterialesApartadosPedido', 'id_pedidos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_clientes' => 'Cliente',
			'fecha_pedido' => 'Fecha de pedido',
			'fecha_entrega' => 'Fecha de entrega',
			'id_formas_pago' => 'Forma de pago',
			'total' => 'Total ($)',
			'id_estatus_pedidos' => 'Estatus del pedidos',
			'prioridad' => 'Prioridad',
			'descuento' => 'Descuento(%)',
			'var_cliente_nombre' => 'Cliente',
			'var_estatus' => 'Estatus',
			'var_estatus_pago' => 'Estatus de pago',
			'var_forma_pago' => 'Forma de pago',
			'estatus_pagos_id' => 'Estatus de pago',
			'pagado' => 'Su pago',
			'fecha_creacion' => 'Fecha de creación',
			'fecha_modificacion' => 'Fecha de última edición',
			'var_adeudo' => 'Adeudo',
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
		$criteria->compare('id_clientes',$this->id_clientes);
		$criteria->compare('fecha_pedido',$this->fecha_pedido,true);
		$criteria->compare('fecha_entrega',$this->fecha_entrega,true);
		$criteria->compare('id_formas_pago',$this->id_formas_pago);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('id_estatus_pedidos',$this->id_estatus_pedidos);
		$criteria->compare('prioridad',$this->prioridad,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->with = array('cliente', 'estatus', 'formaPago', 'estatusPago');
		$criteria->compare("CONCAT(
								cliente.nombre,' ',
								cliente.apellido_paterno,' ',
								IFNULL(cliente.apellido_materno,'')
							)", $this->var_cliente_nombre, true);
		$criteria->compare('estatus.nombre', $this->var_estatus, true);
		$criteria->compare('estatusPago.nombre', $this->var_estatus_pago, true);
		$criteria->compare('formaPago.nombre', $this->var_forma_pago, true);
		$criteria->compare('estatus_pagos_id',$this->estatus_pagos_id);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_modificacion',$this->fecha_modificacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'fecha_entrega ASC',
		        'attributes'=>array(
		        	'var_cliente_nombre'=>array(
		                'asc'=>'cliente.nombre',
		                'desc'=>'cliente.nombre DESC',
		            ),
		            'var_forma_pago'=>array(
		                'asc'=>'formaPago.nombre',
		                'desc'=>'formaPago.nombre DESC',
		            ),
		            'var_estatus'=>array(
		                'asc'=>'estatus.nombre',
		                'desc'=>'estatus.nombre DESC',
		            ),
		            'var_estatus_pago'=>array(
		                'asc'=>'estatusPago.nombre',
		                'desc'=>'estatusPago.nombre DESC',
		            ),
		            '*',
		        ),
		    ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pedidos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerAdeudo()
	{
		$adeudo = $this->total;
		$pagos = Pagos::model()->findAll('id_pedidos=?', array($this->id));
		foreach ($pagos as $pago) {
			$adeudo -= $pago->importe; 
		}
		return $adeudo;
	}

	public function obtenerMontoPagado()
	{
		$pagado = 0;
		if (isset($this->id)) {
			$pagos = Pagos::model()->findAll('id_pedidos=?', array($this->id));
			foreach ($pagos as $pago) {
				$pagado += $pago->importe; 
			}
		}
		return $pagado;
	}
}
