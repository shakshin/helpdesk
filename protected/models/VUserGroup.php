<?php

/**
 * This is the model class for table "v_user_group".
 *
 * The followings are the available columns in table 'v_user_group':
 * @property string $user_id
 * @property string $login
 * @property string $group_id
 * @property string $groupname
 */
class VUserGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VUserGroup the static model class
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
		return 'v_user_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login', 'required'),
			array('user_id, group_id', 'length', 'max'=>10),
			array('login', 'length', 'max'=>20),
			array('groupname', 'length', 'max'=>64),
			array('jabber', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, login, group_id, groupname, jabber', 'safe', 'on'=>'search'),
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
			'user_id' => 'User ID',
			'login' => 'Login',
			'jabber' => 'Jabber',
			'group_id' => 'Group ID',
			'groupname' => 'Groupname',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('jabber',$this->jabber,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('groupname',$this->groupname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}