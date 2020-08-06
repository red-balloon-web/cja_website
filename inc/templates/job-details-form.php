<?php

// Requires $cja_edit_ad = CJA_Advert to edit existing ad otherwise will leave fields blank if $cja_edit_ad is unset

?>

<p class="label">Opportunity Title</p>
<input type="text" name="ad-title" value="<?php echo ($cja_edit_ad->title); ?>">

<p class="label">Salary</p>
<input type="text" name="salary_numeric" value="£<?php echo ($cja_edit_ad->salary_numeric); ?>">
<select name="salary_per" form="edit_ad_form">
    <option value="hour" <?php if ($cja_edit_ad->salary_per == 'hour') { echo 'selected'; } ?>>per hour</option>
    <option value="day" <?php if ($cja_edit_ad->salary_per == 'day') { echo 'selected'; } ?>>per day</option>
    <option value="year" <?php if ($cja_edit_ad->salary_per == 'year') { echo 'selected'; } ?>>per annum</option>
</select>


<p class="label">Job Description</p>
<textarea name="ad-content" id="" cols="30" rows="10"><?php echo ($cja_edit_ad->content); ?></textarea>


<p class="label">Job Type</p>
<select name="job_type" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="full_time" <?php if ($cja_edit_ad->job_type == 'full_time') { echo 'selected'; } ?>>Full Time</option>
    <option value="part_time" <?php if ($cja_edit_ad->job_type == 'part_time') { echo 'selected'; } ?>>Part Time</option>
    <option value="freelance" <?php if ($cja_edit_ad->job_type == 'freelance') { echo 'selected'; } ?>>Freelance</option>
    <option value="intern" <?php if ($cja_edit_ad->job_type == 'intern') { echo 'selected'; } ?>>Internship</option>
    <option value="temporary" <?php if ($cja_edit_ad->job_type == 'temporary') { echo 'selected'; } ?>>Temporary</option>
    <option value="volunteer" <?php if ($cja_edit_ad->job_type == 'volunteer') { echo 'selected'; } ?>>Volunteer</option>
    <option value="work_based_learning" <?php if ($cja_edit_ad->job_type == 'work_based_learning') { echo 'selected'; } ?>>Work-based Learning</option>
    <option value="other" <?php if ($cja_edit_ad->job_type == 'other') { echo 'selected'; } ?>>Other</option>
</select>


