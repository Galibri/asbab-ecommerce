<?php require_once('./includes/header.php'); ?>
<?php
if(isset($_GET['order-id'])) {
    $order_id = (int) sanitize($_GET['order-id']);
}
?>
<div class="ht__bradcaump__area"
    style="background: rgba(0, 0, 0, .10) url(uploads/theme/breadcrumb.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item" href="<?php echo site_url(); ?>">Home</a>
                            <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                            <span class="breadcrumb-item active">Access Denied</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Huh! You are cheating...</h3>
            </div>
        </div>
    </div>
</div>

<?php require_once('./includes/footer.php'); ?>