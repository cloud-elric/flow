<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomLinkSorter;
use yii\widgets\Pjax;
use yii\helpers\Url;

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


<?php Pjax::begin(['id' => 'citas', 'timeout'=>'0', 'linkSelector'=>'']) ?>
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
        <div class="nav-tabs-horizontal">
    
            <div class="tab-content">
                <div class="tab-pane animation-fade active" id="all_contacts" role="tabpanel">
                   

                    <?php
                    echo ListView::widget([
                    
                        'dataProvider' => $dataProvider,
                        'itemView' => '_item-cita',
                        'layout' => "<ul class='list-group'>{items}</ul>\n{summary}\n{pager}",
                        'itemOptions'=>[
                            'tag'=>'li',
                            'class'=>'list-group-item'
                        ],
                        'summaryOptions'=>[
                            'class'=>'pull-left'
                        ],
                        'pager'=>[
                            'options'=>[
                                'class'=>'pagination pull-right'
                            ]
                        ]
                        
                    ]);
                    ?>
                </div>
            </div>
        </div>
        
    </div>
   

    
</div>    
<!-- End Panel -->


<?php Pjax::end() ?>

   
