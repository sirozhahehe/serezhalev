<?php
/** needs for correct display of gender */
function optionPusher($gender){ switch ($gender) {
    default: echo '<option value="3">Not selected</option><option value="1">Male</option><option value="2">Female</option>'; break;
    case 'Not selected': echo'<option selected value="3">Not selected</option><option value="1">Male</option><option value="2">Female</option>'; break;
    case 'Male': echo'<option value="3">Not selected</option><option selected value="1">Male</option><option value="2">Female</option>'; break;
    case 'Female': echo'<option value="3">Not selected</option><option value="1">Male</option><option selected value="2">Female</option>'; break;
}}?>
<?= include ROOT.'/templates/html/head.php'?>
<?= include ROOT.'/templates/html/navbar.php'?>
    <div id="myworks">
        <div class="container">
            <div class="row">
                <div class="users wow fadeIn" data-wow-delay="0.1s">
                    <h1><?= $result['login']?></h1>
                    <p><?= $_SESSION['edit_msg']?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="user3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="user_list wow fadeIn" data-wow-delay="0.1s"">
                        <form action="/account/user/edit/<?= $result['login']?>" method="post">
                        <li><span>Login:</span> <?= $result['login'];?> </li>
                        <li><span>FirstName:</span> <input type="text" name="firstname" value="<?= $result['firstname'];?>" placeholder="FirstName.."></li>
                        <li><span>SurName:</span> <input type="text" name="surname" value="<?= $result['surname'];?>" placeholder="SurName"></li>
                        <br>
                        <li><span>Gender:</span>
                            <select name="gender">
                                <option disabled>Choose gender</option>
                                <?php optionPusher($result['gender'])?>
                            </select></li>
                        <li><span>Birth Date:</span> <input type="date" name="birth_date" value="<?= $result['birth_date'];?>"> </li>
                        <li><input type="submit"  value="Edit.."></li>
                        </form>
                    <?php if ($result['login'] == 'root'){
                        echo '<a>Remove Acc..</a>';
                    } else {
                        echo '<a href="/account/user/remove/'.$result['login'].'">Remove Acc..</a>'; }?>
                    <a href="/account/user/editpw/<?=$result['login']?>">Edit Password..</a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?= include ROOT.'/templates/html/footer.php'?>