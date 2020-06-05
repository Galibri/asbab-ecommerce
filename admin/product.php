<?php include_once './includes/header.php'; ?>
<?php include_once './includes/side_menubar.php'; ?>
<?php $title = admin_bc_title('Product'); ?>

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
                        include_once './product/view.php';
                        break;
                    case 'edit':
                        include_once './product/edit.php';
                        break;
                    case 'add':
                        include_once './product/add.php';
                        break;
                    case 'delete':
                        include_once './product/delete.php';
                        break;
                    default:
                        include_once './product/view.php';
                        break;
                }
            } else {
                include_once './product/view.php';
            }
            ?>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'includes/footer.php'; ?>