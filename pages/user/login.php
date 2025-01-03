<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div class="card shadow-sm rounded" style="width: 25rem;">
    <div class="card-body">
      <h2 class="text-center text-success mb-4">Login</h2>
      <form action="<?= BASE_URL ?>page=doLogin" method="POST" id="formLogin">
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
            value="<?= isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>" required />
        </div>
        <div class="mb-3">
          <label for="pwd" class="form-label">Password:</label>
          <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd"
            autocomplete="new-password" value="<?= isset($_COOKIE['pswd']) ? $_COOKIE['pswd'] : '' ?>" required />
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="remember" name="remember" <?= isset($_COOKIE['remember']) && $_COOKIE['remember'] == "1" ? 'checked' : '' ?> />
          <label class="form-check-label" for="remember"> Remember me </label>
        </div>
        <div class="text-end mb-3">
          <a href="<?= BASE_URL ?>page=forgotPassword" class="text-decoration-none">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>
    </div>
  </div>
</div>