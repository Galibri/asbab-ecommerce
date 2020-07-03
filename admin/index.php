<?php include_once './includes/header.php'; ?>
<?php include_once './includes/side_menubar.php'; ?>
<?php $title = admin_bc_title('Dashboard'); ?>


<div class="content-wrapper">
    <?php include_once './includes/breadcrumb.php'; ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- widget start -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Categories</span>
                            <span class="info-box-number">
                                <?php echo count_item('categories'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Products</span>
                            <span class="info-box-number">
                                <?php echo count_item('products'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Orders</span>
                            <span class="info-box-number">
                                <?php echo count_item('orders'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <span class="info-box-number">
                                <?php echo count_item('users'); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- widget end -->
            </div>
            <div class="row mt-5">
                <div class="col-lg-12">
                <?php
                if (isset($_REQUEST['action'])) {
                    $action = $_REQUEST['action'];
                    switch ($action) {
                        case 'view':
                            include_once './order/view.php';
                            break;
                        case 'details':
                            include_once './order/details.php';
                            break;
                        case 'delete':
                            include_once './order/delete.php';
                            break;
                        default:
                            include_once './order/view.php';
                            break;
                    }
                } else {
                    include_once './order/view.php';
                }
                ?>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'includes/footer.php'; ?>