<p class="label">Sector</p>
<select name="sector" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="accountancy_business_finance" <?php if ($cja_edit_ad->sector == 'accountancy_business_finance') { echo 'selected'; } ?>>Accountancy, Business and Finance</option>
    <option value="business_consulting_management" <?php if ($cja_edit_ad->sector == 'business_consulting_management') { echo 'selected'; } ?>>Business, Consulting and Management</option>
    <option value="charity_voluntary" <?php if ($cja_edit_ad->sector == 'charity_voluntary') { echo 'selected'; } ?>>Charity and Voluntary Work</option>
    <option value="creative_design" <?php if ($cja_edit_ad->sector == 'creative_design') { echo 'selected'; } ?>>Creative Arts and Design</option>
    <option value="energy_utilities" <?php if ($cja_edit_ad->sector == 'energy_utilities') { echo 'selected'; } ?>>Energy and Utilities</option>
    <option value="engineering_manufacturing" <?php if ($cja_edit_ad->sector == 'engineering_manufacturing') { echo 'selected'; } ?>>Engineering and Manufacturing</option>
    <option value="environment_agriculture" <?php if ($cja_edit_ad->sector == 'environment_agriculture') { echo 'selected'; } ?>>Environment and Agriculture</option>
    <option value="healthcare" <?php if ($cja_edit_ad->sector == 'healthcare') { echo 'selected'; } ?>>Healthcare</option>
    <option value="hospitality_events" <?php if ($cja_edit_ad->sector == 'hospitality_events') { echo 'selected'; } ?>>Hospitality and Events Management</option>
    <option value="information_technology" <?php if ($cja_edit_ad->sector == 'information_technology') { echo 'selected'; } ?>>Information Technology</option>
    <option value="law" <?php if ($cja_edit_ad->sector == 'law') { echo 'selected'; } ?>>Law</option>
    <option value="law_enforcement_security" <?php if ($cja_edit_ad->sector == 'law_enforcement_security') { echo 'selected'; } ?>>Law Enforcement and Security</option>
    <option value="leisure_sport_tourism" <?php if ($cja_edit_ad->sector == 'leisure_sport_tourism') { echo 'selected'; } ?>>Leisure, Sport and Tourism</option>
    <option value="marketing_advertising_pr" <?php if ($cja_edit_ad->sector == 'marketing_advertising_pr') { echo 'selected'; } ?>>Marketing, Advertising and PR</option>
    <option value="media_internet" <?php if ($cja_edit_ad->sector == 'media_internet') { echo 'selected'; } ?>>Media and Internet</option>
    <option value="property_construction" <?php if ($cja_edit_ad->sector == 'property_construction') { echo 'selected'; } ?>>Property and Construction</option>
    <option value="public_services_administration" <?php if ($cja_edit_ad->sector == 'public_services_administration') { echo 'selected'; } ?>>Public Services and Administration</option>
    <option value="recruitment_hr" <?php if ($cja_edit_ad->sector == 'recruitment_hr') { echo 'selected'; } ?>>Recruitment and HR</option>
    <option value="retail" <?php if ($cja_edit_ad->sector == 'retail') { echo 'selected'; } ?>>Retail</option>
    <option value="sales" <?php if ($cja_edit_ad->sector == 'sales') { echo 'selected'; } ?>>Sales</option>
    <option value="science_pharmaceuticals" <?php if ($cja_edit_ad->sector == 'science_pharmaceuticals') { echo 'selected'; } ?>>Science and Pharmaceuticals</option>
    <option value="social_care" <?php if ($cja_edit_ad->sector == 'social_care') { echo 'selected'; } ?>>Social Care</option>
    <option value="teacher_education" <?php if ($cja_edit_ad->sector == 'teacher_education') { echo 'selected'; } ?>>Teacher Training and Education</option>
    <option value="transport_logistics" <?php if ($cja_edit_ad->sector == 'transport_logistics') { echo 'selected'; } ?>>Transport and Logistics</option>
</select>

<!--
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
-->


<p class="label">Contact Person</p>
<input type="text" name="contact_person" value="<?php echo ($cja_edit_ad->contact_person); ?>">


<p class="label">Contact Phone Number</p>
<input type="text" name="contact_phone_number" value="<?php echo ($cja_edit_ad->contact_phone_number); ?>">

<p class="label">Career Level</p>
<select name="career_level" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="student" <?php if ($cja_edit_ad->career_level == 'student') { echo 'selected'; } ?>>Student</option>
    <option value="intern" <?php if ($cja_edit_ad->career_level == 'intern') { echo 'selected'; } ?>>Intern</option>
    <option value="trainee" <?php if ($cja_edit_ad->career_level == 'trainee') { echo 'selected'; } ?>>Trainee</option>
    <option value="entry_level" <?php if ($cja_edit_ad->career_level == 'entry_level') { echo 'selected'; } ?>>Entry Level</option>
    <option value="apprentice" <?php if ($cja_edit_ad->career_level == 'apprentice') { echo 'selected'; } ?>>Apprentice</option>
    <option value="team_leader" <?php if ($cja_edit_ad->career_level == 'team_leader') { echo 'selected'; } ?>>Team Leader</option>
    <option value="manager" <?php if ($cja_edit_ad->career_level == 'manager') { echo 'selected'; } ?>>Manager</option>
    <option value="consultant" <?php if ($cja_edit_ad->career_level == 'consultant') { echo 'selected'; } ?>>Consultant</option>
    <option value="executive" <?php if ($cja_edit_ad->career_level == 'executive') { echo 'selected'; } ?>>Executive</option>
</select>

