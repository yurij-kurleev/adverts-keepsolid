<div class="advert-form-block">
    <div class="advert-form-block-header">
        <h2>Регистрация</h2>
    </div>
    <div class="advert-form-block-main">
        <form action="" method="POST" class="advert-form">
            <hr class="hr">
            <div class="form-group">
                <label for="name" class="label">Имя: </label>
                <input type="text" class="input" name="name" id="name" value="<?=$data['user']['name']?>" required>
            </div>
            <div class="form-group">
                <label for="surname" class="label">Фамилия: </label>
                <input type="text" class="input" name="surname" id="surname" value="<?=$data['user']['surname']?>" required>
            </div>
            <div class="form-group">
                <label for="login" class="label">Логин: </label>
                <input type="text" class="input" name="login" id="login" required>
            </div>
            <div class="form-group">
                <label for="password" class="label">Пароль: </label>
                <input type="password" class="input" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="email" class="label">E-mail: </label>
                <input type="email" class="input" name="email" id="email" value="<?=$data['user']['email']?>" required>
            </div>
            <hr class="hr">
            <input type="submit" value="Готово" class="advert-form-submit">
        </form>
    </div>
</div>