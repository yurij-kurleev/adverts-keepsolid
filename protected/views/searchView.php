<div class="items-block">
    <div class="items-block-header">
        <h2 class="items-block-h2">Недавние объявления</h2>
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
                <div class="post-readmore-btn">
                    <a href="/index/more/<?=$post['id_ad']?>" class="post-readmore">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="page-navigation-block">
    <a href="#" id="prev" class="page-navigation-link"
       onclick="ajaxPagination(this, '/index/search/', '/ajax/search'); return false;"> < </a>
    <a href="#" id="cur" class="page-navigation-link" onclick="return false;"> 1 </a>
    <a href="#" id="next" class="page-navigation-link"
       onclick="ajaxPagination(this, '/index/search/', '/ajax/search'); return false;"> > </a>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        repaintPaginationBar(document.getElementById("cur").firstChild.nodeValue * 1, "/ajax/search");
    });
</script>
<script src="/js/indexAjax.js"></script>