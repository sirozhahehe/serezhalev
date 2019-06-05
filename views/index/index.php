<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>
<?php
$i = 1;
$notes_arr = array('Шаблоны взяты с сайта <strong>cssauthor.com</strong>',
    'Верстка <strong>правильно</strong> отображается на любых разрешениях и в любых браузерах.',
    'Нажмите на название любого шаблона и <strong>убедитесь сами</strong>.');
?>
<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <h1>Serezha Lev.</h1>
                <hr>
                <p class="wow fadeIn" data-wow-delay="0.1s">Привет, меня зовут Серёжа.</p>
                <p class="wow fadeIn" data-wow-delay="0.4s">Я занимаюсь <a href="/news" target="_blank" alt="Демо-блок новостей.">PHP-программированием</a>.</p>
                <p class="wow fadeIn" data-wow-delay="0.7s">Умею верстать <a href="#myworks">веб-страницы</a>.</p>
            </div></div>
    </div>
</div>
<div id="myworks">
    <div class="container">
        <div class="row">
            <h1>Мои работы.</h1>
        </div>
    </div>
    <?php foreach($result as $lay):?>
    <div class="work<?= $i?>">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-1">
                    <div class="textworks">
                        <a href="/layouts/<?=$lay?>" target="_blank" class="wow fadeIn" data-wow-delay="0.1s"><?=$lay?></a>
                        <p class="wow fadeIn" data-wow-delay="0.2s"><?= $notes_arr[$i-1] ?></p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="imageworks wow fadeIn" data-wow-delay="0.3s">
                        <a data-fancybox href="/templates/img/imgbig<?= $i?>.jpg"><img id="imagework" src="/templates/img/imgsmall<?= $i?>.jpg" height="100%" width="100%" alt=""/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $i++ ?>
    <?php endforeach; ?>
</div>
<?= include ROOT.'/templates/html/footer.php'?>
