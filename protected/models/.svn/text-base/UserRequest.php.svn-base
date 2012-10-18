<?php

/**
 * This is the model class for table "request".
 *
 * The followings are the available columns in table 'request':
 * @property string $id
 * @property string $atl_lastdatetime
 * @property string $atl_lastuser
 * @property string $type_request_id
 * @property string $request_datetime
 * @property string $who_ip
 * @property string $request_user_id
 * @property string $date_plan
 * @property string $date_end
 * @property string $department
 * @property string $position
 * @property string $fio
 * @property string $phone
 * @property string $pc
 * @property string $description
 * @property string $closed
 */
class UserRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserRequest the static model class
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
		return 'request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('atl_lastdatetime, atl_lastuser, type_request_id, who_ip, request_user_id, department, fio, phone', 'required'),
			array('atl_lastuser, type_request_id, request_user_id, closed', 'length', 'max'=>10),
			array('who_ip, phone', 'length', 'max'=>32),
			array('department', 'length', 'max'=>200),
			array('position, fio', 'length', 'max'=>100),
			array('pc', 'length', 'max'=>64),
			array('request_datetime, date_plan, date_end, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, atl_lastdatetime, atl_lastuser, type_request_id, request_datetime, who_ip, request_user_id, date_plan, date_end, department, position, fio, phone, pc, description, closed', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'atl_lastdatetime' => 'Atl Lastdatetime',
			'atl_lastuser' => 'Atl Lastuser',
			'type_request_id' => 'Type Request',
			'request_datetime' => 'Request Datetime',
			'who_ip' => 'Who Ip',
			'request_user_id' => 'Request User',
			'date_plan' => 'Date Plan',
			'date_end' => 'Date End',
			'department' => 'Department',
			'position' => 'Position',
			'fio' => 'Fio',
			'phone' => 'Phone',
			'pc' => 'Pc',
			'description' => 'Description',
			'closed' => 'Closed',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('atl_lastdatetime',$this->atl_lastdatetime,true);
		$criteria->compare('atl_lastuser',$this->atl_lastuser,true);
		$criteria->compare('type_request_id',$this->type_request_id,true);
		$criteria->compare('request_datetime',$this->request_datetime,true);
		$criteria->compare('who_ip',$this->who_ip,true);
		$criteria->compare('request_user_id',$this->request_user_id,true);
		$criteria->compare('date_plan',$this->date_plan,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('pc',$this->pc,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('closed',$this->closed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}