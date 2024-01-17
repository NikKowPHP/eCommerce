<div class='container'>
<h2><?= $user->getUsername() ?></h2>
<h3><?= $user->getEmail() ?></h3>
<h3><?= $user->getPassword() ?></h3>


<div class="mt-5 d-flex justify-content-center">
	<a href="/admin/user/edit/<?= $user->getId() ?>" class="btn btn-secondary">Edit</a>
	<a href="/admin/users" class="btn btn-danger">Delete</a>
</div>

</div>