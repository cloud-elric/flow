<?php

namespace app\controllers;

use Yii;
use app\models\EntHorariosAreas;
use app\models\EntHorariosAreasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CatAreas;
use yii\helpers\Json;
use app\modules\ModUsuarios\models\Utils;
use app\models\Calendario;
use app\models\EntCitas;
use yii\db\Expression;
use app\models\Constantes;

/**
 * HorariosAreasController implements the CRUD actions for EntHorariosAreas model.
 */
class HorariosAreasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntHorariosAreas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntHorariosAreasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntHorariosAreas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntHorariosAreas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntHorariosAreas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_horario_area]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EntHorariosAreas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_horario_area]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EntHorariosAreas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EntHorariosAreas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EntHorariosAreas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntHorariosAreas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetHorariosDisponibilidadByArea($fecha = null){

        $cantidadEnviosExpress = Constantes::LIMITE_EXPRESS;
        $out = [];

        if (isset($_POST['depdrop_all_params']['entcitas-id_area']) &&
            isset($_POST['depdrop_all_params']['entcitas-fch_cita']) && 
            isset($_POST['depdrop_all_params']['entcitas-id_tipo_entrega'])) {

            $id = $_POST['depdrop_all_params']['entcitas-id_area'];
            $fecha = $_POST['depdrop_all_params']['entcitas-fch_cita'];
            $tipoEntrega = $_POST['depdrop_all_params']['entcitas-id_tipo_entrega'];

            if(!$fecha){
                echo Json::encode(['output' => $out, 'selected'=>'']);
                return;
            }
            // fch_cita id_tipo_entrega
            $numDia = Calendario::getNumberDayWeek($fecha);
            $fechaFormateada = Utils::changeFormatDateInput($fecha);

            if($tipoEntrega==2){
                $list = EntHorariosAreas::find()->andWhere(['id_area'=>$id, 'id_dia'=>7])->asArray()->all();
            }else if($tipoEntrega==1){
                $list = EntHorariosAreas::find()->andWhere(['id_area'=>$id, 'id_dia'=>$numDia])->asArray()->all();
            }

            
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $disponibilidad) {

                    $horariosOcupados = EntCitas::find()

                            ->where(new Expression('date_format(fch_cita, "%Y-%m-%d") = date_format("'.$fechaFormateada.'", "%Y-%m-%d")') )
                            ->andWhere(['id_horario'=>$disponibilidad["id_horario_area"]])->count();
                    if(($disponibilidad['num_disponibles']-$horariosOcupados)>0){
                        $out[] = [
                            'id' => $disponibilidad['id_horario_area'], 
                            'name' => $disponibilidad['txt_hora_inicial']." - ".$disponibilidad['txt_hora_final'],
                            'cantidad'=>$disponibilidad['num_disponibles']-$horariosOcupados];
                        if ($i == 0) {
                            $selected = $fecha;
                        }
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        
        echo Json::encode(['output' => $out, 'selected'=>'']);
        

    }


    
    
}
