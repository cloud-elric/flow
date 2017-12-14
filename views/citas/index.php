<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomLinkSorter;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\models\Calendario;
use kartik\export\ExportMenu;

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
                switch ($statu->id_statu_cita) {
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

    <?php

    $gridColumns =  [
        [
            'attribute' => 'id_status',
            'format'=>'raw',
            'value'=>function($data){
                
                return $data->idStatus->txt_nombre;
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
        [
            'attribute'=>'fch_cita',
            'format'=>'raw',
            'value'=>function($data){
                if(!$data->fch_cita){
                    return "(no definido)";
                }
                return Calendario::getDateComplete($data->fch_cita);
            }
        ],
        [
            'attribute'=>'id_envio',
            'value'=>'idEnvio.txt_token'
        ],

        
    ] ;           

    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'target' => ExportMenu::TARGET_BLANK,
        'showConfirmAlert'=>false,
        'fontAwesome' => true,
        'asDropdown' => false,
         'exportConfig'=>[
            ExportMenu::FORMAT_HTML => false,
            
            ExportMenu::FORMAT_TEXT =>false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_EXCEL_X => false,
        ],
        
    ]);

    ?>  
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' =>[
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
                                case '9':
                                    $statusColor = ' bg-brown-800';
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
                    [
                        'attribute'=>'fch_cita',
                        'format'=>'raw',
                        'value'=>function($data){
                            if(!$data->fch_cita){
                                return "(no definido)";
                            }
                            return Calendario::getDateComplete($data->fch_cita);
                        }
                    ],
                    [
                        'attribute'=>'id_envio',
                        'value'=>'idEnvio.txt_token'
                    ],
                    
                ],
                'panelTemplate' => "{panelHeading}\n{items}\n{summary}\n{pager}",
                "panelHeadingTemplate"=>"<div class='pull-right'>{export}</div>",
                'responsive'=>true,
                'hover'=>true,
                'bordered'=>false,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Countries</h3>',
                    'type'=>'success',
                    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                    'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                    'footer'=>false
                ],
                'toolbar' => [
                    '{export}',
                ],
                'export' => [
                    'fontAwesome' => true,
                    'showConfirmAlert'=>false,
                   
                    'itemsAfter'=> [
                        '<li role="presentation" class="divider"></li>',
                        '<li class="dropdown-header">Export todos los datos</li>',
                        $fullExportMenu
                    ]
                ],
                'exportConfig'=>[
                    GridView::CSV => [
                        'label' => Yii::t('kvgrid', 'CSV'),
                        'icon' =>'file-code-o', 
                        'iconOptions' => ['class' => 'text-primary'],
                        'showHeader' => true,
                        'showPageSummary' => true,
                        'showFooter' => true,
                        'showCaption' => true,
                        'filename' => Yii::t('kvgrid', 'grid-export'),
                        'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
                        'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
                        'mime' => 'application/csv',
                        'config' => [
                            'colDelimiter' => ",",
                            'rowDelimiter' => "\r\n",
                        ]
                    ],
                ],
            ]) ?>
 
    </div>
   

    
</div>    
<!-- End Panel -->


<?php Pjax::end() ?>

   
