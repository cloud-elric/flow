<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_supervisor_cita_express".
 *
 * @property string $id_usuario
 * @property string $id_cita
 * @property string $fch_autorizacion
 *
 * @property EntCitas $idCita
 * @property ModUsuariosEntUsuarios $idUsuario
 */
class RelSupervisorCitaExpress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_supervisor_cita_express';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_cita'], 'required'],
            [['id_usuario', 'id_cita'], 'integer'],
            [['fch_autorizacion'], 'safe'],
            [['id_cita'], 'exist', 'skipOnError' => true, 'targetClass' => EntCitas::className(), 'targetAttribute' => ['id_cita' => 'id_cita']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => ModUsuariosEntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_cita' => 'Id Cita',
            'fch_autorizacion' => 'Fch Autorizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCita()
    {
        return $this->hasOne(EntCitas::className(), ['id_cita' => 'id_cita']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }
}
