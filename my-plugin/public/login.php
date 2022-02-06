<?php
// redirect if assessed directly
if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}
?>

<div class="login-form">
    <h2>Login</h2>
    <form action="<?php echo get_the_permalink();?>" method="post">
        Username: <input type="text" name="username" id="login-username"><br/>
        Password: <input type="password" name="pass" id="login-pass"><br/>
        <input type="submit" name="user_login" value="login">
    </form>
</div>