<p class="label">Experience Required</p>
<select name="experience_required" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="none" <?php if ($cja_edit_ad->experience_required == 'none') { echo 'selected'; } ?>>None</option>
    <option value="3months" <?php if ($cja_edit_ad->experience_required == '3months') { echo 'selected'; } ?>>3 Months</option>
    <option value="6months" <?php if ($cja_edit_ad->experience_required == '6months') { echo 'selected'; } ?>>6 Months</option>
    <option value="1year" <?php if ($cja_edit_ad->experience_required == '1year') { echo 'selected'; } ?>>1 Year</option>
    <option value="2years" <?php if ($cja_edit_ad->experience_required == '2years') { echo 'selected'; } ?>>2 Years</option>
    <option value="3years" <?php if ($cja_edit_ad->experience_required == '3years') { echo 'selected'; } ?>>3 Years</option>
    <option value="4years" <?php if ($cja_edit_ad->experience_required == '4years') { echo 'selected'; } ?>>4+ Years</option>
</select>

<p class="label">Employer Type</p>
<select name="employer_type" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="university" <?php if ($cja_edit_ad->employer_type == 'university') { echo 'selected'; } ?>>University</option>
    <option value="college" <?php if ($cja_edit_ad->employer_type == 'college') { echo 'selected'; } ?>>College</option>
    <option value="private_training_provider" <?php if ($cja_edit_ad->employer_type == 'private_training_provider') { echo 'selected'; } ?>>Private Training Provider</option>
    <option value="private_individual" <?php if ($cja_edit_ad->employer_type == 'private_individual') { echo 'selected'; } ?>>Private Individual</option>
    <option value="recruitment_agency" <?php if ($cja_edit_ad->employer_type == 'recruitment_agency') { echo 'selected'; } ?>>Recruitment Agency</option>
    <option value="employer_large" <?php if ($cja_edit_ad->employer_type == 'employer_large') { echo 'selected'; } ?>>Employer (large)</option>
    <option value="employer_medium" <?php if ($cja_edit_ad->employer_type == 'employer_medium') { echo 'selected'; } ?>>Employer (medium)</option>
    <option value="employer_small" <?php if ($cja_edit_ad->employer_type == 'employer_small') { echo 'selected'; } ?>>Employer (small)</option>
    <option value="sole_trader" <?php if ($cja_edit_ad->employer_type == 'sole_trader') { echo 'selected'; } ?>>Sole Trader</option>
    <option value="charity" <?php if ($cja_edit_ad->employer_type == 'charity') { echo 'selected'; } ?>>Charity</option>
    <option value="government_organisation" <?php if ($cja_edit_ad->employer_type == 'government_organisation') { echo 'selected'; } ?>>Government Organisation</option>
    <option value="other" <?php if ($cja_edit_ad->employer_type == 'other') { echo 'selected'; } ?>>Other</option>
</select>

<p class="label">Minimum Qualification Required</p>
<select name="minimum_qualification" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="gcse" <?php if ($cja_edit_ad->minimum_qualification == 'gcse') { echo 'selected'; } ?>>GCSE's</option>
    <option value="alevels" <?php if ($cja_edit_ad->minimum_qualification == 'alevels') { echo 'selected'; } ?>>A Levels</option>
    <option value="award" <?php if ($cja_edit_ad->minimum_qualification == 'award') { echo 'selected'; } ?>>Award</option>
    <option value="certificate" <?php if ($cja_edit_ad->minimum_qualification == 'certificate') { echo 'selected'; } ?>>Certificate</option>
    <option value="diploma" <?php if ($cja_edit_ad->minimum_qualification == 'diploma') { echo 'selected'; } ?>>Diploma</option>
    <option value="studying_degree" <?php if ($cja_edit_ad->minimum_qualification == 'studying_degree') { echo 'selected'; } ?>>Studying towards a Degree</option>
    <option value="degree" <?php if ($cja_edit_ad->minimum_qualification == 'degree') { echo 'selected'; } ?>>Degree</option>
    <option value="masters_degree" <?php if ($cja_edit_ad->minimum_qualification == 'masters_degree') { echo 'selected'; } ?>>Masters Degree</option>
    <option value="doctorate_degree" <?php if ($cja_edit_ad->minimum_qualification == 'doctorate_degree') { echo 'selected'; } ?>>Doctorate Degree</option>
