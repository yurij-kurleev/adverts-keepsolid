<div class="advert-form-block">
    <div class="advert-form-block-header">
        <h2><?=$data['post']['topic']?></h2>
    </div>
    <div class="advert-form-block-main">
        <div class="post-category-header">
            Категория: <a href="/index/category/<?=$data['post']['id_cat']?>" class="category-link"><?=$data['post']['title']?></a>
            <?php if($_SESSION['id_u'] == $data['post']['author_id'] || $_SESSION['is_admin'] == 1) : ?>
            <a href="/index/edit/<?=$data['post']['id_ad']?>" class="edit-btn" id="user-edit">Редактировать</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="post-more-main-block">
        <div class="photo-container">
            <img src="<?=$data['post']['reference']?>" alt="Фотографии товара" class="photo">
        </div>
        <hr class="hr">
        <div class="shortcut-info-block">
            <div class="contacts-info">
                <div class="avatar">
                    <?php if(!empty($data['user']['path_to_photo'])) : ?>
                        <img src="<?=$data['user']['path_to_photo']?>" alt="" class="avatar-image">
                    <?php endif; ?>
                </div>
                <div class="contacts">
                    Контактная информация:
                </div>
                <div class="contacts-row">
                    <b>Email</b>: <?=$data['post']['email']?>
                </div>
                <div class="contacts-row">
                    <b>Город</b>: <?=$data['post']['city']?>
                </div>
                <div class="contacts-row">
                    <b>Страна</b>: <?=$data['post']['country']?>
                </div>
                <div class="telephone-block">
                    <input type="text" class="telephone" value="<?=$data['post']['phone']?>" readonly>
                </div>
            </div>
            <div class="price-info">
                <?=(int)$data['post']['price']." грн."?>
            </div>
        </div>
        <hr class="hr">
            <?=nl2br($data['post']['body'])?>
        <hr class="hr">
        <div class="post-footer">
            <div class="post-more-time">
                <img src="/images/dateIco.png" alt="dateIco">
                <?=date('d.m.Y в H:i', $data['post']['add_time'])?>
            </div>
            <div class="post-more-author">
                <img src="/images/authorIco.png" alt="authorIco">
                <?=$data['post']['name']." ".$data['post']['surname']?>
            </div>
            <div class="post-more-views">
                <img src="/images/12-eye-icon.png" alt="authorIco">
                <?=$data['post']['views']?>
            </div>
        </div>
    </div>
</div>