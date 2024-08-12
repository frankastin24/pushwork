<?php 

get_header();

global $errors;

?>

<div class="container">
    <h1>Log In</h1>
    <p>Don't have an account? <a href="/register-freelancer">Sign up as a Freelancer</a>  <a href="/post-job">Or as a Buyer</a></p>

    <form action="" method="post">
    
    <input type="hidden" name="is_login" value="true"/>

    <div class="field <?= $errors['email'] ? 'error' : '' ;?>">
    <h4>EMAIL</h4>

    <input type="email" name="email"/>
       <p class="error-text">Email is incorrect</p>
    </div>

    <div class="field <?= $errors['password'] ? 'error' : '' ;?>">
    <h4>PASSWORD</h4>
    <input type="password" name="password"/>
    <p class="error-text">Password is incorrect</p>
    </div>
    <div class="field">
    <a href="/forgot-password">Forgot password?</a>
    </div>

    <button type="submit" id="submit-login">LOG  IN</button>
    </form>
</div>