<?= include(ROOT.'/templates/html/head.php')?>
<?= include(ROOT.'/templates/html/navbar.php')?>
<div id="onepost">
    <div class="news">
        <div class="container">
            <div class="row">
                <form class="addpost" method="post" action="">
                <div class="col-md-11 col-md-offset-1">
                    <div class="textworks">
                        <a class="wow fadeIn updateinfo" data-wow-delay="0.1s" href="<?='/news/'.$result['id']?>"><?= $update_result?></a>
                        <hr>
                        <p>Head</p>
                        <textarea required name="head" class="wow fadeIn update head" data-wow-delay="0.1s" placeholder="Post Head"><?= $result['head'] ?></textarea>
                        <hr>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="imageworks wow fadeIn" data-wow-delay="0.1s">
                        <p>Post Text</p>
                        <textarea required name="post_text" class="wow fadeIn update post" data-wow-delay="0.1s" placeholder="Post Text"><?= $result['post_text'] ?></textarea>
                        <div class="col-md-5 col-md-offset-1">
                        <p>Category</p>
                        <textarea required name="division" class="wow fadeIn update division" data-wow-delay="0.1s" placeholder="Post Category"><?= $result['division'] ?></textarea>
                        </div>
                        <div class="col-md-5">
                            <input class="updatebutton" type="submit" value="update">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= include (ROOT.'/templates/html/footer.php')?>
