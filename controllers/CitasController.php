<?php

namespace app\controllers;

use Yii;
use app\models\EntCitas;
use app\models\EntCitasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CatAreas;
use app\modules\ModUsuarios\models\Utils;
use app\components\AccessControlExtend;
use app\models\EntHorariosAreas;
use app\models\EntEnvios;
use \yii\web\Response;

/**
 * CitasController implements the CRUD actions for EntCitas model.
 */
class CitasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
             'access' => [
                 'class' => AccessControlExtend::className(),
                 'only' => ['index', 'create', 'update', 'delete'],
                 'rules' => [
                     [
                         'actions' => ['create', 'index', 'update'],
                         'allow' => true,
                         'roles' => [\Yii::$app->params ['roles'] ['ejecutivoTelcel']],
                     ],
                   
                 ],
             ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * Lists all EntCitas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntCitasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntCitas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($token)
    {
        $model = EntCitas::find()->where(['txt_token'=>$token])->one();
        $area = CatAreas::find()->one();
        $horarios = $area->entHorariosAreas;        

        return $this->render('view', [
            'model' => $model,
            'area' => $area,
            'horarios'=>$horarios
        ]);
    }

    /**
     * Creates a new EntCitas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntCitas();
        $area = CatAreas::find()->one();
        $usuario = Yii::$app->user->identity;

        //$model->id_area = $area->id_area;
        //$model->num_dias_servicio = '';
        //$model->id_tipo_entrega = $area->id_tipo_entrega;
        $model->id_usuario = $usuario->id_usuario;
        $model->id_status = 1;

        $horarios = $area->entHorariosAreas;
        $model->txt_token = Utils::generateToken("cit_");
        
        if ($model->load(Yii::$app->request->post())){
            $model->fch_cita = Utils::changeFormatDateInput($model->fch_cita);
            $horario = EntHorariosAreas::findOne($model->fch_hora_cita);
            $model->fch_hora_cita = $horario->horario;
            if($model->save()){
                return $this->redirect(['view', 'token' => $model->txt_token]);
            }

            $model->fch_cita = Utils::changeFormatDate($model->fch_cita);
            $model->fch_hora_cita = $horario->id_horario_area;
            
        } 

        return $this->render('create', [
            'model' => $model,
            'area' => $area,
            'horarios'=>$horarios
        ]);
        
    }

    /**
     * Updates an existing EntCitas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($token)
    {
        $model = $this->findModel(['txt_token' => $token]);
        $area = CatAreas::find()->one();
        $horarios = $area->entHorariosAreas;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                'model' => $model,
                'area' => $area,
                'horarios'=>$horarios
            ]);
        }
    }

    /**
     * Deletes an existing EntCitas model.
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
     * Finds the EntCitas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EntCitas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntCitas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAutorizar($token = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $statusAutorizar = 3;
        $cita = $this->findModel(['txt_token' => $token]);

        if(!$cita->id_envio){
            $envio = new EntEnvios();
            $envio->txt_token = Utils::generateToken("env_");
            
            if ($envio->save()) {

                $cita->id_status = $statusAutorizar;
                $cita->id_envio = $envio->id_envio;
                $cita->txt_motivo_cancelacion = '';
                

                if($cita->save()){
                 return ['status'=>'ok', 'envio'=>$envio->txt_token];
                }
            }

        }

        return ['status'=>'error'];
    }

    public function actionRechazar($token=null)
    {
        $statusRechazar = 4;
        $cita = $this->findModel(['txt_token' => $token]);
        
        if($cita && $cita->load(Yii::$app->request->post())){
            $cita->txt_motivo_cancelacion = $_POST['EntCitas']['txt_motivo_cancelacion'];
            $cita->id_status = $statusRechazar;
            if ($cita->save()) {
    
                return $this->redirect( ['view',
                    'token' => $token,
                ]);
            }
        }
       
    }

    public function actionCancelar()
    {
        $statusCancelar = 5;
        $cita = $this->findModel(['txt_token' => $token]);
        
        if($cita && $cita->load(Yii::$app->request->post())){
            $cita->txt_motivo_cancelacion = $_POST['EntCitas']['txt_motivo_cancelacion'];
            $cita->id_status = $statusRechazar;
            if ($cita->save()) {
    
                return $this->redirect( ['view',
                    'token' => $token,
                ]);
            }
        }
       
    }
}
