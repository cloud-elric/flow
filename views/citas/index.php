<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomLinkSorter;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;

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
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id_status',
                        'value' => 'idStatus.txt_nombre'
                    ],
                    'txt_telefono',
                ],
                'tableOptions'=>[
                    'class'=>'table table-hover table-striped'
                ]
            ]) ?>

    <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Products</th>
                        <th>Popularity</th>
                        <th>Sales</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Milk Powder</td>
                        <td>
                          <span data-plugin="peityLine">5,3,2,-1,-3,-2,2,3,4,1</span>
                        </td>
                        <td>
                          <span class="text-danger text-semibold"><i class="icon wb-chevron-down-mini" aria-hidden="true"></i>                            28.76%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Air Conditioner</td>
                        <td>
                          <span data-plugin="peityLine">1,-1,-2,1,2,1,0,1,3,2</span>
                        </td>
                        <td>
                          <span class="text-warning text-semibold"><i class="icon wb-chevron-down-mini" aria-hidden="true"></i>                            8.55%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>RC Cars</td>
                        <td>
                          <span data-plugin="peityLine">3,2,3,-1,-3,-1,0,2,4,5</span>
                        </td>
                        <td>
                          <span class="text-success text-semibold"><i class="icon wb-chevron-up-mini" aria-hidden="true"></i>                            58.56%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Down Coat</td>
                        <td>
                          <span data-plugin="peityLine">1,-2,0,2,4,5,3,2,3,5</span>
                        </td>
                        <td>
                          <span class="text-info text-semibold"><i class="icon wb-chevron-up-mini" aria-hidden="true"></i>                            35.76%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>SLR Camera</td>
                        <td>
                          <span data-plugin="peityLine">1,-1,0,2,3,1,-1,1,4,2</span>
                        </td>
                        <td>
                          <span class="text-warning text-semibold"><i class="icon wb-chevron-down-mini" aria-hidden="true"></i>                            21.13%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>Jacket</td>
                        <td>
                          <span data-plugin="peityLine">4,2,-1,-3,-2,1,3,5,2,4</span>
                        </td>
                        <td>
                          <span class="text-info text-semibold"><i class="icon wb-chevron-up-mini" aria-hidden="true"></i>                            26.88%</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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

   
