<aside class="aside-block">
    <div class="menu-block">
        <div class="menu">
            <div class="menu-header">
                Меню
            </div>
            <div class="menu-item">
                <a href="/index/index" class="menu-link">Главная страница</a>
            </div>
            <div class="menu-item">
                <a href="#" class="menu-link" onclick="removeContent(); return false;">Информация о сайте</a>
            </div>
            <?php if($_SESSION['id_u']) : ?>
            <div class="menu-item">
                <a href="/user/about/<?=$_SESSION['id_u']?>" class="menu-link" onclick="removeContent(); return false;">Личный кабинет</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="menu-block">
        <div class="menu">
            <div class="menu-header">
                Категории
            </div>
            <?php foreach ($data['categories'] as $category) : ?>
                <div class="menu-item">
                    <a href="/index/category/<?=$category['id_cat']?>" class="menu-link"><?=$category['title']?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</aside>