<?php

/**
 * @var array $options
 * @var Yii\web\View $this
 */

?>

<div class="likely <?= $options['colorClass'] ?> <?= $options['sizeClass'] ?>" data-url="<?= $options['url'] ?>" data-title="<?= $options['title'] ?>">
    <?php foreach ($options['items'] as $item) { ?>
    <div class="<?= $item['class'] ?>" data-via="<?= $item['via'] ?>" data-text="<?= $item['text'] ?>" data-media="<?= $item['media'] ?>"><?= $item['title'] ?></div>
    <?php } ?>
</div>