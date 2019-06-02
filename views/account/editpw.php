<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>

<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-md-9 login">
                <form method="post" action="">
                    <p><span><?= $_SESSION['edit_msg']?></span></p>
                    <p>Enter new password</p>
                    <input required type="password" name="password" placeholder="Password..">
                    <input class="sbm" type="submit" value="Change">
                    <a href="/account/user/<?= $login ?>">Back..</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= include ROOT.'/templates/html/footer.php'?>
