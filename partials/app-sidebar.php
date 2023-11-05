<?php
	$user = $_SESSION['user'];
?>

<div class="dashboard_sidebar" id="dashboard_sidebar">
	<h3 class="dashboard_logo" id="dashboard_logo">DMS</h3>
	<div class="dashboard_sidebar_user">
		<img src="images/user/user1.jpg" alt="User image." id="userImage" /> 
		<span><?= $user['first_name'] .' '. $user['last_name'] ?> </span>
	</div>
	<div class="dashboard_sidebar_menu">
		<ul class="dashboard_menu_lists">
			<li class="liMainMenu">
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-tag showHideSubMenu" ></i>
					<span class="menuText showHideSubMenu" >Product</span>
					<i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu" ></i>
				</a>
 				<ul class="subMenus" >
					<li><a class="subMenuLink" href="./product-view.php"> <i class="fa fa-circle-o"></i> View Products</a></li>
					<li><a class="subMenuLink" href="./product-add.php"> <i class="fa fa-circle-o"></i> Add Products</a></li>
				</ul>	
			</li>
			<li class="liMainMenu" >
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-truck showHideSubMenu" ></i>
					<span class="menuText showHideSubMenu" >Supplier</span>
					<i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu" ></i>
				</a>
 				<ul class="subMenus" >
					<li><a class="subMenuLink" href="./supplier-view.php"> <i class="fa fa-circle-o"></i> View Suppliers</a></li>
					<li><a class="subMenuLink" href="./supplier-add.php"> <i class="fa fa-circle-o"></i> Add Supplier</a></li>	
				</ul>				
				
			</li>
			<li class="liMainMenu showHideSubMenu" >
				<a href="javascript:void(0);" class="showHideSubMenu" >
					<i class="fa fa-user-plus showHideSubMenu" ></i>
					<span class="menuText showHideSubMenu" >User</span>
					<i class="fa fa-angle-left mainMenuIconArrow showHideSubMenu" ></i>
				</a>
 				<ul class="subMenus" >
					<li><a class="subMenuLink" href="./users-view.php"> <i class="fa fa-circle-o"></i> View Users</a></li>
					<li><a class="subMenuLink" href="./users-add.php"> <i class="fa fa-circle-o"></i> Add Users</a></li>	
				</ul>					
			</li>
		</ul>
	</div>
</div>