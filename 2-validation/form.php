<?php

function validate_message($message)
{
    // function to check if message is correct (must have at least 10 characters (after trimming))
    return strlen(trim($message)) >= 10;
}

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')
    return ctype_alnum($username);
}

function validate_email($email)
{
    // function to check if email is correct (must contain '@')
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";


$form_valid = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here is the list of error messages that can be displayed:
    $username = strip_tags($_POST['username']);
    $email = strip_tags($_POST['email']);
    $message = strip_tags($_POST['message']);
    
    $terms = isset($_POST['terms']);
    // "Message must be at least 10 caracters long"
    if (!validate_message($message)) {
        $message_error = "Message must be at least 10 characters long";
    }
    // "You must accept the Terms of Service"
    if (!$terms) {
        $terms_error = "You must accept the Terms of Service";
    }
    // "Please enter a username"
    if (empty($username)) {
        $user_error = "Please enter a username";
    } 
    // "Username should contains only letters and numbers"
    elseif (!validate_username($username)) {
        $user_error = "Username should contain only letters and numbers";
    }
    // "Please enter an email"
    if (empty($email)) {
        $email_error = "Please enter an email";
    } 
    // "email must contain '@'"
    elseif (!validate_email($email)) {
        $email_error = "Email must contain '@'";
    }
    if (empty($user_error) && empty($email_error) && empty($terms_error) && empty($message_error)) {
        $form_valid = true;
    }

}

?>

<form  action = "#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username" value="<?php echo ($form_valid==false)? htmlspecialchars($username, ENT_QUOTES, 'UTF-8'):""; ?>">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo ($form_valid==false)? htmlspecialchars($email, ENT_QUOTES, 'UTF-8'):""; ?>">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"><?php echo ($form_valid==false)? htmlspecialchars($message, ENT_QUOTES, 'UTF-8'):""; ?></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms"> <label for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')); ?></p>
        </div>
    </div>
<?php
endif;
?>