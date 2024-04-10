<h1>Картинка</h1>
<?php $photo = getPhoto($photo_id); 
	  $user = checkUser();
?>

<div class="row">
	<div class="col-12">
		<img src="/<?= UPLOAD_DIR . '/' . $photo['filename'] ?>" class="img-thumbnail img-fluid">
		<?php if (!empty($user['id']) && $photo['user_id'] == $user['id']): ?>		
			<div class="photo-btn mt-4">
				<button class="btn btn-danger btn-sm" onclick="deletePhoto('<?= $photo_id ?>')" >Удалить фото и все комментарии к нему</button>
			</div>
		<?php endif; ?>		
	</div>
</div>

<?php if (!empty($_POST['comments'])): 
	addComment(['user_id' => $user['id'], 'photo_id' => $photo_id, 'comment' => $_POST['comments']]);
	 header("Location: /photo/".$photo_id); exit; 
endif; ?>	

<?php if (!empty($user)): ?>
<div class="row mt-5">
	<div class="col-6">	
		<h2>Оставить комментарий</h2>
		<form action="" method="post">
			<div class="form-group">
				<textarea class="form-control" name="comments"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Отправить</button>
		</form>
	</div>
</div>	
<?php endif;?>	

<?php $comments = getAllComments($photo_id);
if (!empty($comments)): ?>
<div class="row mt-5">
	<div class="col-6">
		<div class="comments">
		<?php foreach ($comments as $comment): $user_comment = getUserById($comment['user_id']); ?>
			<div class="comment">
				<div class="commant-header">
					<div class="comment-name"><?= $user_comment['name'] ; ?></div>
					<div class="comment-date"><?= $comment['created_at']; ?></div>
				</div>
				<div class="commant-text"><?= $comment['comment']; ?></div>
				<?php if (!empty($user['id']) && $comment['user_id'] == $user['id']): ?>
				<div class="comment-btn">
					<button class="btn btn-danger btn-sm" onclick="deleteComment('<?= $comment['id']?>')" >Удалить</button>
				</div>
				<?php endif ?>
			</div>
		<?php endforeach ?>
		</div>
	</div>
</div>	
<?php endif; ?>
