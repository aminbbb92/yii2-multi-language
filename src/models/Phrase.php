<?php
/**
 * Created by aminbbb92.
 * @project    Yii2 Multi Language
 * @author     Phuong
 * @email      phuong17889[at]gmail.com
 * @created    04/02/2016 1:48 SA
 * @updated    03/03/2016 00:40 SA
 * @since      2.0.0
 */

namespace aminbbb92\language\models;

use kartik\editable\Editable;
use kartik\popover\PopoverX;
use aminbbb92\language\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "phrase".
 *
 * @property integer           $id
 * @property string            $name
 * @property Language[]        $languages
 * @property PhraseTranslate[] $phraseTranslates
 */
class Phrase extends ActiveRecord {

	public $_dynamicData  = [];

	public $_dynamicField = [];

	public $languages     = [];

	/**
	 * @return string the table name
	 */
	public static function tableName() {
		return '{{%phrase}}';
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that attributes and related objects can be accessed like properties.
	 *
	 * @param string $name property name
	 *
	 * @throws \yii\base\InvalidParamException if relation name is wrong
	 * @return mixed property value
	 * @see getAttribute()
	 */
	public function __get($name) {
		if (!empty($this->_dynamicField[$name])) {
			if (!empty($this->_dynamicData[$name])) {
				return $this->_dynamicData[$name];
			} else {
				return null;
			}
		} else {
			return parent::__get($name);
		}
	}

	/**
	 * PHP setter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 *
	 * @param string $name  property name
	 * @param mixed  $value property value
	 */
	public function __set($name, $value) {
		if (!empty($this->_dynamicField[$name])) {
			$this->_dynamicData[$name] = $value;
		} else {
			parent::__set($name, $value);
		}
	}

	/**
	 * Initializes the object.
	 * This method is called at the end of the constructor.
	 * The default implementation will trigger an [[EVENT_INIT]] event.
	 * If you override this method, make sure you call the parent implementation at the end
	 * to ensure triggering of the event.
	 */
	public function init() {
		$this->languages = Language::getLanguages();
		foreach ($this->languages as $language) {
			$this->_dynamicField[$language->code] = $language->name;
		}
	}

	/**
	 * This will set dynamic field
	 * @since 1.0.0
	 */
	public function setDynamicField() {
		foreach ($this->languages as $language) {
			$set = false;
			foreach ($this->phraseTranslates as $phrase_translate) {
				if ($phrase_translate->language_id === $language->id) {
					$key        = $language->code;
					$this->$key = $phrase_translate->value;
					$set        = true;
					break;
				}
			}
			if (!$set) {
				$key        = $language->code;
				$this->$key = '';
			}
		}
	}

	/**
	 * @return array validation rules
	 * @see scenarios()
	 */
	public function rules() {
		$code = [];
		foreach ($this->languages as $language) {
			$code[] = $language->code;
		}
		return [
			[
				['name'],
				'required',
			],
			[
				['name'],
				'unique',
			],
			[
				array_merge([
					'id',
					'name',
				], $code),
				'safe',
			],
		];
	}

	/**
	 * This will return all PhraseTranslate relations of Phrase
	 * @return ActiveQuery
	 * @since 1.0.2
	 */
	public function getPhraseTranslates() {
		return $this->hasMany(PhraseTranslate::className(), ['phrase_id' => 'id']);
	}

	/**
	 * Returns the list of all attribute names of the model.
	 * The default implementation will return all column names of the table associated with this AR class.
	 * @return array list of attribute names.
	 */
	public function attributes() {
		$attributes = parent::attributes();
		return array_merge($attributes, array_keys($this->_dynamicField));
	}

	/**
	 * @return array attribute labels (name => label)
	 * @see generateAttributeLabel()
	 */
	public function attributeLabels() {
		$labels = parent::attributeLabels();
		foreach ($this->languages as $language) {
			$labels[$language->code] = $language->name;
		}
		return $labels;
	}

	/**
	 *
	 * @param $name
	 *
	 * @return int
	 * @since 1.0.0
	 */
	public static function getIdByName($name) {
		$model = self::findOne(['name' => $name]);
		if ($model) {
			return $model->id;
		} else {
			return 0;
		}
	}

	/**
	 * @return array|mixed
	 * @since 1.0.0
	 */
	public function phraseColumns() {
		$columns    = [];
		$columns[]  = ['class' => 'kartik\grid\SerialColumn'];
		$columns[]  = ['attribute' => 'name'];
		$attributes = $this->attributeLabels();
		foreach ($this->_dynamicField as $key => $value) {
			$columns[] = [
				'attribute'       => $key,
				'header'          => '<a href="#">' . $attributes[$key] . '</a>',
				'value'           => function(Phrase $model) use ($key) {
					$model->setDynamicField();
					return $model->$key;
				},
				'class'           => 'kartik\grid\EditableColumn',
				'editableOptions' => [
					'inputType' => Editable::INPUT_TEXTAREA,
					'placement' => PopoverX::ALIGN_TOP_LEFT,
					'options'   => [
						'cols' => '200',
					],
				],
			];
		}
		$columns[] = [
			'class'    => 'kartik\grid\ActionColumn',
			'template' => '{delete}',
		];
		return $columns;
	}
}
