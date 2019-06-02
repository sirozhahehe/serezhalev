<?= include(ROOT.'/templates/html/head.php')?>
<?= include(ROOT.'/templates/html/navbar.php')?>
<div id="onepost">
    <div class="news">
        <div class="container">
            <div class="row">
                <form class="addpost" method="post" action="">
                    <div class="col-md-11 col-md-offset-1 textworks">
                            <p class="updateinfo"><?= $result?></p>
                            <hr>
                            <p>Head</p>
                            <textarea required name="head" class="wow fadeIn update head" data-wow-delay="0.1s" placeholder="Post Head"></textarea>
                            <hr>
                    </div>
                    <div class="col-md-12 imageworks wow fadeIn" data-wow-delay="0.1s">
                            <p>Post Text</p>
                            <textarea required name="post_text" class="update post"placeholder="Post Text"></textarea>
                            <div class="col-md-5 col-md-offset-1">
                                <p>Category</p>
                                <textarea required name="division" class="update division" placeholder="Post Category"></textarea>
                            </div>
                            <div class="col-md-5">
                                <input class="updatebutton" type="submit" value="add post">
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= include (ROOT.'/templates/html/footer.php')?>
