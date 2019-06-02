<?= include(ROOT.'/templates/html/head.php')?>
<?= include(ROOT.'/templates/html/navbar.php')?>
<?php $last_page = ceil($count/$post_count);
function pagePusher($last_page,$page){
    if ($page > 4){ echo '<p>...</p>';}
    for ($i=2;$i<$last_page;$i++){
        if ($i >= $page-2 && $i <= $page+2){
            echo ' ';
            if ($i!= $page){
                echo '<a href="/news/page'.$i.'" class="other">'.$i.'</a>';
                } else {
                echo '<a href="/news/page'.$i.'" class="current">'.$i.'</a>';
                }
            echo ' ';
            }
    }
    if ($page < $last_page-3){ echo '<p>...</p>';}
}
?>
        <div id="news">
            <div class="container">
                <div class="row">
                    <h2 class="wow fadeIn" data-wow-delay="0.1s">Демонстрационный <strong>блок новостей</strong> написанный с использованием MVC структуры.</h2>
                    <hr>
                    <div class="col-md-5 col-md-offset-1 wow fadeIn addlink" data-wow-delay="0.1s">
                        <a href ="/news/newpost" class="addlink" alt="Add New Post">Add New Post</a>
                    </div>
                    <div class="col-md-4 wow fadeIn paginator toppag" data-wow-delay="0.1s">
                        <p>Page:</p>
                        <a href="/news" class="other">1</a>
                        <?php pagePusher($last_page,$page) ?>
                        <a href="/news/page<?=$last_page?>" class="other"><?=$last_page?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach ($result as $res): ?>
        <div class="news">
        <div class="container">
            <div class="row">
                    <div class="col-md-11 col-md-offset-1 textworks">
                           <hr>
                           <p class="wow fadeIn" data-wow-delay="0.1s"><?= $res['head'] ?></p>
                           <hr>
                           <a href="<?='/news/'.$res['id'] ?>" class="wow fadeIn" data-wow-delay="0.1s">Refactor Post</a>
                    </div>
                    <div class="col-md-11 imageworks wow fadeIn" data-wow-delay="0.1s"">
                        <p class="wow fadeIn post" data-wow-delay="0.1s"><?= $res['post_text'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="paginator bottompag">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeIn" data-wow-delay="0.1s">
                        <p>Page:</p>
                        <a href="/news" class="other">1</a>
                        <?php pagePusher($last_page,$page) ?>
                        <a href="/news/page<?=$last_page?>" class="other"><?=$last_page?></a>
                    </div>
                </div>
            </div>
        </div>
<?= include (ROOT.'/templates/html/footer.php')?>
