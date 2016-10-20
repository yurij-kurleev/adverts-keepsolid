<div class="items-block-header">
    <h2 class="items-block-h2">Информация о пользователе</h2>
</div>
<div class="advert-form-block-main" id="user">
    <div class="user-photo">
        <img src="<?=$data['user']['path_to_photo']?>" alt="Фотография пользователя" class="photo">
    </div>
    <hr class="hr">
    <div class="user-info-row">Имя: <?=$data['user']['name']?></div>
    <div class="user-info-row">Фамилия: <?=$data['user']['surname']?></div>
    <div class="user-info-row">Группа:
        <?php
            echo ($data['user']['is_admin'] == 1)? "Администраторы" : "Пользователи";
        ?>
    </div>
    <div class="user-info-row">E-mail: <?=$data['user']['email']?></div>
    <div class="user-info-row">Дата регистрации: <?=date("d.m.Y", $data['user']['register_date'])?></div>
    <hr class="hr">
    <a href="/user/edit/<?=$_SESSION['id_u']?>" class="edit-btn">Редактировать профиль</a>
</div>

<div class="user-posts">
    <div class="items-block-header">
        <h2 class="items-block-h2">Мои объявления</h2>
    </div>
    <?php foreach($data['posts'] as $post) : ?>
        <div class="post">
            <div class="post-description">
                <h3 class="post-title"><?=$post['topic']?></h3>
                <div class="image-block">
                    <img src="<?=$post['reference']?>" alt="Изображение товара" class="post-main-image">
                </div>
                <div class="description">
                    <?=mb_strimwidth($post['body'], 0, 200, "...")?>
                </div>
            </div>
            <div class="post-rating">
                <?php if($_SESSION['id_u'] == $post['author_id'] || $_SESSION['is_admin'] == true) : ?>
                    <div class="delete-post" onclick="deletePost(<?=$post['id_ad']?>)"> X </div>
                <?php endif; ?>
                <div class="price"><?=(int)$post['price']." грн."?></div>
            </div>
            <div class="hr"><hr/></div>
            <div class="post-footer">
                <div class="post-time">
                    <img src="/images/dateIco.png" alt="dateIco">
                    <?=date('d.m.Y в H:i', $post['add_time'])?>
                </div>
                <div class="post-author">
                    <img src="/images/authorIco.png" alt="authorIco">
                    <?=$post['name']." ".$post['surname']?>
                </div>
                <!--
                <div class="post-comments">
                    <img src="/images/commentsIco.png" alt="commentsIco">
                    15
                </div>
                -->
                <div class="post-readmore-btn">
                    <a href="/index/more/<?=$post['id_ad']?>" class="post-readmore">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!--
    <div class="page-navigation-block">
        <a href="#" id="prev" class="page-navigation-link"
           onclick="ajaxPagination(this, '/user/posts/' + <?=$_SESSION['id_u']?>, '/ajax/about/' + <?=$_SESSION['id_u']?>); return false;"> < </a>
        <a href="#" id="cur" class="page-navigation-link" onclick="return false;"> 1 </a>
        <a href="#" id="next" class="page-navigation-link"
           onclick="ajaxPagination(this, '/user/posts/' + <?=$_SESSION['id_u']?>, '/ajax/about/' + <?=$_SESSION['id_u']?>); return false;"> > </a>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        repaintPaginationBar(document.getElementById("cur").firstChild.nodeValue * 1, "/ajax/user/" + <?=$_SESSION['id_u']?>);
    });
</script>
-->
