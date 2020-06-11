<?php
/**
 * Faster data transfer using file_get_contents
 */
function send_message_to_slack($message = '') {
    $data = array(
        'text' => $message
    );
    $postdata = json_encode($data);

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $context  = stream_context_create($opts);
    $result = file_get_contents('https://hooks.slack.com/services/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', false, $context);

    if($result) {
        return true;
    }
    return false;

}

if(isset($_POST['send'])) {
    if(!empty($_POST['text'])) {
        if(send_message_to_slack($_POST['text'])) {
            echo "Message sent";
        } else {
            echo "Something went wrong";
        }
    }
}

?>


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <input type="text" name="text">
    <input type="submit" value="Send" name="send">
</form>