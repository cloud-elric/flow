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
use app\models\Helpers;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\widgets\ActiveForm;

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

        $model = new EntCitas(['scenario'=>'create']);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if(isset($_POST['EntCitas']["id_cita"])){

            $idCita = $_POST['EntCitas']["id_cita"];
            
            $model = EntCitas::find($idCita)->one();
            $model->scenario = "create";
        }

        $usuario = Yii::$app->user->identity;

        $model->id_usuario = $usuario->id_usuario;
        $model->id_status = Constantes::PROCESO_VALIDACION;
        $camposGuardar = $_POST;
        if ($model->load(Yii::$app->request->post())){
            
            
            $model->fch_nacimiento = Utils::changeFormatDateInput($model->fch_nacimiento);
            
            if($model->save()){

                $this->guardarHistorial($usuario->id_usuario, $model->id_cita, "Cita en proceso de autorización de crédito");

                return $this->redirect(['index']);
                //return $this->redirect(['view', 'token' => $model->txt_token]);
            }else{
                print_r($model->errors);
                exit;
            }

            
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    public function actionFormPassSupervisor(){
        $supervisores = EntUsuarios::find()->where(["txt_auth_item"=>"supervisor-call-center"])->orderBy('txt_username, txt_apellido_paterno')->all();

        return $this->renderAjax('form-pass-supervisor', ['supervisores'=>$supervisores]);
    }

    public function actionValidarPassSupervisor(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['status'] = 'error';
        $respuesta['mensaje'] = 'Usuario y/o contraseña incorrecto';
        if(isset($_POST['id_supervisor']) && isset($_POST['password-supervisor'])){
            $usuario = $_POST['id_supervisor'];
            $password = $_POST['password-supervisor'];
            $supervisor = EntUsuarios::find()->where(["id_usuario"=>$usuario])->one();

            if($supervisor){
                if (Yii::$app->getSecurity()->validatePassword($password, $supervisor->txt_password_hash)) {
                    $respuesta['status'] = 'success';
                    $respuesta['mensaje'] = $supervisor->txt_token;
                }
            }

        }

        return $respuesta;
        
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

            $horario = EntHorariosAreas::findOne($citaAValidar->id_horario);
            $citaAValidar->fch_hora_cita = $horario->txt_hora_inicial." - ". $horario->txt_hora_final;
           
            $citaAValidar->fch_nacimiento = Utils::changeFormatDateInput($citaAValidar->fch_nacimiento);

            $citaAValidar->fch_cita = Utils::changeFormatDateInput($citaAValidar->fch_cita);

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

        date_default_timezone_set('America/Mexico_City');
        $citaAValidar->fch_cita = Helpers::getFechaEntrega(Utils::getFechaActual());
        $citaAValidar->fch_cita = Utils::changeFormatDate($citaAValidar->fch_cita);
        
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

    public function actionVerCita($token=null){

        $cita = EntCitas::find()->where(['txt_token'=>$token])->one();

        if($cita->id_status==Constantes::PROCESO_VALIDACION){
            return $this->redirect(['validar-credito', 'token'=>$cita->txt_token]);
        }else{
            return $this->redirect(['view', 'token'=>$cita->txt_token]);
        }

    }
    public function actionGenerarRegistro($tel=null){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $usuario = Yii::$app->user->identity;
        $status = 9;

        $respuesta['status'] = 'error';
        $respuesta['mensaje'] = 'No se puede generar el registro con un número teléfonico repetido';
        
        $cita = new EntCitas(['scenario'=>'createRegistro']);
        $cita->txt_telefono = $tel;
        $cita->txt_token = Utils::generateToken("cit_");
        $cita->id_usuario = $usuario->id_usuario;
        $cita->id_status = $status;
        if(!$cita->save()){
            //print_r($cita->errors);
        }else{
            $respuesta['status'] = 'success';
            $respuesta['mensaje']= 'Registro guardado';
            $respuesta['identificador'] = $cita->id_cita;
        }
        

        return $respuesta;

    }

}
