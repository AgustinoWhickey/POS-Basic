<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="<?= base_url(); ?>assets/img/login.jpg"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h1 class="text-center mb-4">Login</h1>
        <form class="user" method="post" action="<?= base_url('auth'); ?>">
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>"/>
            <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />
            <?= form_error('password','<small class="text-danger pl-3">','</small>'); ?>
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>

          <br>

          <div class="d-flex justify-content-around align-items-center mb-4">
            <a href="#!">Forgot password?</a>
            <a href="#!">Create an Account!</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>