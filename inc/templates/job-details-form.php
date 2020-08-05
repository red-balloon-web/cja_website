<?php

// Requires $cja_edit_ad = CJA_Advert to edit existing ad otherwise will leave fields blank if $cja_edit_ad is unset

?>

<p class="label">Opportunity Title</p>
<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">


<p class="label">Salary</p>
<input type="text" name="salary_numeric" value="<?php echo ($cja_edit_ad->salarynumeric); ?>">
<select name="salary_per" form="edit_ad_form">
    <option value="hour" <?php if ($cja_edit_ad->job_type == 'full_time') { echo 'selected'; } ?>>per hour</option>
    <option value="day" <?php if ($cja_edit_ad->job_type == 'part_time') { echo 'selected'; } ?>>per day</option>
    <option value="year" <?php if ($cja_edit_ad->job_type == 'freelance') { echo 'selected'; } ?>>per annum</option>
</select>


<p class="label">Job Description</p>
<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>


<p class="label">Job Type</p>
<select name="job_type" form="edit_ad_form">
    <option value="full_time" <?php if ($cja_edit_ad->job_type == 'full_time') { echo 'selected'; } ?>>Full Time</option>
    <option value="part_time" <?php if ($cja_edit_ad->job_type == 'part_time') { echo 'selected'; } ?>>Part Time</option>
    <option value="freelance" <?php if ($cja_edit_ad->job_type == 'freelance') { echo 'selected'; } ?>>Freelance</option>
    <option value="intern" <?php if ($cja_edit_ad->job_type == 'intern') { echo 'selected'; } ?>>Internship</option>
    <option value="temporary" <?php if ($cja_edit_ad->job_type == 'temporary') { echo 'selected'; } ?>>Temporary</option>
    <option value="volunteer" <?php if ($cja_edit_ad->job_type == 'volunteer') { echo 'selected'; } ?>>Volunteer</option>
    <option value="work_based_learning" <?php if ($cja_edit_ad->job_type == 'work_based_learning') { echo 'selected'; } ?>>Work-based Learning</option>
    <option value="other" <?php if ($cja_edit_ad->job_type == 'other') { echo 'selected'; } ?>>Other</option>
</select>


<p class="label">Sectors</p>
<div class="checkbox_group">
    <label><input type="checkbox" name="sectors[]" value="accountancy_business_finance" /> Accountancy, Banking and Finance</label>
    <label><input type="checkbox" name="sectors[]" value="business_consulting_management" /> Business, Consulting and Management</label>
    <label><input type="checkbox" name="sectors[]" value="charity_voluntary" /> Charity and Voluntary work</label>
    <label><input type="checkbox" name="sectors[]" value="creative_design" /> Creative Arts and Design</label>
    <label><input type="checkbox" name="sectors[]" value="energy_utilities" /> Energy and Utilities</label>
    <label><input type="checkbox" name="sectors[]" value="engineering_manufacturing" /> Engineering and Manufacturing</label>
    <label><input type="checkbox" name="sectors[]" value="environment_agriculture" /> Environment and Agriculture</label>
    <label><input type="checkbox" name="sectors[]" value="healthcare" /> Healthcare</label>
    <label><input type="checkbox" name="sectors[]" value="hospitality_events" /> Hospitality and Events Management</label>
    <label><input type="checkbox" name="sectors[]" value="information_technology" /> Information Technology</label>
    <label><input type="checkbox" name="sectors[]" value="law" /> Law</label>
    <label><input type="checkbox" name="sectors[]" value="law_enforcement_security" /> Law Enforcement and Security</label>
    <label><input type="checkbox" name="sectors[]" value="leisure_sport_tourism" /> Leisure, Sport and Tourism</label>
    <label><input type="checkbox" name="sectors[]" value="marketing_advertising_pr" /> Marketing, advertising and PR</label>
    <label><input type="checkbox" name="sectors[]" value="media_internet" /> Media and Internet</label>
    <label><input type="checkbox" name="sectors[]" value="property_construction" /> Property and Construction</label>
    <label><input type="checkbox" name="sectors[]" value="public_services_administration" /> Public Services and Administration</label>
    <label><input type="checkbox" name="sectors[]" value="recruitment_hr" /> Recruitment and HR</label>
    <label><input type="checkbox" name="sectors[]" value="retail" /> Retail</label>
    <label><input type="checkbox" name="sectors[]" value="sales" /> Sales</label>
    <label><input type="checkbox" name="sectors[]" value="science_pharmaceuticals" /> Science and Pharmaceuticals</label>
    <label><input type="checkbox" name="sectors[]" value="social_care" /> Social Care</label>
    <label><input type="checkbox" name="sectors[]" value="teacher_education" /> Teacher Training and Education</label>
    <label><input type="checkbox" name="sectors[]" value="transport_logistics" /> Transport and Logistics</label>
