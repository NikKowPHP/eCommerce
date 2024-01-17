<div class="container col-md-6">
	<form action="/admin/product/store" method="POST" enctype="multipart/form-data">
		<div class="form-group m-2">
			<label>
				<input name="name" type="text" class="form-control" placeholder="Enter product name">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="description" type="text" class="form-control" placeholder="Enter description">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="price" type="text" class="form-control" placeholder="Enter price">
			</label>
		</div>
		<div class="form-group m-2">
			<label>
				<input name="file" type="file" class="form-control" accept="image/*">
			</label>
		</div>
		<button type="submit" class="btn btn-primary m-2">Create</button>
	</form>
</div>