<?php

namespace app\controllers;

use Yii;
use app\models\CatTiposPlanesTarifarios;
use app\models\CatTiposPlanesTarifariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;

/**
 * PlanesTarifariosController implements the CRUD actions for CatTiposPlanesTarifarios model.
 */
class PlanesTarifariosController extends Controller
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
     * Lists all CatTiposPlanesTarifarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatTiposPlanesTarifariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatTiposPlanesTarifarios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionGetPlazos($plazo=null){

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $condicionPlan = CatTiposPlanesTarifarios::findOne($id);

            if(empty($condicionPlan)){
                echo Json::encode(['output' => $out]);
                return;
            }

            $list = $condicionPlan->idPlazos;

            if(!$list){
                echo Json::encode(['output' => $out]);
                return;
            }
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $plazos) {
                    $out[] = [
                        'id' => $plazos->id_plazo, 
                        'name' => $plazos->txt_nombre];
                    if ($i == 0) {
                        $selected = $plazo;
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
    }

    public function actionGetCostoPlan($idPlan=null){
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $respuesta['status']  = 'error';
        $respuesta['message'] = "Datos no encontrados";

        $planTarifario = CatTiposPlanesTarifarios::findOne($idPlan);

        if($planTarifario){
            $respuesta['status']  = 'success';
            $respuesta['message'] = "";
            $respuesta['costo'] = $planTarifario->num_costo_renta;
        }

        return $respuesta;
    }

    /**
     * Creates a new CatTiposPlanesTarifarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatTiposPlanesTarifarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_tipo_plan]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatTiposPlanesTarifarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_tipo_plan]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatTiposPlanesTarifarios model.
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
     * Finds the CatTiposPlanesTarifarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CatTiposPlanesTarifarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatTiposPlanesTarifarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
