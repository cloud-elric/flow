<?php
namespace app\controllers;

use Yii;
use app\models\CatEquipos;
use app\models\EntEquiposSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\db\Expression;
use app\models\RelEquipoPlazoCosto;
use app\models\EntCitas;
use app\models\EntEntradas;

/**
 * EquiposController implements the CRUD actions for CatEquipos model.
 */
class EquiposController extends Controller
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
     * Lists all CatEquipos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntEquiposSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatEquipos model.
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
     * Creates a new CatEquipos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatEquipos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_equipo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatEquipos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_equipo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatEquipos model.
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
     * Finds the CatEquipos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CatEquipos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ( ($model = CatEquipos::findOne(['id_equipo' => $id, 'b_habilitado' => 1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetEquipo($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);

        return $model;

    }

    public function actionBuscarEquipo($q = null, $page = 0)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $criterios['txt_nombre'] = $q;
        $searchModel = new EntEquiposSearch();

        

        if ($page > 1) {
            $page--;
        }
        $dataProvider = $searchModel->searchEquipo($criterios, $page);
        $response['results'] = null;
        $response['total_count'] = $dataProvider->getTotalCount();

        $resultados = $dataProvider->getModels();
        if (count($resultados) == 0) {
            $response['results'][0] = ['id' => '', "txt_nombre" => ''];
        }

        foreach ($resultados as $model) {
            $cantidadStock = EntEntradas::find()->where(['id_equipo'=>$model->id_equipo])->sum('num_unidades');

            $countCitasEquipo = EntCitas::find()
                ->where(['id_equipo'=>$model->id_equipo])
                ->andWhere(['in', 'id_status', [2,3,6,7,8]])
                ->orWhere(['and',['id_equipo'=>$model->id_equipo], ['id_status'=>1], ['<',new Expression('(time_to_sec(timediff(now(),fch_creacion) /60))'), 1] ])
                ->count();//new Expression('DATE_ADD(NOW(), INTERVAL 2 HOUR)')
            if($cantidadStock){
                $response['results'][] = ['id' => $model->id_equipo, "txt_nombre" => $model->txt_nombre, "cantidad" => $cantidadStock - $countCitasEquipo];            
            }else{
                $response['results'][] = ['id' => $model->id_equipo, "txt_nombre" => $model->txt_nombre, "cantidad" => 0];
            }    
        }        

        return $response;
    }

    public function actionGetCostoEquipo()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $respuesta['status'] = 'error';
        $respuesta['message'] = "Campos insuficientes";

        if (isset($_POST['idEquipo']) && isset($_POST['idPlanTarifario']) && isset($_POST['idPlazo'])) {
            $idEquipo = $_POST['idEquipo'];
            $idPlanTarifario = $_POST['idPlanTarifario'];
            $idPlazo = $_POST['idPlazo'];
            $relCostoEquipo = RelEquipoPlazoCosto::findOne([
                'id_equipo' => $idEquipo,
                'id_tipo_plan_tarifario' => $idPlanTarifario, 
                'id_plazo' => $idPlazo
            ]);

            if ($relCostoEquipo) {
                $respuesta['status'] = 'success';
                $respuesta['costo'] = $relCostoEquipo->num_costo;
                $respuesta['message'] = "";
            }else{
                $respuesta['message'] = 'Sin datos';
            }

        }

        return $respuesta;

    }
}
