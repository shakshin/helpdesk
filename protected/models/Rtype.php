<?php

/**
 * This is the model class for table "type_of_request".
 *
 * The followings are the available columns in table 'type_of_request':
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $group_full
 * @property string $group_work
 * @property string $group_notify
 * @property string $group_view
 * @property string $norma
 * @property double $complexity
 */
class Rtype extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Rtype the static model class
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
		return 'type_of_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('complexity', 'numerical'),
			array('name', 'length', 'max'=>200),
			array('parent_id, group_full, group_work, group_notify, group_view, norma', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent_id, group_full, group_work, group_notify, group_view, norma, complexity', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'parent_id' => 'Parent',
			'group_full' => 'Group Full',
			'group_work' => 'Group Work',
			'group_notify' => 'Group Notify',
			'group_view' => 'Group View',
			'norma' => 'Norma',
			'complexity' => 'Complexity',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('group_full',$this->group_full,true);
		$criteria->compare('group_work',$this->group_work,true);
		$criteria->compare('group_notify',$this->group_notify,true);
		$criteria->compare('group_view',$this->group_view,true);
		$criteria->compare('norma',$this->norma,true);
		$criteria->compare('complexity',$this->complexity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}