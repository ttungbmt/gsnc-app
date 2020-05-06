<?php
use kartik\helpers\Html;
$serial = (($page = request('page', 1) - 1) == 0 ? 0 : $page) * request('per-page', 20) + $index + 1;
$links = collect($model->getLinks());
?>


<div class="item-group">
    <ul class="media-list media-list-linked media-list-bordered">
        <li class="media">
            <div class="mr-3 position-relative">
                <img src="<?=asset('assets/img/household.png')?>" class="rounded-circle" width="36" height="36"  alt="true">
                <span class="badge bg-blue-400 badge-pill badge-float border-2 border-white"><?=$serial?></span>
            </div>
            <div class="media-body">
                <h6 class="media-heading font-weight-semibold">
                    <a><?= $model->getName() ?></a>
                </h6>
                <div>
                    <?php if($model->distance):?>
                        <div><i class="icon-rulers" style="font-size: 12px;"></i> <?=$model->getDistanceText()?></div>
                    <?php endif;?>

                    <?php if($model->getAddress()):?>
                        <div><i class="icon-home2" style="font-size: 12px;"></i> <?=$model->getAddress()?></div>
                    <?php endif;?>
                </div>
                <ul class="list-inline mt-1">
                    <?php if(user()->can('admin')):?>
                        <li class="list-inline-item"><?=Html::a('Chi tiết', $links->get('self'), ['data-pjax' => 0, 'target' => '_blank'])?></li>
                    <?php endif;?>
                    <?php if(user()->can('admin')):?>
                        <li class="list-inline-item"><?=Html::a('Cập nhật', $links->get('edit'), ['data-pjax' => 0, 'target' => '_blank'])?></li>
                    <?php endif;?>
                </ul>
            </div>
        </li>
    </ul>
</div>