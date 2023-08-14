<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<h1>Libros a la Venta</h1>
<div class="row">
  <?php foreach ($libros as $libro) : ?>

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      <a href="#" class="thumbnail">
        <img data-src="#" alt="">
        <?= Html::img($libro->imagen); ?>
        <?= Html::encode("{$libro->lb_titulo}") ?>
      </a>
    </div>


  <?php endforeach; ?>
</div>


<?= LinkPager::widget(['pagination' => $pagination]) ?>