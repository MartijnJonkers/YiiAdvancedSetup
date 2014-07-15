<?php

/*
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property string $category
 * @property string $message
 */
class Text extends CActiveRecord
{
    public $language;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'text';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('category', 'length', 'max'=>32),
			array('message', 'safe'),
			array('id, category, message', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'translations'=>array(self::HAS_MANY, 'TextTranslation', 'id', 'joinType'=>'LEFT JOIN'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'category' => Yii::t(__CLASS__, 'Categorie'),
			'message' => Yii::t(__CLASS__, 'Default tekst'),
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

        $criteria->alias = 'm';
		$criteria->compare('m.id',$this->id);
		$criteria->compare('m.category',$this->category,true);
        $criteria->compare('m.message',$this->message,true);
        $criteria->with = array(
            'translations'=>array('alias'=>'t', 'on'=>'m.ID=t.id AND t.language="'.$this->language.'"'),
        );
        $criteria->together = true;

        /* exclude some categories... */
        //$criteria->compare('m.category','<>RightsModule',true);
        $criteria->compare('m.category','<>LogAnalyzer',true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pagesize'=>50,
            ),
            'sort' => array(
                'defaultOrder' => 'm.category, m.message',
                'attributes' => array(
                    'category' => array(
                        'asc' => 'm.category, m.message',
                        'desc' => 'm.category DESC, m.message DESC',
                    ),
                    'message' => array(
                        'asc' => 'm.message, m.category',
                        'desc' => 'm.message DESC, m.category DESC',
                    ),
                    'translations.translation' => array(
                        'asc' => 't.translation, m.category',
                        'desc' => 't.translation DESC, m.category DESC',
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
	 * @return Messages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
