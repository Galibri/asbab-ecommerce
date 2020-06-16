<?php include_once './includes/header.php'; ?>
<?php include_once './includes/side_menubar.php'; ?>
<?php $title = isset($_GET['order-id']) ? admin_bc_title('Order Details') : admin_bc_title('Orders'); ?>

<div class="content-wrapper">
    <?php include_once './includes/breadcrumb.php'; ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo flash_message(); ?>
                </div>
            </div>
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
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'includes/footer.php'; ?>