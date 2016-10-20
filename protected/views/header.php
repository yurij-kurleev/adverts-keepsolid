<script src="/js/indexAjax.js"></script>
<header class="header">
    <div class="main-header">
        <div class="main-header-content container">
            <div class="header-logo">
                <div class="header-logo-top">
                    <a href="/index/index" class="logo-link"><b>ADS</b></a>
                </div>
                <div class="header-logo-bottom">
                    -Доска объявлений-
                </div>
            </div>
            <div class="header-add">
                <?php if(!empty($_SESSION['id_u'])) :?>
                    <a href="/index/add" class="header-add-button"> + Объявление</a>
                <?php endif; ?>
            </div>
            <div class="header-regauth">
                <a href="#" class="header-regauth-link" onclick="showAuthMenu(); return false;">
                    <img src="/images/loginIcon.png" alt="login"> ВХОД
                </a> / <a href="/user/register" class="header-regauth-link">РЕГИСТРАЦИЯ</a>
            </div>
        </div>
    </div>
    <div class="search-block">
        <h1 class="search-block-h1">Все свежие объявления на ADvertS.com!</h1>
        <div class="container">
            <div class="search-field-block">
                <div class="search-form">
                    <input type="text" name="searchRequest" id="searchRequest" placeholder="Название товара" class="search-field">
                    <input type="button" value="Найти" class="search-submit" 
                           onclick="searchPost(1, '/ajax/search');  return false;">
                </div>
            </div>
            <div class="arrow-right"></div>
        </div>
    </div>
</header>