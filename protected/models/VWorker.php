<?php

/**
 * This is the model class for table "v_worker".
 *
 * The followings are the available columns in table 'v_worker':
 * @property string $request_id
 * @property string $name
 * @property string $uid
 */
class VWorker extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VWorker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_worker';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id', 'required'),
			array('request_id', 'length', 'max'=>20),
			array('name', 'length', 'max'=>200),
			array('uid', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('request_id, name, uid', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'request_id' => 'Request',
			'name' => 'Name',
			'uid' => 'Uid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('uid',$this->uid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}