<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>

<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-md-9 login">
                <form method="post" action="">
                    <p>Login <span><?= $msg?></span></p>
                    <input required type="name" name="login" placeholder="Login..">
                    <p>Password</p>
                    <input required type="password" name="password" placeholder="Password..">
                    <input class="sbm" type="submit" value="Sign in">
                    <a href="/account/registration">Sign up.</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= include ROOT.'/templates/html/footer.php'?>
