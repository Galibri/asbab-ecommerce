<?php require_once('./includes/header.php'); ?>
<?php 
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
}
$user = get_userinfo_by_username($_SESSION['username']);
extract($user);
$tab = isset($_GET['tab']) ? sanitize($_GET['tab']) : '';
?>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, .10) url(uploads/theme/breadcrumb.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <span class="breadcrumb-item active">Hello <?php echo $_SESSION['username']; ?>!</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start Product Grid -->
<section class="htc__product__grid bg__white ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="bg-info <?php echo ($tab == '' || $tab == 'profile') ? 'active' : ''; ?>">
                        <a href="profile.php">Profile</a>
                    </li>
                    <li class="bg-info <?php echo ($tab == 'change-password') ? 'active' : '';?>">
                        <a href="profile.php?tab=change-password">Change Password</a>
                    </li>
                    <li class="bg-info <?php echo ($tab == 'orders') ? 'active' : '';?>">
                        <a href="profile.php?tab=orders">Orders</a>
                    </li>
                    <li class="bg-info <?php echo ($tab == 'message') ? 'active' : '';?>">
                        <a href="profile.php?tab=message">Messages</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <?php
                    switch ($tab) {
                        case 'profile':
                            include_once('profile/profile.php');
                            break;
                        
                        case 'change-password':
                            include_once('profile/change_password.php');
                            break;
                        
                        case 'orders':
                            include_once('profile/orders.php');
                            break;

                        case 'messages':
                            include_once('profile/messages.php');
                            break;
                        
                        default:
                            include_once('profile/profile.php');
                            break;
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- End Product Grid -->
<?php require_once('./includes/footer.php'); ?>