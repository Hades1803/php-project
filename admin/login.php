
<link rel="stylesheet" href="../asset/css/admin/style.css">
<div class="wrapper">
  <div class="container">
    <div class="col-left">
      <div class="login-text">
        <h2>Welcome Admin</h2>
        <p>Create your account.<br>It's totally free.</p>
        <a class="btn" href="">Sign Up</a>
      </div>
    </div>
    <div class="col-right">
      <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="doLogin.php">
          <p>
            <label>Username or email address<span>*</span></label>
            <input type="text" placeholder="Username or Email" required name="email">
          </p>
          <p>
            <label>Password<span>*</span></label>
            <input type="password" placeholder="Password" required name="pswd">
          </p>
          <p>
            <input type="submit" value="Sing In" />
          </p>
          <p>
            <a href="">Forget Password?</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>