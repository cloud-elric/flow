<?php

namespace app\models;

use Yii;
use app\modules\ModUsuarios\models\EntUsuarios;

/**
 * This is the model class for table "ent_citas".
 *
 * @property string $id_cita
 * @property string $id_tipo_tramite
 * @property string $id_equipo
 * @property string $id_sim_card
 * @property string $id_area
 * @property string $id_tipo_entrega
 * @property string $id_usuario
 * @property string $id_status
 * @property string $id_estado
 * @property string $id_envio
 * @property string $num_dias_servicio
 * @property string $txt_token
 * @property string $txt_clave_sap_equipo
 * @property string $txt_descripcion_equipo
 * @property string $txt_serie_equipo
 * @property string $txt_iccid
 * @property string $txt_imei
 * @property string $txt_telefono
 * @property string $txt_clave_sim_card
 * @property string $txt_descripcion_sim
 * @property string $txt_serie_sim_card
 * @property string $txt_nombre_completo_cliente
 * @property string $txt_numero_referencia
 * @property string $txt_numero_referencia_2
 * @property string $txt_numero_referencia_3
 * @property string $txt_calle_numero
 * @property string $txt_colonia
 * @property string $txt_codigo_postal
 * @property string $txt_municipio
 * @property string $txt_entre_calles
 * @property string $txt_observaciones_punto_referencia
 * @property string $txt_motivo_cancelacion
 * @property string $fch_cita
 * @property string $fch_hora_cita
 *
 * @property CatAreas $idArea
 * @property CatEquipos $idEquipo
 * @property CatEstados $idEstado
 * @property CatSimsCards $idSimCard
 * @property CatStatusCitas $idStatus
 * @property CatTiposEntrega $idTipoEntrega
 * @property CatTiposTramites $idTipoTramite
 * @property EntEnvios $idEnvio
 * @property ModUsuariosEntUsuarios $idUsuario
 * @property EntHistorialCambiosCitas[] $entHistorialCambiosCitas
 */
class EntCitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ent_citas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_tramite','id_estado', 'id_area', 'id_tipo_entrega', 'id_usuario', 'id_status', 'num_dias_servicio', 'txt_token', 'txt_iccid', 'txt_imei', 'txt_telefono', 'txt_nombre_completo_cliente', 'txt_numero_referencia', 'txt_calle_numero', 'txt_colonia', 'txt_codigo_postal', 'txt_municipio', 'txt_entre_calles', 'txt_observaciones_punto_referencia', 'fch_hora_cita'], 'required'],
            [['id_tipo_tramite', 'id_equipo', 'id_sim_card', 'id_area', 'id_tipo_entrega', 'id_usuario', 'id_status', 'id_estado', 'id_envio'], 'integer'],
            [['fch_cita'], 'safe'],
            [['num_dias_servicio', 'fch_hora_cita'], 'string', 'max' => 50],
            [['txt_token'], 'string', 'max' => 60],
            [['txt_clave_sap_equipo', 'txt_clave_sim_card', 'txt_nombre_completo_cliente'], 'string', 'max' => 200],
            [['txt_descripcion_equipo', 'txt_descripcion_sim', 'txt_entre_calles', 'txt_observaciones_punto_referencia'], 'string', 'max' => 500],
            [['txt_serie_equipo', 'txt_iccid', 'txt_imei', 'txt_serie_sim_card', 'txt_calle_numero'], 'string', 'max' => 150],
            [['txt_telefono', 'txt_numero_referencia', 'txt_numero_referencia_2', 'txt_numero_referencia_3'], 'string', 'max' => 20],
            [['txt_colonia', 'txt_municipio'], 'string', 'max' => 100],
            [['txt_codigo_postal'], 'string', 'max' => 5],
            [['txt_motivo_cancelacion'], 'string', 'max' => 700],
            [['txt_token'], 'unique'],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => CatAreas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_equipo'], 'exist', 'skipOnError' => true, 'targetClass' => CatEquipos::className(), 'targetAttribute' => ['id_equipo' => 'id_equipo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => CatEstados::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_sim_card'], 'exist', 'skipOnError' => true, 'targetClass' => CatSimsCards::className(), 'targetAttribute' => ['id_sim_card' => 'id_sim_card']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => CatStatusCitas::className(), 'targetAttribute' => ['id_status' => 'id_statu_cita']],
            [['id_tipo_entrega'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposEntrega::className(), 'targetAttribute' => ['id_tipo_entrega' => 'id_tipo_entrega']],
            [['id_tipo_tramite'], 'exist', 'skipOnError' => true, 'targetClass' => CatTiposTramites::className(), 'targetAttribute' => ['id_tipo_tramite' => 'id_tramite']],
            [['id_envio'], 'exist', 'skipOnError' => true, 'targetClass' => EntEnvios::className(), 'targetAttribute' => ['id_envio' => 'id_envio']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => EntUsuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_cita' => 'Id Cita',

            'id_tipo_tramite' => 'Tipo de Tramite',
            'id_equipo' => 'Equipo',
            'id_sim_card' => 'Sim Card',
            'id_area' => 'Area',
            'id_tipo_entrega' => 'Tipo de Entrega',
            'id_usuario' => 'Usuario',
            'id_status' => 'Status',
            'id_estado' => 'Estado',
            'id_envio' => 'Envio',
            'num_dias_servicio' => 'Dias de Servicio',
            'txt_token' => 'Txt Token',
            'txt_clave_sap_equipo' => 'Clave SAP equipo',
            'txt_descripcion_equipo' => 'Descripción Equipo',
            'txt_serie_equipo' => 'Serie equipo',
            'txt_telefono' => 'Teléfono',
            'txt_clave_sim_card' => 'Clave SAP SIM Card',
            'txt_descripcion_sim' => 'Descripción SIM Card',
            'txt_serie_sim_card' => 'Serie SIM Card',
            'txt_nombre_completo_cliente' => 'Nombre y apellidos del cliente',
            'txt_numero_referencia' => 'Télefono de referencia',
            'txt_numero_referencia_2' => 'Télefono de referencia 2',
            'txt_numero_referencia_3' => 'Télefono de referencia 3',
            'txt_calle_numero' => 'Dirección (calle, número exterior y número interior)',
            'txt_colonia' => 'Colonia',
            'txt_codigo_postal' => 'Código postal',
            'txt_municipio' => 'Municipio',
            'txt_entre_calles' => 'Entre calles',
            'txt_observaciones_punto_referencia' => 'Observaciones o punto referencia',
            'fch_cita' => 'Fecha de la cita',
            'fch_hora_cita' => 'Hora de la cita',
            'txt_iccid'=>'ICCID',
            'txt_imei'=>'IMEI',
            'id_status'=>'Estatus de la cita',
            'txt_motivo_cancelacion'=>'Motivo de rechazo',
            'id_estado'=>'Estado de la república'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(CatAreas::className(), ['id_area' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipo()
    {
        return $this->hasOne(CatEquipos::className(), ['id_equipo' => 'id_equipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstado()
    {
        return $this->hasOne(CatEstados::className(), ['id_estado' => 'id_estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSimCard()
    {
        return $this->hasOne(CatSimsCards::className(), ['id_sim_card' => 'id_sim_card']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(CatStatusCitas::className(), ['id_statu_cita' => 'id_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEntrega()
    {
        return $this->hasOne(CatTiposEntrega::className(), ['id_tipo_entrega' => 'id_tipo_entrega']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoTramite()
    {
        return $this->hasOne(CatTiposTramites::className(), ['id_tramite' => 'id_tipo_tramite']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEnvio()
    {
        return $this->hasOne(EntEnvios::className(), ['id_envio' => 'id_envio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(ModUsuariosEntUsuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntHistorialCambiosCitas()
    {
        return $this->hasMany(EntHistorialCambiosCitas::className(), ['id_cita' => 'id_cita']);
    }
}
