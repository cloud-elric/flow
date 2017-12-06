<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomLinkSorter;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Calendario;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ModUsuarios\models\EntUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas';
Yii::$app->view->params['btnAcciones'] = '<a class="btn btn-success" href="'.Url::base().'/citas/create"><i class="icon wb-plus"></i>Agregar</a>';
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-calendar"></i>Citas', 'encode' => false];

$this->registerCssFile(
    '@web/webAssets/css/citas.css',
    ['depends' => [\app\assets\AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/citas.js',
    ['depends' => [\app\assets\AppAsset::className()]]
);
?>


<?php Pjax::begin(['id' => 'citas', 'timeout'=>'0', 'linkSelector'=>'table thead a']) ?>
<div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">
    <div class="panel">
        <div class="panel-heading" id="exampleHeadingDefaultOne" role="tab">
            <a class="panel-title <?=Yii::$app->request->get('isOpen')?'':'collapsed' ?> js-collapse" data-toggle="collapse" href="#exampleCollapseDefaultOne" data-parent="#exampleAccordionDefault" aria-expanded="<?=Yii::$app->request->get('isOpen')?'true':'false' ?>" aria-controls="exampleCollapseDefaultOne">
                Buscar cita
            </a>
        </div>
        <div class="panel-collapse collapse <?=Yii::$app->request->get('isOpen')?'in':'' ?>" id="exampleCollapseDefaultOne" aria-labelledby="exampleHeadingDefaultOne" role="tabpanel" aria-expanded="<?=Yii::$app->request->get('isOpen')?'true':'false' ?>">
            <div class="panel-body">
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
</div>


 <!-- Panel -->
 <div class="panel" id="panel">
 
    <div class="js-ms-loading text-center">
            <h3>Cargando información</h3>
    </div>
    <div class="panel-body">
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id_status',
                        'format'=>'raw',
                        'value'=>function($data){
                            switch ($data->id_status) {
                                case '1':
                                    $statusColor = 'warning';
                                    break;
                                case '2':
                                    $statusColor = ' bg-brown-800';
                                    break;
                                case '3':
                                    $statusColor = ' bg-blue-800';
                                    break;    
                                case '4':
                                    $statusColor = 'danger';
                                    break;
                                case '5':
                                    $statusColor = 'danger';
                                break;  
                                case '6':
                                    $statusColor = ' bg-blue-800';
                                break;  
                                case '7':
                                    $statusColor = 'success';
                                break;   
                                case '8':
                                    $statusColor = 'success';
                                break;      
                                default:
                                    # code...
                                    break;
                            }

                            return Html::a(
                                $data->idStatus->txt_nombre,
                                Url::to(['citas/ver-cita', 'token' => $data->txt_token]), 
                                [
                                    'class'=>'btn label label-'.$statusColor.'',
                                ]
                            );
                        }
                    ],
                    'txt_telefono',
                    [
                        'attribute'=>'id_tipo_tramite',
                        'value'=>'idTipoTramite.txt_nombre'
                    ],
                    [
                        'attribute'=>'fch_creacion',
                        'format'=>'raw',
                        'value'=>function($data){

                            return Calendario::getDateComplete($data->fch_creacion);
                        }
                    ],
                    
                ],
                'layout' => "{items}\n{summary}\n{pager}",
                'tableOptions'=>[
                    'class'=>'table table-hover table-striped'
                ]
            ]) ?>
 
    </div>
   

    
</div>    
<!-- End Panel -->


<?php Pjax::end() ?>

   
