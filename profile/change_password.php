<?php
    $error = '';
    if(isset($_POST['password_submit'])) {
        $password = sanitize($_POST['password']);
        $retype_password = sanitize($_POST['retype_password']);

        if(empty($password)) {
            $error = "Password can't be empty";
        } else {
            if ($password != $retype_password) {
                $error = "Password didn't match";
            } else {
                $result = update_data_into_database('users', array('password' => $password), $id);
                if($result) {
                    redirect('profile.php?tab=change-password&message=editsuccess');
                }
            }
        }
    }
?>

<h3>Profile</h3>
<div class="divider"></div>
<?php echo flash_message();?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" name="password" class="form-control">
        <?php echo !empty($error) ? "<span class='text-danger'>{$error}</span>" : ''; ?>
    </div>
    <div class="form-group">
        <label for="retype_password">Retype New Password</label>
        <input type="password" name="retype_password" class="form-control">
    </div>
    <div class="form-group">
        <button class="btn btn-info" name="password_submit" type="submit">Update Password</button>
    </div>
</form>