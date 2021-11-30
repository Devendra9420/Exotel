<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4 style="padding-left: 10px;"> </h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
			  
			  
			  <div class="form-background">
  <div class="login-box">
    <div class="login-logo">
      <h2 style="display: none;"><a href="<?= base_url('admin'); ?>"><?= $this->general_settings['application_name']; ?></a></h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><?= trans('signin_to_start_your_session') ?></p>

        <?php $this->load->view('admin/includes/_messages.php') ?>
        
        <?php echo form_open(base_url('auth/login'), 'class="login-form" '); ?>
          <div class="form-group has-feedback">
            <input type="text" name="username" id="name" class="form-control" placeholder="<?= trans('username') ?>" >
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="<?= trans('password') ?>" >
          </div>
          <div class="row">
            <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> <?= trans('remember_me') ?>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="<?= trans('signin') ?>">
            </div>
            <!-- /.col -->
          </div>
        <?php echo form_close(); ?>

        <p class="mb-1">
          <a href="<?= base_url('auth/forgot_password'); ?>"><?= trans('i_forgot_my_password') ?></a>
        </p>
        <p class="mb-0">
          <a href="<?= base_url('auth/register'); ?>" class="text-center"><?= trans('register_new_membership') ?></a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</div>
       </div>
        </div>
        <!-- END SAMPLE FORM box-->
    </div>
</div>