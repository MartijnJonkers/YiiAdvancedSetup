<?php

/**
 * This is the model class for table "messages_translation".
 *
 * The followings are the available columns in table 'messages_translation':
 * @property integer $id
 * @property string $language
 * @property string $translation
 */
class TextTranslation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'text_translation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('language', 'length', 'max'=>16),
			array('translation', 'safe'),
			array('id, language, translation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'text'=>array(self::BELONGS_TO, 'Text', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'language' => Yii::t(__CLASS__, 'Doel taal'),
			'translation' => Yii::t(__CLASS__, 'Vertaling'),
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('translation',$this->translation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MessagesTranslation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
