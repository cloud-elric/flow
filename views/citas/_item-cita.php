<?php
use app\modules\ModUsuarios\models\EntUsuarios;
use \yii\helpers\Url;
use app\models\Constantes;

$tramite = $model->idTipoTramite;
$equipo = $model->idEquipo;
$status = $model->idStatus;
$statusColor = '';

switch ($model->id_status) {
    case '1':
        $statusColor = 'default';
        break;
    case '2':
        $statusColor = 'primary';
        break;
    case '3':
        $statusColor = 'success';
        break;    
    case '4':
        $statusColor = 'warning';
        break;
    case '5':
        $statusColor = 'danger';
    break;  
    case '6':
        $statusColor = 'danger';
    break;  
    case '7':
        $statusColor = 'danger';
    break;   
    case '8':
        $statusColor = 'danger';
    break;      
    default:
        # code...
        break;
}


?>
<div class="media">
    <div class="media-body">
        <h4 class="media-heading">
        <span class="label label-<?=$statusColor?>"><?=$status->txt_nombre?></span>
            <?=$model->txt_telefono?>
            <small>
                <?=$tramite->txt_nombre?>
            </small>
        </h4>
        <p>
            <i class="icon icon-color wb-mobile" aria-hidden="true"></i>
            <?=$equipo->txt_nombre?>
        </p>
        <p>
            Clave de envio: <?=$model->id_envio?$model->idEnvio->txt_token:'Sin clave'?>
        </p>
        <p>
            <?=$equipo->txt_descripcion?>
        </p>
    </div>

    <!-- Single button -->
<div class="media-right">
    <div class="btn-group">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-info dropdown-menu-right">
            <li>
                <?php
                if($model->id_status==Constantes::PROCESO_VALIDACION){
                ?>
                <a href="<?=Url::base()?>/citas/validar-credito?token=<?=$model->txt_token?>" data-token="<?=$model->txt_token?>">
                        Ver detalles
                </a>
                <?php 
                }?>

                <?php
                if($model->id_status==Constantes::CONTRATO_AUTORIZADO || $model->id_status==Constantes::CONTRATO_AUTORIZADO_SIN_IMEI){
                ?>
                <a href="<?=Url::base()?>/citas/view?token=<?=$model->txt_token?>" data-token="<?=$model->txt_token?>">
                        Ver detalles
                </a>
                <?php 
                }?>

            </li>
        </ul>
        </div>
    </div>
</div>
