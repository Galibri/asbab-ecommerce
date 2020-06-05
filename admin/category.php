<?php include_once './includes/header.php'; ?>
<?php include_once './includes/side_menubar.php'; ?>
<?php $title = admin_bc_title('Category'); ?>

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
                        include_once './category/view.php';
                        break;
                    case 'edit':
                        include_once './category/edit.php';
                        break;
                    case 'add':
                        include_once './category/add.php';
                        break;
                    case 'delete':
                        include_once './category/delete.php';
                        break;
                    default:
                        include_once './category/view.php';
                        break;
                }
            } else {
                include_once './category/view.php';
            }
            ?>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'includes/footer.php'; ?>