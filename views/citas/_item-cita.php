<?php
use app\modules\ModUsuarios\models\EntUsuarios;
use \yii\helpers\Url;

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
                <a href="<?=Url::base()?>/citas/view?token=<?=$model->txt_token?>". data-token="<?=$model->txt_token?>">
                        Ver detalles
                </a>
            </li>
        </ul>
        </div>
    </div>
</div>
