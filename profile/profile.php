<?php
    $error = '';
    $profiledata = array();
    if (isset($_POST['profile_submit'])) {
        $profiledata['email'] = sanitize($_POST['email']);
        $profiledata['first_name'] = sanitize($_POST['first_name']);
        $profiledata['last_name'] = sanitize($_POST['last_name']);
        $profiledata['phone'] = sanitize($_POST['phone']);

        if (empty($email)) {
            $error = "Email can't be empty";
        } else {
            $result = update_data_into_database('users', $profiledata, $id);
            if ($result) {
                redirect('profile.php?message=editsuccess');
            }
        }
    }
?>

<h3>Profile</h3>
<div class="divider"></div>
<?php echo flash_message(); ?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <div class="form-group">
        <label for="name">Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" disabled="disabled">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
        <?php echo !empty($error) ? "<span class='text-danger'>{$error}</span>" : ''; ?>
    </div>
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
    </div> 
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
    </div>
    <div class="form-group">
        <button class="btn btn-info" name="profile_submit" type="submit">Save Profile</button>
    </div>
</form>