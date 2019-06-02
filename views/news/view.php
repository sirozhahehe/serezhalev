<?= include(ROOT.'/templates/html/head.php')?>
<?= include(ROOT.'/templates/html/navbar.php')?>
    <div class="news">
        <div class="container">
            <div class="row">
                    <div class="col-md-11 col-md-offset-1 onepost">
                       <div class="textworks">
                           <hr>
                           <p class="wow fadeIn" data-wow-delay="0.1s"><?= $result_id['head'] ?></p>
                           <hr>
                           <a href="<?= '/news/update/'.$result_id['id'] ?>" target="_blank" class="wow fadeIn" data-wow-delay="0.1s">Refactor Post</a>
                       </div>
                    </div>
                    <div class="col-md-11">
                       <div class="imageworks wow fadeIn" data-wow-delay="0.1s">
                           <p class="wow fadeIn post" data-wow-delay="0.1s"><?= $result_id['post_text'] ?></p>
                           <p class="wow fadeIn" data-wow-delay="0.1s"><?= $result_id['post_date'] ?></p>
                           <p class="wow fadeIn" data-wow-delay="0.1s"><?= $result_id['division'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?= include (ROOT.'/templates/html/footer.php')?>