</div>


<p class="label">Contact Person</p>
<input type="text" name="contact_person" value="<?php echo ($cja_edit_ad->contact_person); ?>">


<p class="label">Contact Phone Number</p>
<input type="text" name="phone" value="<?php echo ($cja_edit_ad->phone); ?>">

<p class="label">Career Level</p>
<select name="career_level" form="edit_ad_form">
    <option value="student" <?php if ($cja_edit_ad->sectors == 'student') { echo 'selected'; } ?>>Student</option>
    <option value="intern" <?php if ($cja_edit_ad->sectors == 'intern') { echo 'selected'; } ?>>Intern</option>
    <option value="trainee" <?php if ($cja_edit_ad->sectors == 'trainee') { echo 'selected'; } ?>>Trainee</option>
    <option value="entry_level" <?php if ($cja_edit_ad->sectors == 'entry_level') { echo 'selected'; } ?>>Entry Level</option>
    <option value="apprentice" <?php if ($cja_edit_ad->career_level == 'apprentice') { echo 'selected'; } ?>>Apprentice</option>
    <option value="team_leader" <?php if ($cja_edit_ad->sectors == 'team_leader') { echo 'selected'; } ?>>Team Leader</option>
    <option value="manager" <?php if ($cja_edit_ad->career_level == 'manager') { echo 'selected'; } ?>>Manager</option>
    <option value="consultant" <?php if ($cja_edit_ad->sectors == 'consultant') { echo 'selected'; } ?>>Consultant</option>
    <option value="executive" <?php if ($cja_edit_ad->career_level == 'executive') { echo 'selected'; } ?>>Executive</option>
</select>

<p class="label">Experience Required</p>
<select name="experience_required" form="edit_ad_form">
    <option value="none" <?php if ($cja_edit_ad->sectors == 'none') { echo 'selected'; } ?>>None</option>
    <option value="3months" <?php if ($cja_edit_ad->sectors == '3months') { echo 'selected'; } ?>>3 Months</option>
    <option value="6months" <?php if ($cja_edit_ad->sectors == '6months') { echo 'selected'; } ?>>6 Months</option>
    <option value="1year" <?php if ($cja_edit_ad->sectors == '1year') { echo 'selected'; } ?>>1 Year</option>
    <option value="2years" <?php if ($cja_edit_ad->career_level == '2years') { echo 'selected'; } ?>>2 Years</option>
    <option value="3years" <?php if ($cja_edit_ad->sectors == '3years') { echo 'selected'; } ?>>3 Years</option>
    <option value="4years" <?php if ($cja_edit_ad->career_level == '4years') { echo 'selected'; } ?>>4+ Years</option>
</select>

<p class="label">Employer Type</p>
<select name="employer_type" form="edit_ad_form">
    <option value="university" <?php if ($cja_edit_ad->sectors == 'university') { echo 'selected'; } ?>>None</option>
    <option value="college" <?php if ($cja_edit_ad->sectors == 'college') { echo 'selected'; } ?>>3 Months</option>
    <option value="private_training" <?php if ($cja_edit_ad->sectors == 'private_training') { echo 'selected'; } ?>>6 Months</option>
    <option value="1year" <?php if ($cja_edit_ad->sectors == '1year') { echo 'selected'; } ?>>1 Year</option>
    <option value="2years" <?php if ($cja_edit_ad->career_level == '2years') { echo 'selected'; } ?>>2 Years</option>
    <option value="3years" <?php if ($cja_edit_ad->sectors == '3years') { echo 'selected'; } ?>>3 Years</option>
    <option value="4years" <?php if ($cja_edit_ad->career_level == '4years') { echo 'selected'; } ?>>4+ Years</option>
</select>

<p class="label">Salary</p>
<input type="text" name="salary" value="<?php echo ($cja_edit_ad->salary); ?>">


<p class="label">Deadline</p>
<input type="date" name="deadline" value="<?php echo ($cja_edit_ad->deadline); ?>">

<!--
<p class="label">Sector</p>
<select name="sectors" form="edit_ad_form">
    <option value="accountancy" <?php if ($cja_edit_ad->sectors == 'accountancy') { echo 'selected'; } ?>>Accountancy</option>
    <option value="construction" <?php if ($cja_edit_ad->sectors == 'construction') { echo 'selected'; } ?>>Construction</option>
    <option value="nursing" <?php if ($cja_edit_ad->sectors == 'nursing') { echo 'selected'; } ?>>Nursing</option>
</select>
-->