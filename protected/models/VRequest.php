<?php

/**
 * This is the model class for table "v_request".
 *
 * The followings are the available columns in table 'v_request':
 * @property string $id
 * @property string $regtime
 * @property string $department
 * @property string $position
 * @property string $fio
 * @property string $phone
 * @property string $pc
 * @property string $ip
 * @property string $description
 * @property string $closed
 * @property string $utime
 * @property string $uuser
 * @property string $rtype
 * @property string $rtype_id
 * @property string $group_full
 * @property string $group_work
 * @property string $group_view
 * @property string $date_plan
 * @property string $date_end
 * @property integer $deadline
 */
class VRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VRequest the static model class
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
		return 'v_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('department, fio, phone, ip, uuser', 'required'),
			array('deadline', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('department, rtype', 'length', 'max'=>200),
			array('position, fio', 'length', 'max'=>100),
			array('phone, ip', 'length', 'max'=>32),
			array('pc', 'length', 'max'=>64),
			array('closed, uuser, rtype_id, group_full, group_work, group_view', 'length', 'max'=>10),
			array('regtime, description, utime, date_plan, date_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, regtime, department, position, fio, phone, pc, ip, description, closed, utime, uuser, rtype, rtype_id, group_full, group_work, group_view, date_plan, date_end, deadline', 'safe', 'on'=>'search'),
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
			'regtime' => 'Regtime',
			'department' => 'Department',
			'position' => 'Position',
			'fio' => 'Fio',
			'phone' => 'Phone',
			'pc' => 'Pc',
			'ip' => 'Ip',
			'description' => 'Description',
			'closed' => 'Closed',
			'utime' => 'Utime',
			'uuser' => 'Uuser',
			'rtype' => 'Rtype',
			'rtype_id' => 'Rtype',
			'group_full' => 'Group Full',
			'group_work' => 'Group Work',
			'group_view' => 'Group View',
			'date_plan' => 'Date Plan',
			'date_end' => 'Date End',
			'deadline' => 'Deadline',
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
		$criteria->compare('regtime',$this->regtime,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('pc',$this->pc,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('closed',$this->closed,true);
		$criteria->compare('utime',$this->utime,true);
		$criteria->compare('uuser',$this->uuser,true);
		$criteria->compare('rtype',$this->rtype,true);
		$criteria->compare('rtype_id',$this->rtype_id,true);
		$criteria->compare('group_full',$this->group_full,true);
		$criteria->compare('group_work',$this->group_work,true);
		$criteria->compare('group_view',$this->group_view,true);
		$criteria->compare('date_plan',$this->date_plan,true);
		$criteria->compare('date_end',$this->date_end,true);
		$criteria->compare('deadline',$this->deadline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}