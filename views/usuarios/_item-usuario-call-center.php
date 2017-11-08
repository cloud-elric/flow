<?php
use app\modules\ModUsuarios\models\EntUsuarios;
use app\models\Calendario;
use yii\helpers\Url;
?>
<div class="media">
    <div class="media-left">
        <div class="avatar <?=($model->id_status == EntUsuarios::STATUS_ACTIVED)? "avatar-online":"avatar-busy"?>">
            <img src="<?=$model->imageProfile?>" alt="<?=$model->nombreCompleto?>">
            <i></i>
        </div>
    </div>

    <div class="media-body">
        <h4 class="media-heading">
            <?=$model->nombreCompleto?>
            <small>
            <?=$model->authItem->description?>
            </small>
        </h4>
        <p>
            <i class="icon icon-color wb-envelope" aria-hidden="true"></i><?=$model->txt_email?>
        </p>
        <p>
            
        </p>
        <p>    
            
        </p>
    </div>

    <!-- Single button -->
<div class="media-right">
    <div class="btn-group">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-info dropdown-menu-right">
            <li><a href="<?=Url::base()?>/usuarios/update-usuario-call-center?id=<?=$model->id_usuario?>">Editar</a></li>
            <li><a href="#" class="<?=($model->id_status == EntUsuarios::STATUS_ACTIVED)?'js-deshabilitar-user':'js-habilitar-user'?>" data-token="<?=$model->id_usuario?>"><?=($model->id_status == EntUsuarios::STATUS_ACTIVED)?'Deshabilitar':'Habilitar'?></a></li>
        </ul>
        </div>
    </div>
</div>
