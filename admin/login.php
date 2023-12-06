<?php
include_once '../config/Database.php';
include_once './class/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$loginMessage = '';
if (!empty($_POST["login"]) && $_POST["email"] != '' && $_POST["password"] != '') {
    $user->setEmail($_POST["email"]);
    $user->setPassword($_POST["password"]);
    if ($user->login()) {
        header("location: dashboard.php");
    } else {
        $loginMessage = 'Invalid login! Please try again.';
    }
}
include('Cpn/header.php');
?>
<div class="col-md-6">
    <div class="panel panel-info">
        <div class="panel-heading" style="background:#00796B;color:white;">
            <div class="panel-title">Admin In</div>
        </div>
        <div style="padding-top:30px" class="panel-body">
            <?php if ($loginMessage != '') { ?>
                <div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $loginMessage; ?></div>
            <?php } ?>
            <form id="loginform" class="form-horizontal" role="form" method="POST" action="">
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" id="email" name="email" placeholder="email" style="background:white;" required>
                </div>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                </div>
                <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                        <input type="submit" name="login" value="Login" class="btn btn-info">
                    </div>
                </div>
                <div style="margin-top:10px" class="form-group">
                    <div class="col-sm-12 controls">
                        User: admin@admin.com<br>
                        password:123
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('Cpn/footer.php');?>
