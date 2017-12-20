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


<?php Pjax::begin(['id' => 'citas', 'timeout'=>'0', 'linkSelector'=>'table thead a, a.list-group-item']) ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group bg-blue-grey-100">
            <?php
            foreach($status as $statu){
                $statusColor = switchStatusColor($statu->id_statu_cita);
            ?>

            <a class="list-group-item blue-grey-500" href="<?=Url::base()?>/citas/index?EntCitasSearch[id_status]=<?=$statu->id_statu_cita?>">
                <i class="icon wb-calendar" aria-hidden="true"></i>  
                <span class="badge badge-<?=$statusColor?> text-white">
                    <?=count($statu->entCitas)?>
                </span>
                <?=$statu->txt_nombre?>
            </a>
            
            <?php
                }
            ?>
            <a class="list-group-item blue-grey-500" href="<?=Url::base()?>/citas/index">
                Mostrar todas
            </a>
           
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">
            <div class="panel">
                <div class="panel-heading" id="exampleHeadingDefaultOne" role="tab">
                    <a class="panel-title  js-collapse" data-toggle="collapse" href="#exampleCollapseDefaultOne" data-parent="#exampleAccordionDefault" aria-expanded="true" aria-controls="exampleCollapseDefaultOne">
                        Buscar cita
                    </a>
                </div>
                <div class="panel-collapse collapse in" id="exampleCollapseDefaultOne" aria-labelledby="exampleHeadingDefaultOne" role="tabpanel" aria-expanded="true">
                    <div class="panel-body">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
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
                            $statusColor = switchStatusColor($data->id_status);

                            return Html::a(
                                $data->idStatus->txt_nombre,
                                Url::to(['citas/ver-cita', 'token' => $data->txt_token]), 
                                [
                                    'class'=>'btn label label-'.$statusColor.'',
                                    'data-status'=>'status'
                                ]
                            );
                        }
                    ],
                    [
                        'attribute'=>'txt_telefono',
                        'format'=>'raw',
                        'value'=>function ($data){
                            $tag = '<button type="button" class="btn btn-icon btn-info btn-outline"><i class="icon wb-wrench" aria-hidden="true"></i></button>'.$data->txt_telefono;    
                            return $tag;
                        }
                    ],
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
                    [
                        'header'=>'Opciones',
                        'format'=>'raw',
                        'value'=>function ($data){
                            $tag = '<div class="btn-group" role="group">
                            <button type="button" class="btn btn-icon btn-default btn-outline"><i class="icon wb-file" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-icon btn-default btn-outline"><i class="icon wb-pencil" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-icon btn-default btn-outline"><i class="icon wb-folder" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-icon btn-default btn-outline"><i class="icon wb-trash" aria-hidden="true"></i></button>
                          </div>';    
                            return $tag;
                        }
                    ]
                    
                ],
                'layout' => "{items}\n{summary}\n{pager}",
                'tableOptions'=>[
                    'class'=>'table table-hover dataTable table-striped w-full dtr-inline'
                ]
            ]) ?>
 
    </div>
   

    
</div>    
<!-- End Panel -->


<?php Pjax::end() ?>

   
<?php 

function switchStatusColor($status){
    switch ($status) {
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
        case '9':
            $statusColor = ' bg-brown-800';
        break;        
        default:
            # code...
            break;
    }

    return $statusColor;
}