<table width="600" cellpadding="5" class="table">
	<tr>
		<th scope="row">Display Name</th>
		<td><?= (trim($user['name'])) ?></td>
	</tr>
	<tr>
		<th scope="row">Email</th>
		<td><?= (trim($user['email'])) ?></td>
	</tr>
</table>
<a href="<?= ($BASE.'/user/profile/edit') ?>" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> Edit profile</a>

