<?php get_header('fullwidth'); ?>

<div class="cja_splash">
    <div class="col-full"><?php
        
        // Display the login box or holding message only if user is not logged in
        if (!is_user_logged_in()) {

            // Display holding message if homepage not enabled
            if (!get_option('cja_display_homepage')) { ?><!--
                <div class="splash_login_box">
                    <h4 class="account_create">Coming Back Soon!</h4>
                    <p>We're putting the finishing touches to the new-look <strong>Courses and Jobs Advertiser</strong>!</p>
                    <p><strong>Search job and course ads</strong> from employers and course providers actively recruiting employees and students and apply online.</p>
                    <p><strong>Employers and Course Providers</strong> - place adverts and search CVs and students to find the right candidates for your opportunity.</p>
                    <p><strong>See you back on the site soon!</strong></p>
                </div>--> <?php

            // Otherwise display the login box
            } else { ?>
                <div class="splash_login_box">

                    <h4 class="account_create">Create an Account</h4>
                    <form action="<?php echo get_site_url() . '/' . $cja_config['user-details-page-slug']; ?>" method="post" class="cja_home_create">
                        <div class="topbox">
                            <div class="username">
                                <p class="label">Email Address</p>
                                <input type="text" name="email">
                            </div>
                            <div class="password">
                                <p class="label">Password</p>
                                <input type="password" name="password">
                            </div>
                        </div>
                        
                        <div class="rolebox">
                            <div class="role_option">
                                <input type="radio" name="role" value="jobseeker" checked> I am looking for a job or course</input>
                            </div>
                            <div class="role_option">
                                <input type="radio" name="role" value="advertiser"> I am an employer or course provider</input>
                            </div>
                        </div>
                        <input type="hidden" name="createaccount" value="true">
                        <p class="input-right"><input class="cja_button cja_button--home_login" type="submit" value="Create Free Account"></p>
                    </form>
                </div><?php
            }
        } ?>
    </div>
</div>

<!-- Display the featureboxes below the main image -->
<div class="cja_featureboxes">
<h1>Find Your Next Opportunity!</h1>
    <div class="col-full">
        <div class="box box1">
            <h2>Employers</h2>
            <p class="and">and</p>
            <h2>Course Providers</h2>
            <ul class="fa-ul">
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Advertise your Jobs and Courses</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Search jobseekers with CV Search</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Search students with Student Search</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Place Classified Ads</li>
            </ul>
            <!--<p class="button"><a href="" class="cja_button cja_button--2">Get Started</a></p>-->
        </div>
        <div class="box box2">
            <h2>Jobseekers</h2>
            <p class="and">and</p>
            <h2>Students</h2>
            <ul class="fa-ul">
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Search for the right job or course for you</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Upload your CV and profile</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Appear in CV and Student searches</li>
                <li><span class="fa-li"><i class="fas fa-check"></i></span>Place Classified Ads</li>
            </ul>
            <!--<p class="button"><a href="" class="cja_button cja_button--2">Get Started</a></p>-->
        </div>
    </div>
</div>

<?php get_footer(); ?>