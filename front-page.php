<?php get_header('fullwidth'); ?>

<div class="cja_splash">
    <!--<h1 class="header">We Connect Young People and Opportunity</h1>-->
    <div class="splash_login_box">
        <h4>Login</h4>
        <form action="<?php echo get_site_url(); ?>/wp-login.php" method="post" class="cja_home_login">
            <div class="topbox">
                <div class="username">
                    <p>Username</p>
                    <input type="text" name="log">
                </div>
                <div class="password">
                    <p>Password</p>
                    <input type="password" name="pwd">
                </div>
            </div>
            <input type="hidden" name="redirect_to" value="<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>">
            <div class="login">
                <p class="input-right"><input class="cja_button cja_button--home_login" name="wp-submit" type="submit" value="Log In"></p>
            </div>
        </form>
        <hr>
        <h4 class="account_create">Create an Account</h4>
        <form action="<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>" method="post" class="cja_home_create">
            <div class="topbox">
                <div class="username">
                    <p>Username</p>
                    <input type="text" name="username">
                </div>
                <div class="password">
                    <p>Password</p>
                    <input type="password" name="password">
                </div>
            </div>
            <p>Email Address</p>
            <input type="text" name="email">
            <div class="rolebox">
                <div class="role_option">
                    <input type="radio" name="role" value="jobseeker" checked> I am looking for a job or course</input>
                </div>
                <div class="role_option">
                    <input type="radio" name="role" value="employer"> I am an employer or course provider</input>
                </div>
            </div>
            <input type="hidden" name="createaccount" value="true">
            <p class="input-right"><input class="cja_button cja_button--home_login" type="submit" value="Create Free Account"></p>
        </form>
    </div>
</div>

<?php get_footer(); ?>