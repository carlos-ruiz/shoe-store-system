<?php

/**
 * This is the model class for table "modelos_materiales_predeterminados".
 *
 * The followings are the available columns in table 'modelos_materiales_predeterminados':
 * @property integer $id
 * @property integer $id_modelos_colores
 * @property integer $id_suelas_colores
 * @property integer $id_tacones_colores
 * @property integer $id_ojillos_colores
 * @property integer $id_agujetas_colores
 *
 * The followings are the available model relations:
 * @property AgujetasColores $idAgujetasColores
 * @property ModelosColores $idModelosColores
 * @property OjillosColores $idOjillosColores
 * @property SuelasColores $idSuelasColores
 * @property TaconesColores $idTaconesColores
 */
class ModelosMaterialesPredeterminados extends CActiveRecord
{
	public $id_modelos;
	public $id_color_modelo;
	public $id_suelas;
	public $id_color_suela;
	public $id_tacones;
	public $id_color_tacon;
	public $id_agujetas;
	public $id_color_agujetas;
	public $id_ojillos;
	public $id_color_ojillos;

	public $var_modelos;
	public $var_color_modelo;
	public $var_suelas;
	public $var_color_suela;
	public $var_tacones;
	public $var_color_tacon;
	public $var_agujetas;
	public $var_color_agujetas;
	public $var_ojillos;
	public $var_color_ojillos;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modelos_materiales_predeterminados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modelos_colores, id_suelas_colores', 'required'),
			array('id_modelos, id_color_modelo, id_suelas, id_color_suela', 'required', 'on'=>'nuevo'),
			array('id_modelos_colores, id_suelas_colores, id_tacones_colores, id_ojillos_colores, id_agujetas_colores', 'numerical', 'integerOnly'=>true),
			array('id_modelos, id_color_modelo, id_suelas, id_color_suela, id_tacones, id_color_tacon, id_agujetas, id_color_agujetas, id_ojillos, id_color_ojillos', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_modelos_colores, id_suelas_colores, id_tacones_colores, id_ojillos_colores, id_agujetas_colores, id_modelos, id_color_modelo, id_suelas, id_color_suela, id_tacones, id_color_tacon, id_agujetas, id_color_agujetas, id_ojillos, id_color_ojillos, var_modelos, var_color_modelo, var_suelas, var_color_suela, var_tacones, var_color_tacon, var_agujetas, var_color_agujetas, var_ojillos, var_color_ojillos', 'safe', 'on'=>'search'),
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
			'agujetaColor' => array(self::BELONGS_TO, 'AgujetasColores', 'id_agujetas_colores'),
			'modeloColor' => array(self::BELONGS_TO, 'ModelosColores', 'id_modelos_colores'),
			'ojillosColor' => array(self::BELONGS_TO, 'OjillosColores', 'id_ojillos_colores'),
			'suelaColor' => array(self::BELONGS_TO, 'SuelasColores', 'id_suelas_colores'),
			'taconColor' => array(self::BELONGS_TO, 'TaconesColores', 'id_tacones_colores'),
			'materialesColoresPredeterminados' => array(self::HAS_MANY, 'MaterialesColoresPredeterminados', 'id_modelos_materiales_predeterminados'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_modelos_colores' => 'Id Modelos Colores',
			'id_suelas_colores' => 'Id Suelas Colores',
			'id_tacones_colores' => 'Id Tacones Colores',
			'id_ojillos_colores' => 'Id Ojillos Colores',
			'id_agujetas_colores' => 'Id Agujetas Colores',
			'id_modelos'=>'Modelo',
			'id_color_modelo'=>'Color de modelo',
			'id_suelas'=>'Suela',
			'id_color_suela'=>'Color de suela',
			'id_tacones'=>'Tacón',
			'id_color_tacon'=>'Color de tacón',
			'id_agujetas'=>'Agujetas',
			'id_color_agujetas'=>'Color de agujetas',
			'id_ojillos'=>'Ojillos',
			'id_color_ojillos'=>'Color de ojillos',
			'var_modelos'=>'Modelo',
			'var_color_modelo'=>'Color de modelo',
			'var_suelas'=>'Suela',
			'var_color_suela'=>'Color de suela',
			'var_tacones'=>'Tacón',
			'var_color_tacon'=>'Color de tacón',
			'var_agujetas'=>'Agujetas',
			'var_color_agujetas'=>'Color de agujetas',
			'var_ojillos'=>'Ojillos',
			'var_color_ojillos'=>'Color de ojillos',
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
		$criteria->compare('id_modelos_colores',$this->id_modelos_colores);
		$criteria->compare('id_suelas_colores',$this->id_suelas_colores);
		$criteria->compare('id_tacones_colores',$this->id_tacones_colores);
		$criteria->compare('id_ojillos_colores',$this->id_ojillos_colores);
		$criteria->compare('id_agujetas_colores',$this->id_agujetas_colores);
		$criteria->with = array('agujetaColor.agujeta', 'suelaColor.suela', 'modeloColor.modelo', 'taconColor.tacon', 'ojillosColor.ojillo', 
			"suelaColor.color" => array(
			    'alias' => 'scolor'
			),
			"agujetaColor.color" => array(
			    'alias' => 'acolor'
			),
			"modeloColor.color" => array(
			    'alias' => 'mcolor'
			),
			"ojillosColor.color" => array(
			    'alias' => 'ocolor'
			),
			"taconColor.color" => array(
			    'alias' => 'tcolor'
			)
		);
		$criteria->compare('suela.nombre',$this->var_suelas, true);
		$criteria->compare('modelo.nombre',$this->var_modelos, true);
		$criteria->compare('tacon.nombre',$this->var_tacones, true);
		$criteria->compare('agujeta.nombre',$this->var_agujetas, true);
		$criteria->compare('ojillo.nombre',$this->var_ojillos, true);
		$criteria->compare('tcolor.color',$this->var_color_tacon, true);
		$criteria->compare('ocolor.color',$this->var_color_ojillos, true);
		$criteria->compare('mcolor.color',$this->var_color_modelo, true);
		$criteria->compare('acolor.color',$this->var_color_agujetas, true);
		$criteria->compare('scolor.color',$this->var_color_suela, true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
		        'attributes'=>array(
		        	'var_modelos'=>array(
		                'asc'=>'modelo.nombre',
		                'desc'=>'modelo.nombre DESC',
		            ),
		            'var_color_modelo'=>array(
		                'asc'=>'mcolor.color',
		                'desc'=>'mcolor.color DESC',
		            ),
		            'var_suelas'=>array(
		                'asc'=>'suela.nombre',
		                'desc'=>'suela.nombre DESC',
		            ),
		            'var_color_suela'=>array(
		                'asc'=>'scolor.color',
		                'desc'=>'scolor.color DESC',
		            ),
		            'var_tacones'=>array(
		                'asc'=>'tacon.nombre',
		                'desc'=>'tacon.nombre DESC',
		            ),
		            'var_color_tacon'=>array(
		                'asc'=>'tcolor.color',
		                'desc'=>'tcolor.color DESC',
		            ),

		            'var_agujetas'=>array(
		                'asc'=>'agujeta.nombre',
		                'desc'=>'agujeta.nombre DESC',
		            ),
		            'var_color_agujetas'=>array(
		                'asc'=>'acolor.color',
		                'desc'=>'acolor.color DESC',
		            ),
		            'var_ojillos'=>array(
		                'asc'=>'ojillo.nombre',
		                'desc'=>'ojillo.nombre DESC',
		            ),
		            'var_color_ojillos'=>array(
		                'asc'=>'ocolor.color',
		                'desc'=>'ocolor.color DESC',
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
	 * @return ModelosMaterialesPredeterminados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
