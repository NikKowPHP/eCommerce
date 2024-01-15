<div class='container'>
<h2><?= $product->getName() ?></h2>
<h3><?= $product->getDescription() ?></h3>
<h3><?= $product->getPrice() ?></h3>

<?php foreach($product->getImages() as $image): ?>

<h3><?= $image->getImageUrl(); ?></h3>

<?php endforeach; ?>
</div>