</select>

<p class="label">DBS Required</p>
<select name="dbs_required" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="yes" <?php if ($cja_edit_ad->dbs_required == 'yes') { echo 'selected'; } ?>>Yes</option>
    <option value="no" <?php if ($cja_edit_ad->dbs_required == 'no') { echo 'selected'; } ?>>No</option>
    <option value="arranged" <?php if ($cja_edit_ad->dbs_required == 'arranged') { echo 'selected'; } ?>>Can Be Arranged</option>
</select>


<p class="label">Payment Frequency</p>
<select name="payment_frequency" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="daily" <?php if ($cja_edit_ad->payment_frequency == 'daily') { echo 'selected'; } ?>>Daily</option>
    <option value="weekly" <?php if ($cja_edit_ad->payment_frequency == 'weekly') { echo 'selected'; } ?>>Weekly</option>
    <option value="fortnightly" <?php if ($cja_edit_ad->payment_frequency == 'fortnightly') { echo 'selected'; } ?>>Fortnightly</option>
    <option value="monthly" <?php if ($cja_edit_ad->payment_frequency == 'monthly') { echo 'selected'; } ?>>Monthly</option>
    <option value="to_be_discussed" <?php if ($cja_edit_ad->payment_frequency == 'to_be_discussed') { echo 'selected'; } ?>>To Be Discussed</option>
</select>

<p class="label">Shift Work</p>
<select name="shift_work" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="yes" <?php if ($cja_edit_ad->shift_work == 'yes') { echo "selected"; } ?>>Yes</option>
    <option value="no" <?php if ($cja_edit_ad->shift_work == 'no') { echo "selected"; } ?>>No</option>

</select>

<p class="label">Shifts (if applicable)</p>
<div class="checkbox_group">
    <label><input type="checkbox" name="shifts[]" value="morning" <?php if ($cja_edit_ad && in_array('morning', $cja_edit_ad->shifts)) { echo "checked"; } ?>> Morning</label>
    <label><input type="checkbox" name="shifts[]" value="afternoon" <?php if ($cja_edit_ad && in_array('afternoon', $cja_edit_ad->shifts)) { echo "checked"; } ?>> Afternoon</label>
    <label><input type="checkbox" name="shifts[]" value="evening" <?php if ($cja_edit_ad && in_array('evening', $cja_edit_ad->shifts)) { echo "checked"; } ?>> Evening</label>
    <label><input type="checkbox" name="shifts[]" value="night" <?php if ($cja_edit_ad && in_array('night', $cja_edit_ad->shifts)) { echo "checked"; } ?>> Night</label>
</div>


<p class="label">Location Options</p>
<select name="location_options" form="edit_ad_form">
    <option value="">--Select--</option>
    <option value="on_premises" <?php if ($cja_edit_ad->location_options == 'on_premises') { echo 'selected'; } ?>>On Premises</option>
    <option value="remotely" <?php if ($cja_edit_ad->location_options == 'remotely') { echo 'selected'; } ?>>Remotely</option>
    <option value="both" <?php if ($cja_edit_ad->location_options == 'both') { echo 'selected'; } ?>>On Premises and Remotely</option>
</select>

<p class="label">Deadline</p>
<input type="date" name="deadline" value="<?php echo ($cja_edit_ad->deadline); ?>">

<p class="label">Job Specification / Description</p>
<?php if ($cja_edit_ad->job_spec_url == '') { ?> 
    <input type="file" name="job_specification">
<?php } else { ?>
    <p>Current Job Specification: <?php echo $cja_edit_ad->job_spec_filename; ?></p>
    <p>Load New Job Specification: <input type="file" name="job_specification"></p>
<?php } ?>
