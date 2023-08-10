<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "{{%libros}}".
 *
 * @property int $lb_codigo
 * @property string $lb_titulo
 * @property string $imagen
 * @property string $id_format
 */
class Libro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $archivo;
    public static function tableName()
    {
        return '{{%libros}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lb_titulo'], 'required'],
            [['lb_titulo'], 'string', 'max' => 255],
            [['archivo'],'file', 'extensions'=> 'jpg,png,jpeg'],
            [['id_format'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lb_codigo' => 'lb_codigo',
            'lb_titulo' => 'lb_titulo',
            'archivo' => 'Imagen',
            'id_format' => 'id_format',
        ];
    }
}
