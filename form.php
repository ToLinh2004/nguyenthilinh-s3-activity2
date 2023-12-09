<?php

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')
    if (!ctype_alnum(trim($username))) {
        return "Username should contains only letters and numbers";
    } else {
        return "";
    }
}

function validate_message($message)
{
   
    if (strlen(trim($message)) < 10) {
        return "Message must be at least 10 caracters long";
    } else {
        return "";
    }
}

function validate_email($email)
{
    // function to check if email is correct (must contain '@')
    if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
        return " Must contain @";
    } else {
        return "";
    }
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
    //
    // "Message must be at least 10 caracters long"
    // "You must accept the Terms of Service"
    // "Please enter a username"
    // "Username should contains only letters and numbers"
    // "Please enter an email"
    // "email must contain '@'"
    if (isset($_POST['username'])) {
        $user_error = validate_username($_POST['username']);
        if ($_POST['username'] == "") {
            $user_error = "Please enter a username";
        } else {
            if ($user_error == "") {
                $username = $_POST['username'];
            } else {
                $user_error;
            }
        }
    }

    if (isset($_POST['message'])) {
        $message_error = validate_message($_POST['message']);
        if ($message_error == "") {
            $message = $_POST['message'];
        } else {
            $message_error;
        }
    }
   
    if (isset($_POST['email'])) {
        $email_error = validate_email($_POST['email']);
        if ($email_error == "") {
            $email = $_POST['email'];
        } else {
            $email_error;
        }
    }

    if (empty($_POST['terms'])) {
        $terms_error = "You must accept the Terms of Service";
    }
}
if ($message_error == "" && $email_error == "" && $user_error == ""  && $terms_error == "") {
    $form_valid = true;
    $message = htmlspecialchars($message);
}
?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
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
            <p><?php echo $username; ?></p>
            <p><?php echo $email; ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $message; ?></p>
        </div>
    </div>
<?php
endif;
?>