<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ent_horarios_areas".
 *
 * @property string $id_horario_area
 * @property string $id_area
 * @property string $txt_hora_inicial
 * @property string $txt_hora_final
 *
 * @property CatAreas $idArea
 */
class EntHorariosAreas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_horarios_areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_area', 'txt_hora_inicial', 'txt_hora_final'], 'required'],
            [['id_area'], 'integer'],
            [['txt_hora_inicial', 'txt_hora_final'], 'string', 'max' => 50],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_horario_area' => 'Id Horario Area',
            'id_area' => 'Id Area',
            'txt_hora_inicial' => 'Txt Hora Inicial',
            'txt_hora_final' => 'Txt Hora Final',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(CatAreas::className(), ['id_area' => 'id_area']);
    }

    public function getHorario(){
        return $this->txt_hora_inicial." - ".$this->txt_hora_final;
    }
}
