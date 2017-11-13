<?php

namespace app\controllers;

use Yii;
use app\models\CatEstados;
use app\models\CatEstadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstadosController implements the CRUD actions for CatEstados model.
 */
class EstadosController extends Controller
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
     * Lists all CatEstados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatEstadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatEstados model.
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
     * Creates a new CatEstados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatEstados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_estado]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatEstados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_estado]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatEstados model.
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
     * Finds the CatEstados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CatEstados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatEstados::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetEstado($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $area = $model->idArea;

        if($area)
            return $area;
        else
            return;
    }

    public function actionBuscarEstado($q=null, $page=0){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $criterios['txt_nombre'] = $q;
        $searchModel = new CatEstadosSearch();

        if($page > 1){
            $page--;
        }
        $dataProvider = $searchModel->searchEstados($criterios, $page);
        $response['results']= null;
        $response['total_count'] = $dataProvider->getTotalCount();

        $resultados = $dataProvider->getModels();
        if(count($resultados)==0){
            $response['results'][0] = ['id'=>'', "txt_nombre"=>''];
        }

        foreach($resultados as $model){
            $response['results'][]=['id'=>$model->id_estado, "txt_nombre"=>$model->txt_nombre];
        }
    
        return $response;
    }

}
