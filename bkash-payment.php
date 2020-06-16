<?php require_once('./includes/header.php'); ?>
<?php
if(!isset($_GET['order-id'])) {
    redirect('profile.php?tab=orders');
} else {
    $order_id = (int) sanitize($_GET['order-id']);
}
// Order authentication
$profile_id = get_user_id_by_username($_SESSION['username']);
if(!authenticate_order_info($order_id, $profile_id)) {
    redirect('access_denied.php');
}

$order_details = get_user_order_info();

$asking_currency = 'BDT';

$final_price_to_pay = convert_price_in_asking_currency( $asking_currency, $order_details['order_total'] );

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
                            <span class="breadcrumb-item active">bKash Payment</span>
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
            <div class="col-md-12 text-center">
                <h2>You are going to pay <?php printf("%.2f", $final_price_to_pay);  ?> using bKash.</h2>
                <br><br>
                <input type="hidden" id="order_total" value="<?php printf("%.2f", $final_price_to_pay); ?>">
                <button id="bKash_button" class="btn btn-danger btn-lg fr__btn" disabled="disabled">Pay With bKash</button>
            </div>
        </div>
    </div>
</div>

<?php require_once('./includes/footer.php'); ?>

<script>
(function($) {

let paymentID;

let createCheckoutUrl = 'https://merchantserver.sandbox.bka.sh/api/checkout/v1.2.0-beta/payment/create';
let executeCheckoutUrl = 'https://merchantserver.sandbox.bka.sh/api/checkout/v1.2.0-beta/payment/execute';

$(document).ready(function () {
	initBkash();
});


function initBkash() {

    let order_total = $('#order_total').val();

	bKash.init({

	  paymentMode: 'checkout', // Performs a single checkout.
      paymentRequest: {"amount": order_total, "intent": 'sale'},

      createRequest: function (request) {
        $.ajax({
          url: createCheckoutUrl,
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(request),
          success: function (data) {
              
            if (data && data.paymentID != null) {
              paymentID = data.paymentID;
              bKash.create().onSuccess(data);
            } 
            else {
              bKash.create().onError(); // Run clean up code
              alert(data.errorMessage + " Tag should be 2 digit, Length should be 2 digit, Value should be number of character mention in Length, ex. MI041234 , supported tags are MI, MW, RF");
            }

          },
          error: function () {
            bKash.create().onError(); // Run clean up code
            alert(data.errorMessage);
          }
        });
      },
      executeRequestOnAuthorization: function () {
        $.ajax({
          url: executeCheckoutUrl,
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({"paymentID": paymentID}),
          success: function (data) {

            if (data && data.paymentID != null) {
              // On success, perform your desired action
              alert('[SUCCESS] data : ' + JSON.stringify(data));
              window.location.href = "/success_page.html";

            } else {
              alert('[ERROR] data : ' + JSON.stringify(data));
              bKash.execute().onError();//run clean up code
            }

          },
          error: function () {
            alert('An alert has occurred during execute');
            bKash.execute().onError(); // Run clean up code
          }
        });
      },
      onClose: function () {
        alert('User has clicked the close button');
      }
    });

    $('#bKash_button').removeAttr('disabled');

}

})(jQuery)
</script>