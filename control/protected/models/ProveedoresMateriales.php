<?php

/**
 * This is the model class for table "proveedores_materiales".
 *
 * The followings are the available columns in table 'proveedores_materiales':
 * @property integer $id
 * @property integer $id_provedores
 * @property integer $id_tipos_articulos_inventario
 * @property integer $id_articulo
 *
 * The followings are the available model relations:
 * @property Provedores $idProvedores
 * @property TiposArticulosInventario $idTiposArticulosInventario
 */
class ProveedoresMateriales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'proveedores_materiales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_provedores, id_tipos_articulos_inventario, id_articulo', 'required'),
			array('id_provedores, id_tipos_articulos_inventario, id_articulo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_provedores, id_tipos_articulos_inventario, id_articulo', 'safe', 'on'=>'search'),
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
			'proveedor' => array(self::BELONGS_TO, 'Provedores', 'id_provedores'),
			'tiposArticulosInventario' => array(self::BELONGS_TO, 'TiposArticulosInventario', 'id_tipos_articulos_inventario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_provedores' => 'Proveedor',
			'id_tipos_articulos_inventario' => 'Tipo Artículo',
			'id_articulo' => 'Artículo',
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
		$criteria->compare('id_provedores',$this->id_provedores);
		$criteria->compare('id_tipos_articulos_inventario',$this->id_tipos_articulos_inventario);
		$criteria->compare('id_articulo',$this->id_articulo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProveedoresMateriales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
