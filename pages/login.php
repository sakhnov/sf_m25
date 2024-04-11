<?php if (!empty(checkUser())): $user = checkUser(); ?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Добро пожаловать, <?= $user['name']; ?></h1>
    </div>    
</div>      

<?php

$errors = [];
 
if (!empty($_FILES)) {
 
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
 
        $fileName = $_FILES['files']['name'][$i];
 
        if ($_FILES['files']['size'][$i] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Недопустимый размер файла ' . $fileName;
            continue;
        }
 
        if (!in_array($_FILES['files']['type'][$i], ALLOWED_TYPES)) {
            $errors[] = 'Недопустимый формат файла ' . $fileName;
            continue;
        }
 
        $filePath = UPLOAD_DIR . '/' . basename($fileName);
 
        if (!move_uploaded_file($_FILES['files']['tmp_name'][$i], $filePath)) {
            $errors[] = 'Ошибка загрузки файла ' . $fileName;
            continue;
        } else {
            addPhoto(['user_id' => $user['id'], 'filename' => $fileName]);
        }
    }
}

?>

<div class="row">
    <div class="col-12">
 
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
 
    <?php if (!empty($_FILES) && empty($errors)): ?>
        <div class="alert alert-success">Файлы успешно загружены</div>
    <?php endif; ?>
 
    <form action="" method="post" enctype="multipart/form-data">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="files[]" id="customFile" multiple required>
            <label class="custom-file-label" for="customFile" data-browse="Выбрать">Выберите файлы</label>
            <small class="form-text text-muted">
                Максимальный размер файла: <?php echo UPLOAD_MAX_SIZE / 1000000; ?>Мб.
                Допустимые форматы: <?php echo implode(', ', ALLOWED_TYPES) ?>.
            </small>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Загрузить</button>
        <a href="/login" class="btn btn-secondary ml-3">Сброс</a>
    </form>

    </div>
</div>

<?php 
    $photos = getUserPhotos($user['id']);
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

<?php else: ?>

<div class="row">
	<div class="col-12 col-md-4 offset-md-4">
		<h1>Войти</h1>
	</div>	
    <div class="col-12 col-md-4 offset-md-4">
        <form action="config/autorization.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Введите email" required>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Войти</button>
                <div class="sign-link"><a href="/sign">Зарегистрироваться</a></div>
            </div>
        </form>
    </div>
</div>

<?php endif; ?>