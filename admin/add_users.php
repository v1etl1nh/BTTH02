<?php

include_once '../config/Database.php';
include_once 'class/User.php';
include_once 'class/Post.php';
include_once 'class/Category.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$post = new Post($db);
$category = new Category($db);

if(!$user->loggedIn()) {
	header("location: index.php");
}

$user->setId((isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null);
$saveMessage = '';

if (!empty($_POST["saveUser"]) && $_POST["email"] != '') {
    $user->setFirstName($_POST["first_name"]);
    $user->setLastName($_POST["last_name"]);
    $user->setEmail($_POST["email"]);
    $user->setType($_POST["user_type"]);
    $user->setDeleted($_POST["user_status"]);

    if ($user->getId()) {
        //$user->setUpdated(date('Y-m-d H:i:s'));
        if ($user->update()) {
            $saveMessage = "User updated successfully!";
        }
    } else {
        $user->setPassword($_POST["password"]);
        $lastInsertId = $user->insert();
        if ($lastInsertId) {
            $user->setId($lastInsertId);
            $saveMessage = "User saved successfully!";
        }
    }
}

$userDetails = $user->getUser();
 
include('Cpn/header.php');
?>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/posts.js"></script>	
<link href="css/style.css" rel="stylesheet" type="text/css" >  
</head>
<body>
<?php include "menus.php"; ?>
<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard <small>Manage Your Site</small></h1>
			</div>
			<br>			
		</div>
	</div>
</header>
<br>
<section id="main">
	<div class="container">
		<div class="row">	
			<?php include "left_menus.php"; ?>
			<div class="col-md-9">
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title">Add / Edit User</h3>
				  </div>
				  <div class="panel-body">
				  
					<form method="post" id="postForm">							
						<?php if ($saveMessage != '') { ?>
							<div id="login-alert" class="alert alert-success col-sm-12"><?php echo $saveMessage; ?></div>                            
						<?php } ?>
						<div class="form-group">
							<label for="title" class="control-label">First Name</label>
							<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($userDetails['first_name'])?$userDetails['first_name']:null; ?>" placeholder="First name..">							
						</div>
						
						<div class="form-group">
							<label for="title" class="control-label">Last Name</label>
							<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($userDetails['last_name'])?$userDetails['last_name']:null; ?>" placeholder="Last name..">							
						</div>
						
						<div class="form-group">
							<label for="title" class="control-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo isset($userDetails['email'])?$userDetails['email']:null; ?>" placeholder="email..">							
						</div>					
						<?php 
						if(!$user->getId()) {	
						?>
						<div class="form-group">
							<label for="title" class="control-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" value="<?php echo isset($userDetails['password'])?$userDetails['password']:null; ?>" placeholder="password..">							
						</div>	
						<?php } ?>						
											
						<div class="form-group">
							<label for="status" class="control-label">User Type </label>							
							<label class="radio-inline">
								<input type="radio" name="user_type" id="admin" value="1" <?php if(isset($userDetails['type']) && $userDetails['type'] == 1) { echo "checked";} ?>>Administrator
							</label>
							<label class="radio-inline">
								<input type="radio" name="user_type" id="author" value="2" <?php if(isset($userDetails['type']) && $userDetails['type'] == 2) { echo "checked";} ?>>Author
							</label>												
						</div>		

						<div class="form-group">
							<label for="status" class="control-label">User Status </label>							
							<label class="radio-inline">
								<input type="radio" name="user_status" id="active" value="0" <?php if(!isset($userDetails['deleted'])) { echo "checked";} ?>>Active
							</label>
							<label class="radio-inline">
								<input type="radio" name="user_status" id="inactive" value="1" <?php if(isset($userDetails['deleted'])) { echo "checked";} ?>>Inactive
							</label>												
						</div>	
						
						<input type="submit" name="saveUser" id="saveUser" class="btn btn-info" value="Save" />											
					</form>				
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include('Cpn/footer.php');?>
