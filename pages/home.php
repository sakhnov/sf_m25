<h1>Главная</h1>


<?php 
    $photos = getAllPhotos();
    if(!empty($photos)):
?>

    <div class="photos">
        <?php foreach ($photos as $photo): ?>
            <div class="photo">
                <a href="photo/<?= $photo['id']; ?>">
                    <img src="<?= UPLOAD_DIR . '/' . $photo['filename'] ?>" class="img-thumbnail img-fluid">
                </a>
            </div>
        <?php endforeach ?>
    </div>
<?php endif; ?>