<?php use App\Utils\SessionManager ?>
<?php echo SessionManager::getFlashMessage('success') ?>
<div class="container col-md-6">
	<h1>Edit </h1>
	<form action="/admin/product/update" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $product->getId() ?>">
		<div class="form-group m-2">
			<label>
				<input name="name" type="text" class="form-control" placeholder="Enter product name"
					value="<?= $product->getName() ?>">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="description" type="text" class="form-control" placeholder="Enter description"
					value="<?= $product->getDescription() ?>">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="price" type="text" class="form-control" placeholder="Enter price"
					value="<?= $product->getPrice() ?>">
			</label>
		</div>
		<div class="form-group m-2">
			<?php foreach ($product->getImages() as $image): ?>

				<img width="100%" src="/images/<?= $image->getImageUrl() ?>" alt="">

			<?php endforeach ?>
		</div>
		<div class="form-group m-2">

			<label>
				<input name="file" type="file" class="form-control" accept="image/*">
			</label>
		</div>
		<button type="submit" class="btn btn-primary m-2">Update</button>
	</form>
</div>