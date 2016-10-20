<div class="advert-form-block">
    <div class="advert-form-block-header">
        <h2>Добавление нового объявления</h2>
    </div>
    <div class="advert-form-block-main">
        <form action="" method="POST" class="advert-form">
            <div class="form-group">
                <label for="category" class="label">Категория: </label>
                <select name="category" class="input" id="category">
                    <?php foreach($data['categories'] as $category) : ?>
                        <option value=<?=$category['id_cat']?>><?=$category['title']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr class="hr">
            <div class="form-group">
                <label for="topic" class="label">Тема объявления: </label>
                <input type="text" class="input" name="topic" id="topic" value="<?=$data['post']['topic']?>" required>
            </div>
            <div class="form-group">
                <label for="text" class="label">Текст объявления: </label>
                <textarea rows="10" class="input" name="text" id="text" required><?=$data['post']['body']?></textarea>
            </div>
            <hr class="hr">
            <div class="form-group">
                <label for="telephone" class="label">Телефон: </label>
                <input type="text" class="input" name="telephone" id="telephone" value="<?=$data['post']['phone']?>" required>
            </div>
            <div class="form-group">
                <label for="email" class="label">E-mail: </label>
                <input type="email" class="input" name="email" id="email" value="<?=$data['post']['email']?>" required>
            </div>
            <div class="form-group">
                <label for="city" class="label">Город: </label>
                <input type="text" class="input" name="city" id="city" value="<?=$data['post']['city']?>" required>
            </div>
            <div class="form-group">
                <label for="country" class="label">Страна: </label>
                <input type="text" class="input" name="country" id="country" value="<?=$data['post']['country']?>" required>
            </div>
            <hr class="hr">
            <div class="form-group">
                <label for="price" class="label">Цена: </label>
                <input type="number" class="input" name="price" id="price" value="<?=$data['post']['price']?>" required>
            </div>
            <hr class="hr">
            <input type="submit" value="Готово" class="advert-form-submit">
        </form>
    </div>
</div>