<?php

if ($_GET['edit-search']) { 

        $cja_jobsearch = new CJA_Advert; // only so we can update from cookies if using persistent search
        // $cja_jobsearch->update_from_cookies(); ?>

        <h1>Edit My Job Search</h1>
        <!--<p style="text-align: center; font-style: italic; color: #666; margin-bottom: 40px;">Please remember to set any fields you no longer wish to search by back to "any".</p>-->

        <form action="<?php echo get_the_permalink(); ?>" method="post" id="edit_search_form" class="smart_form">

            <p class="label">Search by ID</p>
            <input type="text" name="cja_id">

            <h2 class="form_section_heading">Search</h2>
            <?php if ($cja_current_user_obj->postcode) { ?>
                <div class="form_flexbox_2">
                    <div>
                        <p class="label">Maximum Distance from my Postcode:</p>
                        <select name="max_distance" form="edit_search_form">
                            <option value="">-- Any --</option>
                            <option value="10" <?php if ($cja_jobsearch->max_distance == '10') { echo 'selected'; } ?>>10 Miles</option>
                            <option value="20" <?php if ($cja_jobsearch->max_distance == '20') { echo 'selected'; } ?>>20 Miles</option>
                            <option value="30" <?php if ($cja_jobsearch->max_distance == '30') { echo 'selected'; } ?>>30 Miles</option>
                            <option value="50" <?php if ($cja_jobsearch->max_distance == '50') { echo 'selected'; } ?>>50 Miles</option>
                            <option value="100" <?php if ($cja_jobsearch->max_distance == '100') { echo 'selected'; } ?>>100 Miles</option>
                        </select>
                    </div>
                    <div>
                        <p class="label">Order Results By</p>
                        <select name="order_by" form="edit_search_form">
                            <option value="date">Newest Jobs First</option>
                            <option value="distance" <?php if ($cja_jobsearch->order_by == 'distance') { echo 'selected'; } ?>>Closest Jobs First</option>
                        </select>
                    </div>
                </div>
            <?php } else { ?>
                <input type="hidden" name="order_by" value="date"><?php
            } ?>
            <p><input type="checkbox" name="show_applied" <?php if ($cja_jobsearch->show_applied) { echo 'checked'; } ?>> Include jobs I have already applied for</p>

            <h2 class="form_section_heading">About the Job</h2>
            <p class="label">Paid / Unpaid</p>
            <select name="salary_type" id="salary_type">
                <option value="">-- Any --</option>
                <option value="paid" <?php if ($cja_jobsearch->salary_type == 'paid') { echo 'selected'; } ?>>Paid</option>
                <option value="unpaid_we_training" <?php if ($cja_jobsearch->salary_type == 'unpaid_we_training') { echo 'selected'; } ?>>Unpaid Work Experience or Training</option>
            </select>
            <p class="label">Minimum Salary</p>
            <input type="text" name="salary_numeric" value="£<?php echo ($cja_jobsearch->salary_numeric); ?>">
            <select name="salary_per" form="edit_search_form">
                <option value="hour" <?php if ($cja_jobsearch->salary_per == 'hour') { echo 'selected'; } ?>>per hour</option>
                <option value="day" <?php if ($cja_jobsearch->salary_per == 'day') { echo 'selected'; } ?>>per day</option>
                <option value="year" <?php if ($cja_jobsearch->salary_per == 'year') { echo 'selected'; } ?>>per annum</option>
            </select>
            <div class="form_flexbox_2">
                <div>
                    <p class="label">Job Type</p>
                    <select name="job_type" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="full_time" <?php if ($cja_jobsearch->job_type == 'full_time') { echo 'selected'; } ?>>Full Time</option>
                        <option value="part_time" <?php if ($cja_jobsearch->job_type == 'part_time') { echo 'selected'; } ?>>Part Time</option>
                        <option value="freelance" <?php if ($cja_jobsearch->job_type == 'freelance') { echo 'selected'; } ?>>Freelance</option>
                        <option value="intern" <?php if ($cja_jobsearch->job_type == 'intern') { echo 'selected'; } ?>>Internship</option>
                        <option value="temporary" <?php if ($cja_jobsearch->job_type == 'temporary') { echo 'selected'; } ?>>Temporary</option>
                        <option value="volunteer" <?php if ($cja_jobsearch->job_type == 'volunteer') { echo 'selected'; } ?>>Volunteer</option>
                        <option value="work_based_learning" <?php if ($cja_jobsearch->job_type == 'work_based_learning') { echo 'selected'; } ?>>Work-based Learning</option>
                        <option value="other" <?php if ($cja_jobsearch->job_type == 'other') { echo 'selected'; } ?>>Other</option>
                    </select>
                </div>
                <div>
                    <p class="label">Employer Type</p>
                    <select name="employer_type" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="university" <?php if ($cja_jobsearch->employer_type == 'university') { echo 'selected'; } ?>>University</option>
                        <option value="college" <?php if ($cja_jobsearch->employer_type == 'college') { echo 'selected'; } ?>>College</option>
                        <option value="private_training_provider" <?php if ($cja_jobsearch->employer_type == 'private_training_provider') { echo 'selected'; } ?>>Private Training Provider</option>
                        <option value="private_individual" <?php if ($cja_jobsearch->employer_type == 'private_individual') { echo 'selected'; } ?>>Private Individual</option>
                        <option value="recruitment_agency" <?php if ($cja_jobsearch->employer_type == 'recruitment_agency') { echo 'selected'; } ?>>Recruitment Agency</option>
                        <option value="employer_large" <?php if ($cja_jobsearch->employer_type == 'employer_large') { echo 'selected'; } ?>>Employer (large)</option>
                        <option value="employer_medium" <?php if ($cja_jobsearch->employer_type == 'employer_medium') { echo 'selected'; } ?>>Employer (medium)</option>
                        <option value="employer_small" <?php if ($cja_jobsearch->employer_type == 'employer_small') { echo 'selected'; } ?>>Employer (small)</option>
                        <option value="sole_trader" <?php if ($cja_jobsearch->employer_type == 'sole_trader') { echo 'selected'; } ?>>Sole Trader</option>
                        <option value="charity" <?php if ($cja_jobsearch->employer_type == 'charity') { echo 'selected'; } ?>>Charity</option>
                        <option value="government_organisation" <?php if ($cja_jobsearch->employer_type == 'government_organisation') { echo 'selected'; } ?>>Government Organisation</option>
                        <option value="other" <?php if ($cja_jobsearch->employer_type == 'other') { echo 'selected'; } ?>>Other</option>
                    </select>
                </div>
            </div>
            <div class="form_flexbox_2">
                <div>
                    <p class="label">Sector</p>
                    <select name="sector" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="accountancy_business_finance" <?php if ($cja_jobsearch->sector == 'accountancy_business_finance') { echo 'selected'; } ?>>Accountancy, Business and Finance</option>
                        <option value="business_consulting_management" <?php if ($cja_jobsearch->sector == 'business_consulting_management') { echo 'selected'; } ?>>Business, Consulting and Management</option>
                        <option value="charity_voluntary" <?php if ($cja_jobsearch->sector == 'charity_voluntary') { echo 'selected'; } ?>>Charity and Voluntary Work</option>
                        <option value="creative_design" <?php if ($cja_jobsearch->sector == 'creative_design') { echo 'selected'; } ?>>Creative Arts and Design</option>
                        <option value="energy_utilities" <?php if ($cja_jobsearch->sector == 'energy_utilities') { echo 'selected'; } ?>>Energy and Utilities</option>
                        <option value="engineering_manufacturing" <?php if ($cja_jobsearch->sector == 'engineering_manufacturing') { echo 'selected'; } ?>>Engineering and Manufacturing</option>
                        <option value="environment_agriculture" <?php if ($cja_jobsearch->sector == 'environment_agriculture') { echo 'selected'; } ?>>Environment and Agriculture</option>
                        <option value="healthcare" <?php if ($cja_jobsearch->sector == 'healthcare') { echo 'selected'; } ?>>Healthcare</option>
                        <option value="hospitality_events" <?php if ($cja_jobsearch->sector == 'hospitality_events') { echo 'selected'; } ?>>Hospitality and Events Management</option>
                        <option value="information_technology" <?php if ($cja_jobsearch->sector == 'information_technology') { echo 'selected'; } ?>>Information Technology</option>
                        <option value="law" <?php if ($cja_jobsearch->sector == 'law') { echo 'selected'; } ?>>Law</option>
                        <option value="law_enforcement_security" <?php if ($cja_jobsearch->sector == 'law_enforcement_security') { echo 'selected'; } ?>>Law Enforcement and Security</option>
                        <option value="leisure_sport_tourism" <?php if ($cja_jobsearch->sector == 'leisure_sport_tourism') { echo 'selected'; } ?>>Leisure, Sport and Tourism</option>
                        <option value="marketing_advertising_pr" <?php if ($cja_jobsearch->sector == 'marketing_advertising_pr') { echo 'selected'; } ?>>Marketing, Advertising and PR</option>
                        <option value="media_internet" <?php if ($cja_jobsearch->sector == 'media_internet') { echo 'selected'; } ?>>Media and Internet</option>
                        <option value="property_construction" <?php if ($cja_jobsearch->sector == 'property_construction') { echo 'selected'; } ?>>Property and Construction</option>
                        <option value="public_services_administration" <?php if ($cja_jobsearch->sector == 'public_services_administration') { echo 'selected'; } ?>>Public Services and Administration</option>
                        <option value="recruitment_hr" <?php if ($cja_jobsearch->sector == 'recruitment_hr') { echo 'selected'; } ?>>Recruitment and HR</option>
                        <option value="retail" <?php if ($cja_jobsearch->sector == 'retail') { echo 'selected'; } ?>>Retail</option>
                        <option value="sales" <?php if ($cja_jobsearch->sector == 'sales') { echo 'selected'; } ?>>Sales</option>
                        <option value="science_pharmaceuticals" <?php if ($cja_jobsearch->sector == 'science_pharmaceuticals') { echo 'selected'; } ?>>Science and Pharmaceuticals</option>
                        <option value="social_care" <?php if ($cja_jobsearch->sector == 'social_care') { echo 'selected'; } ?>>Social Care</option>
                        <option value="teacher_education" <?php if ($cja_jobsearch->sector == 'teacher_education') { echo 'selected'; } ?>>Teacher Training and Education</option>
                        <option value="transport_logistics" <?php if ($cja_jobsearch->sector == 'transport_logistics') { echo 'selected'; } ?>>Transport and Logistics</option>
                    </select>
                </div>
                <div>
                    <p class="label">Payment Frequency</p>
                    <select name="payment_frequency" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="daily" <?php if ($cja_jobsearch->payment_frequency == 'daily') { echo 'selected'; } ?>>Daily</option>
                        <option value="weekly" <?php if ($cja_jobsearch->payment_frequency == 'weekly') { echo 'selected'; } ?>>Weekly</option>
                        <option value="fortnightly" <?php if ($cja_jobsearch->payment_frequency == 'fortnightly') { echo 'selected'; } ?>>Fortnightly</option>
                        <option value="monthly" <?php if ($cja_jobsearch->payment_frequency == 'monthly') { echo 'selected'; } ?>>Monthly</option>
                        <option value="to_be_discussed" <?php if ($cja_jobsearch->payment_frequency == 'to_be_discussed') { echo 'selected'; } ?>>To Be Discussed</option>
                    </select>
                </div>
            </div>
            <div class="form_flexbox_2">
                <div>
                    <p class="label">Location Options</p>
                    <select name="location_options" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="on_premises" <?php if ($cja_jobsearch->location_options == 'on_premises') { echo 'selected'; } ?>>On Premises</option>
                        <option value="remotely" <?php if ($cja_jobsearch->location_options == 'remotely') { echo 'selected'; } ?>>Remotely</option>
                        <option value="both" <?php if ($cja_jobsearch->location_options == 'both') { echo 'selected'; } ?>>On Premises and Remotely</option>
                    </select>
                </div>
                <div>
                    <p class="label">Shift Work</p>
                    <select name="shift_work" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="yes" <?php if ($cja_jobsearch->shift_work == 'yes') { echo "selected"; } ?>>Yes</option>
                        <option value="no" <?php if ($cja_jobsearch->shift_work == 'no') { echo "selected"; } ?>>No</option>
                    </select>
                </div>
            </div>

            <h2 class="form_section_heading">Qualifications and Experience</h2>
            <div class="form_flexbox_2">
                <div>
                    <p class="label">Highest Qualification Required</p>
                    <select name="minimum_qualification" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="gcse" <?php if ($cja_jobsearch->minimum_qualification == 'gcse') { echo 'selected'; } ?>>GCSE's</option>
                        <option value="alevels" <?php if ($cja_jobsearch->minimum_qualification == 'alevels') { echo 'selected'; } ?>>A Levels</option>
                        <option value="award" <?php if ($cja_jobsearch->minimum_qualification == 'award') { echo 'selected'; } ?>>Award</option>
                        <option value="certificate" <?php if ($cja_jobsearch->minimum_qualification == 'certificate') { echo 'selected'; } ?>>Certificate</option>
                        <option value="diploma" <?php if ($cja_jobsearch->minimum_qualification == 'diploma') { echo 'selected'; } ?>>Diploma</option>
                        <option value="studying_degree" <?php if ($cja_jobsearch->minimum_qualification == 'studying_degree') { echo 'selected'; } ?>>Studying towards a Degree</option>
                        <option value="degree" <?php if ($cja_jobsearch->minimum_qualification == 'degree') { echo 'selected'; } ?>>Degree</option>
                        <option value="masters_degree" <?php if ($cja_jobsearch->minimum_qualification == 'masters_degree') { echo 'selected'; } ?>>Masters Degree</option>
                        <option value="doctorate_degree" <?php if ($cja_jobsearch->minimum_qualification == 'doctorate_degree') { echo 'selected'; } ?>>Doctorate Degree</option>
                    </select>
                </div>
                <div>
                    <p class="label">Maximum Experience Required</p>
                    <select name="experience_required" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="none" <?php if ($cja_jobsearch->experience_required == 'none') { echo 'selected'; } ?>>None</option>
                        <option value="3months" <?php if ($cja_jobsearch->experience_required == '3months') { echo 'selected'; } ?>>3 Months</option>
                        <option value="6months" <?php if ($cja_jobsearch->experience_required == '6months') { echo 'selected'; } ?>>6 Months</option>
                        <option value="1year" <?php if ($cja_jobsearch->experience_required == '1year') { echo 'selected'; } ?>>1 Year</option>
                        <option value="2years" <?php if ($cja_jobsearch->experience_required == '2years') { echo 'selected'; } ?>>2 Years</option>
                        <option value="3years" <?php if ($cja_jobsearch->experience_required == '3years') { echo 'selected'; } ?>>3 Years</option>
                        <option value="4years" <?php if ($cja_jobsearch->experience_required == '4years') { echo 'selected'; } ?>>4+ Years</option>
                    </select>
                </div>
            </div>

            <div class="form_flexbox_2">
                <div>
                    <p class="label">DBS Required</p>
                    <select name="dbs_required" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="yes" <?php if ($cja_jobsearch->dbs_required == 'yes') { echo 'selected'; } ?>>Yes</option>
                        <option value="no" <?php if ($cja_jobsearch->dbs_required == 'no') { echo 'selected'; } ?>>No</option>
                        <option value="arranged" <?php if ($cja_jobsearch->dbs_required == 'arranged') { echo 'selected'; } ?>>Can Be Arranged</option>
                    </select>
                </div>
                <div>
                    <p class="label">Career Level</p>
                    <select name="career_level" form="edit_search_form">
                        <option value="">-- Any --</option>
                        <option value="student" <?php if ($cja_jobsearch->career_level == 'student') { echo 'selected'; } ?>>Student</option>
                        <option value="intern" <?php if ($cja_jobsearch->career_level == 'intern') { echo 'selected'; } ?>>Intern</option>
                        <option value="trainee" <?php if ($cja_jobsearch->career_level == 'trainee') { echo 'selected'; } ?>>Trainee</option>
                        <option value="entry_level" <?php if ($cja_jobsearch->career_level == 'entry_level') { echo 'selected'; } ?>>Entry Level</option>
                        <option value="apprentice" <?php if ($cja_jobsearch->career_level == 'apprentice') { echo 'selected'; } ?>>Apprentice</option>
                        <option value="team_leader" <?php if ($cja_jobsearch->career_level == 'team_leader') { echo 'selected'; } ?>>Team Leader</option>
                        <option value="manager" <?php if ($cja_jobsearch->career_level == 'manager') { echo 'selected'; } ?>>Manager</option>
                        <option value="consultant" <?php if ($cja_jobsearch->career_level == 'consultant') { echo 'selected'; } ?>>Consultant</option>
                        <option value="executive" <?php if ($cja_jobsearch->career_level == 'executive') { echo 'selected'; } ?>>Executive</option>
                    </select>
                </div>
            </div>

            <!-- Date Registered -->
            <h2 class="form_section_heading">Date Posted on Site</h2>

            <div class="form_flexbox_2">
                <div>
                    <p class="label">Earliest Date Posted</p>
                    <input type="date" name="earliest_creation_date">
                </div>
                <div>
                    <p class="label">Latest Date Posted</p>
                    <input type="date" name="latest_creation_date">
                </div>
            </div>

            <input type="hidden" name="update_search" value="true">
            <input type="hidden" name="cja_set_cookies" value="true">

            <p>&nbsp;</p>
            <p>
                <input type="submit" class="cja_button cja_button--2" value="Search Jobs">
            </p>
        </form><?php


    $display_search = false;
} ?>