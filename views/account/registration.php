<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>

<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-md-10 login">
                <form method="post" action="">
                    <ul>
                        <li><p>Login <span><?= $msg?></span></p>
                            <input required type="name" name="login" placeholder="Login.."></li>
                        <li><p>Password</p>
                            <input required type="password" name="password" placeholder="Password.."></li>
                        <li><p>FirstName</p>
                            <input type="text" name="firstname" placeholder="Your name.."></li>
                        <li><p>Surname</p>
                            <input type="text" name="surname" placeholder="Your surname.."></li>
                        <li><p>Male<input type="radio" class="rad" name="gender" value="1"></p>
                            <p>Female<input type="radio" class="rad" name="gender" value="2"></p></li>
                        <li><p>Birth Date</p>
                            <input type="date" name="birth_date"></li>
                        <li><input class="sbm" type="submit" value="Sign up"></li>
                        <li><a href="/account/login">Sign in</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

<?= include ROOT.'/templates/html/footer.php'?>
