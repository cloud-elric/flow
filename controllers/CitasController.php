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
use app\models\CatColonias;
use app\models\Constantes;
use app\models\EntHistorialCambiosCitas;

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
        
        $model->fch_nacimiento = Utils::changeFormatDate($model->fch_nacimiento);

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
        $model = new EntCitas(['scenario' => 'create']);
        
        $usuario = Yii::$app->user->identity;

        $model->id_usuario = $usuario->id_usuario;
        $model->id_status = Constantes::PROCESO_VALIDACION;

        $model->txt_token = Utils::generateToken("cit_");
        
        if ($model->load(Yii::$app->request->post())){
            
            $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);
            
            // $colonia = CatColonias::findOne($model->txt_colonia);
            // $model->txt_colonia = $colonia->txt_nombre;
            //$model->fch_hora_cita = $horario->horario;
            if($model->save()){

                $this->guardarHistorial($usuario->id_usuario, $model->id_cita, "Cita en proceso de autorización de crédito");

                return $this->redirect(['index']);
                //return $this->redirect(['view', 'token' => $model->txt_token]);
            }else{
                //print_r($model->errors);
                exit;
            }

            // $model->fch_cita = Utils::changeFormatDate($model->fch_cita);
            // $model->fch_hora_cita = $horario->id_horario_area;
            
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    public function actionValidarCredito($token=null){
        $usuario = Yii::$app->user->identity;
        $citaAValidar = EntCitas::findOne(['txt_token'=>$token]);
        $citaAValidar->id_usuario = $usuario->id_usuario;
        $citaAValidar->scenario = 'aprobar';
        $citaAValidar->fch_nacimiento = Utils::changeFormatDate($citaAValidar->fch_nacimiento);

        if ($citaAValidar->load(Yii::$app->request->post())){

            $colonia = CatColonias::findOne($citaAValidar->txt_colonia);
            $citaAValidar->txt_colonia = $colonia->txt_nombre;
            
            $citaAValidar->fch_nacimiento = Utils::changeFormatDateInput($citaAValidar->fch_nacimiento);
            if($citaAValidar->txt_imei){
                $citaAValidar->id_status = Constantes::CONTRATO_AUTORIZADO;
            }else{
                $citaAValidar->id_status = Constantes::CONTRATO_AUTORIZADO_SIN_IMEI;
            }
            
            if($citaAValidar->save()){
                $this->guardarHistorial($usuario->id_usuario, $citaAValidar->id_cita, "Cita con crédito autorizado");
                return $this->redirect(['index']);
                //return $this->redirect(['view', 'token' => $model->txt_token]);
            }else{
                print_r($citaAValidar->errors);
                exit;
            }
        } 

        return $this->render('validar-credito', [
            'model' => $citaAValidar,
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

        if ($model->load(Yii::$app->request->post())){
            $colonia = CatColonias::findOne($model->txt_colonia);
            $model->txt_colonia = $colonia->txt_nombre;
            if($model->save()){
                return $this->render('view', [
                    'model' => $model,
                    'area' => $area
                ]);
            }
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
        $statusAutorizar = Constantes::AUTORIZADO_POR_SUPERVISOR;
        $cita = $this->findModel(['txt_token' => $token]);

        if(!$cita->id_envio){
            $envio = new EntEnvios();
            $envio->txt_token = Utils::generateToken("env_");
            
            if ($envio->save()) {
                
                $cita->id_status = $statusAutorizar;
                $cita->id_envio = $envio->id_envio;
                $cita->txt_motivo_cancelacion = '';
                

                if($cita->save()){
                    $this->guardarHistorial($usuario->id_usuario, $cita->id_cita, "Cita autorizada por supervisor");
                    return ['status'=>'ok', 'envio'=>$envio->txt_token];
                }
            }

        }else{
            return ['status'=>'tiene envio'];
        }

        return ['status'=>'error'];
    }

    public function actionRechazar($token=null)
    {
        $usuario = Yii::$app->user->identity;
        $statusRechazar = Constantes::RECHAZADA;
        $cita = $this->findModel(['txt_token' => $token]);
        
        if($cita && $cita->load(Yii::$app->request->post())){
            $cita->txt_motivo_cancelacion = $_POST['EntCitas']['txt_motivo_cancelacion'];
            $cita->id_status = $statusRechazar;
            if ($cita->save()) {
                $this->guardarHistorial($usuario->id_usuario, $cita->id_cita, "Cita rechazada");
                return $this->redirect( ['view',
                    'token' => $token,
                ]);
            }
        }
       
    }

    public function actionCancelar()
    {
        $usuario = Yii::$app->user->identity;
        $statusCancelar = Constantes::CANCELADA;
        $cita = $this->findModel(['txt_token' => $token]);
        
        if($cita && $cita->load(Yii::$app->request->post())){
            $cita->txt_motivo_cancelacion = $_POST['EntCitas']['txt_motivo_cancelacion'];
            $cita->id_status = $statusRechazar;
            if ($cita->save()) {
                $this->guardarHistorial($usuario->id_usuario, $cita->id_cita, "Cita cancelada");
                return $this->redirect( ['view',
                    'token' => $token,
                ]);
            }
        }
       
    }

    public function guardarHistorial($id_usuario, $id_cita, $comentario){
        $historial = new EntHistorialCambiosCitas();
        $historial->id_usuario = $id_usuario;
        $historial->id_cita = $id_cita;
        $historial->txt_modificacion = $comentario;

        $historial->save();

    }
}
