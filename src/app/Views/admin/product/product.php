<div class='container'>
<h2><?= $product->getName() ?></h2>
<h3><?= $product->getDescription() ?></h3>
<h3><?= $product->getPrice() ?></h3>

<?php foreach($product->getImages() as $image): ?>
	<img width="100%" src="/images/<?= $image->getImageUrl() ?>" alt="">

<?php endforeach; ?>

<div class="mt-5 d-flex justify-content-center">
	<a href="/admin/product/edit/<?= $product->getId() ?>" class="btn btn-secondary">Edit</a>
	<a href="/admin/product/delete/<?= $product->getId() ?>" class="btn btn-danger">Delete</a>
</div>

</div>