<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntCitas;

/**
 * EntCitasSearch represents the model behind the search form about `app\models\EntCitas`.
 */
class EntCitasSearch extends EntCitas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cita', 'id_tipo_tramite', 'id_equipo', 'id_sim_card', 'id_area', 'id_tipo_entrega', 'id_usuario', 'num_dias_servicio'], 'integer'],
            [['txt_token', 'txt_clave_sap_equipo', 'txt_descripcion_equipo', 'txt_serie_equipo', 'txt_telefono', 'txt_clave_sim_card', 'txt_descripcion_sim', 'txt_serie_sim_card', 'txt_nombre_completo_cliente', 'txt_numero_referencia', 'txt_numero_referencia_2', 'txt_numero_referencia_3', 'txt_calle_numero', 'txt_colonia', 'txt_codigo_postal', 'txt_municipio', 'txt_entre_calles', 'txt_observaciones_punto_referencia', 'fch_cita', 'fch_hora_cita'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EntCitas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_cita' => $this->id_cita,
            'id_tipo_tramite' => $this->id_tipo_tramite,
            'id_equipo' => $this->id_equipo,
            'id_sim_card' => $this->id_sim_card,
            'id_area' => $this->id_area,
            'id_tipo_entrega' => $this->id_tipo_entrega,
            'id_usuario' => $this->id_usuario,
            'num_dias_servicio' => $this->num_dias_servicio,
            'fch_cita' => $this->fch_cita,
        ]);

        $query->andFilterWhere(['like', 'txt_token', $this->txt_token])
            ->andFilterWhere(['like', 'txt_clave_sap_equipo', $this->txt_clave_sap_equipo])
            ->andFilterWhere(['like', 'txt_descripcion_equipo', $this->txt_descripcion_equipo])
            ->andFilterWhere(['like', 'txt_serie_equipo', $this->txt_serie_equipo])
            ->andFilterWhere(['like', 'txt_telefono', $this->txt_telefono])
            ->andFilterWhere(['like', 'txt_clave_sim_card', $this->txt_clave_sim_card])
            ->andFilterWhere(['like', 'txt_descripcion_sim', $this->txt_descripcion_sim])
            ->andFilterWhere(['like', 'txt_serie_sim_card', $this->txt_serie_sim_card])
            ->andFilterWhere(['like', 'txt_nombre_completo_cliente', $this->txt_nombre_completo_cliente])
            ->andFilterWhere(['like', 'txt_numero_referencia', $this->txt_numero_referencia])
            ->andFilterWhere(['like', 'txt_numero_referencia_2', $this->txt_numero_referencia_2])
            ->andFilterWhere(['like', 'txt_numero_referencia_3', $this->txt_numero_referencia_3])
            ->andFilterWhere(['like', 'txt_calle_numero', $this->txt_calle_numero])
            ->andFilterWhere(['like', 'txt_colonia', $this->txt_colonia])
            ->andFilterWhere(['like', 'txt_codigo_postal', $this->txt_codigo_postal])
            ->andFilterWhere(['like', 'txt_municipio', $this->txt_municipio])
            ->andFilterWhere(['like', 'txt_entre_calles', $this->txt_entre_calles])
            ->andFilterWhere(['like', 'txt_observaciones_punto_referencia', $this->txt_observaciones_punto_referencia])
            ->andFilterWhere(['like', 'fch_hora_cita', $this->fch_hora_cita]);

        return $dataProvider;
    }
}
