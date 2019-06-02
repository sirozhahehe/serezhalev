<?php $i = 1;
/** defines even of number. needs for correct page display according to page design. echo 1 or 2*/
function even($i){if ($i%2 == 0){ echo 2; } else { echo 1; } }
/** needs for saving condition of options after reloading page. echo option's order with correct selected option */
function optionPusher($gender){ switch ($gender) {
    case 0: echo'<option selected value="0">All</option><option value="3">Not selected</option><option value="1">Male</option><option value="2">Female</option>'; break;
    case 3: echo'<option value="0">All</option><option selected value="3">Not selected</option><option value="1">Male</option><option value="2">Female</option>'; break;
    case 1: echo'<option value="0">All</option><option value="3">Not selected</option><option selected value="1">Male</option><option value="2">Female</option>'; break;
    case 2: echo'<option value="0">All</option><option value="3">Not selected</option><option value="1">Male</option><option selected value="2">Female</option>'; break;
}}
/** needs for saving condition of options after reloading page. echo option's order with correct selected option */
function orderPusher($order){ switch ($order){
    case 'login': echo '<option selected value="login">Login</option><option value="firstname">FirstName</option><option value="surname">SurName</option><option value="birth_date">Birth Date</option>'; break;
    case 'firstname': echo '<option value="login">Login</option><option selected value="firstname">FirstName</option><option value="surname">SurName</option><option value="birth_date">Birth Date</option>'; break;
    case 'surname': echo '<option value="login">Login</option><option value="firstname">FirstName</option><option selected value="surname">SurName</option><option value="birth_date">Birth Date</option>'; break;
    case 'birth_date': echo '<option value="login">Login</option><option value="firstname">FirstName</option><option value="surname">SurName</option><option selected value="birth_date">Birth Date</option>'; break;
    default: echo '<option value="login">Login</option><option value="firstname">FirstName</option><option value="surname">SurName</option><option value="birth_date">Birth Date</option>'; break;
}}
/** needs for saving condition of options after reloading page. echo option's order with correct selected option */
function orderTypePusher($order_type){ switch($order_type){
    case 1: echo '<option selected value="1">Low to high</option><option value="2">High to low</option>'; break;
    case 2: echo '<option value="1">Low to high</option><option selected value="2">High to low</option>'; break;
    default: echo '<option value="1">Low to high</option><option value="2">High to low</option>'; break;
}}
$last_page = ceil($count/5);
/** needs for displaying available pages */
function pagePusher($last_page,$page){
    if ($page > 4){ echo '<p>...</p>';}
    for ($i=2;$i<=$last_page;$i++){
        if ($i >= $page-2 && $i <= $page+2){
            echo ' ';
            if ($i!= $page){
                echo '<a href="/account/page'.$i.'" class="other">'.$i.'</a>';
            } else {
                echo '<a href="/account/page'.$i.'" class="current">'.$i.'</a>';
            }
            echo ' ';
        }
    }
    if ($page < $last_page-3){ echo '<p>...</p>';}
}
?>
<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>
    <div id="myworks">
        <div class="container">
            <div class="row">
                <div class="users col-md-5 wow fadeIn" data-wow-delay="0.1s">
                    <h1 title="Демонстрационный блок Accounts написанный с использованием MVC структуры.">Users info.</h1>

                    <!-- alert message needs for display that user trying to do not allowed calls-->
                    <p><?= $_SESSION['msg']?></p>

                    <!-- display username if user signed in -->
                    <p><?php if ($_SESSION['login']){ echo '<a href="/account/user/'.$_SESSION['login'].'">User: '.$_SESSION['login'].'</a>';} ?></p>
                </div>
                <div class="col-md-5 users wow fadeIn" data-wow-delay="0.1s">
                    <form action="" method="post">
                        <input type="text" name="keyword" value="<?= $_SESSION['keyword']?>" placeholder="Keyword">
                        <input type="date" name="birth_date" value="<?= $_SESSION['birth_date']?>">
                        <select name="gender">
                            <option disabled>Choose gender</option>
                            <?php optionPusher($_SESSION['gender']);?>
                        </select>
                        <select name="order">
                            <option disabled>Choose sort column</option>
                            <?php orderPusher($_SESSION['order']);?>
                        </select>
                        <select name="order_type">
                            <option disabled>Choose sorting type</option>
                            <?php orderTypePusher($_SESSION['order_type']);?>
                        </select>
                        <input type="submit" value="Sort">
                    </form>
                </div>
                <div class="col-md-2 users wow fadeIn" data-wow-delay="0.1s">
                    <?php if ($_SESSION['login']){
                        echo '<a href="/account/logout">Sign out</a>';
                    } else {
                        echo '<a href="/account/login">Sign in</a>
                    <a href="/account/registration">Sign up</a>';
                    }
                        ?>
                </div>
                <div class="col-md-4 wow fadeIn paginator toppag" data-wow-delay="0.1s">
                    <p>Page:</p>
                    <a href="/account" class="other">1</a>
                    <?php pagePusher($last_page,$page) ?>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php foreach($result as $res):?>
    <div class="user<?php even($i); ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="user_list wow fadeIn" data-wow-delay="0.1s">
                        <li><span>Login:</span> <?= $res['login'];?> </li>
                        <li><span>FirstName:</span> <?= $res['firstname'];?> </li>
                        <li><span>SurName:</span> <?= $res['surname'];?> </li>
                        <br>
                        <li><span>Gender:</span> <?= $res['gender'];?> </li>
                        <li><span>Birth Date:</span> <?= $res['birth_date'];?> </li>
                        <li><a href="/account/user/<?=$res['login'];?>">More..</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php $i++ ?>
<?php endforeach; ?>
<?= include ROOT.'/templates/html/footer.php'?>