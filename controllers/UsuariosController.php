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
use app\modules\ModUsuarios\models\EntUsuariosSearch;
use app\models\AuthItem;
use app\modules\ModUsuarios\models\EntUsuarios;
use yii\widgets\ActiveForm;

/**
 * CitasController implements the CRUD actions for EntCitas model.
 */
class UsuariosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControlExtend::className(),
                'only' => ['usuarios-call-center', 'update-usuario-call-center', 'create-usuario-call-center'],
                'rules' => [
                    [
                        'actions' => ['usuarios-call-center', 'update-usuario-call-center', 'create-usuario-call-center'],
                        'allow' => true,
                        'roles' => [\Yii::$app->params['roles']['supervisorTelcel']],
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
    public function actionUsuariosCallCenter()
    {
        $searchModel = new EntUsuariosSearch();
        $dataProvider = $searchModel->searchUsuariosCallCenter(Yii::$app->request->queryParams);

        if(\Yii::$app->user->can('mesa-control')) {
            $usuariosCallCenter = AuthItem::find()->where(['not in', 'name', ['admin']])->all();
        }else if (\Yii::$app->user->can('supervisor-call-center')) {
            $usuariosCallCenter = AuthItem::find()->where(['name' => \Yii::$app->params['roles']['supervisorTelcel']])->orWhere(['name' => \Yii::$app->params['roles']['ejecutivoTelcel']])->all();
        }

        return $this->render('usuarios-call-center', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usuariosCallCenter' => $usuariosCallCenter
        ]);
    }

    public function actionCreateUsuarioCallCenter()
    {
        $model = new EntUsuarios([
            'scenario' => 'registerInput'
        ]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if(\Yii::$app->user->can('mesa-control')) {
            $usuariosCallCenter = AuthItem::find()->where(['not in', 'name', ['admin']])->all();
        }else if (\Yii::$app->user->can('supervisor-call-center')) {
            $usuariosCallCenter = AuthItem::find()->where(['name' => \Yii::$app->params['roles']['supervisorTelcel']])->orWhere(['name' => \Yii::$app->params['roles']['ejecutivoTelcel']])->all();
        }else{
            
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                $this->redirect(['update-usuario-call-center', 'id'=>$user->id_usuario]);
            }
        
        // return $this->redirect(['view', 'id' => $model->id_usuario]);

        }
        return $this->render('agregar-usuario-call-center', [
            'model' => $model,
            'usuariosCallCenter' => $usuariosCallCenter
        ]);
    }

    public function actionUpdateUsuarioCallCenter($id = null)
    {
        $usuario = EntUsuarios::findOne($id);
        $roleActual = $usuario->txt_auth_item;

        if ($usuario) {

            if(\Yii::$app->user->can('mesa-control')) {
                $usuariosCallCenter = AuthItem::find()->where(['not in', 'name', ['admin']])->all();
            }else if (\Yii::$app->user->can('supervisor-call-center')) {
                $usuariosCallCenter = AuthItem::find()->where(['name' => \Yii::$app->params['roles']['supervisorTelcel']])->orWhere(['name' => \Yii::$app->params['roles']['ejecutivoTelcel']])->all();
            }else{
                
            }

            if (Yii::$app->request->isAjax && $usuario->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($usuario);

            }

            if ($usuario->load(Yii::$app->request->post())) {


                if ($user = $usuario->updateUser($roleActual)) {
                    $this->redirect(['update-usuario-call-center', 'id'=>$user->id_usuario]);
                }
                        
                        // return $this->redirect(['view', 'id' => $model->id_usuario]);

            }
            return $this->render('update-usuario-call-center', [
                'model' => $usuario,
                'usuariosCallCenter' => $usuariosCallCenter
            ]);
        }

    }

    public function actionDeshabilitarUsuario($id){
        $usuario = EntUsuarios::findOne($id);

        if($usuario){
            $usuario->id_status = 3;
            $usuario->save();
        }
    }

    public function actionHabilitarUsuario($id){
        $usuario = EntUsuarios::findOne($id);

        if($usuario){
            $usuario->id_status = 2;
            $usuario->save();
        }
    }
}
