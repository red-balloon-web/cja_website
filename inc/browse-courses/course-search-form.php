<?php

if ($_GET['edit-search']) { 
    $cja_coursesearch = new CJA_Course_Advert;
    // $cja_coursesearch->update_from_cookies();

    ?>



    <h1>Edit My Course Search</h1>

    <!--<p style="text-align: center; font-style: italic; color: #666; margin-bottom: 40px;">Please remember to set any fields you no longer wish to search by back to "any".</p>-->


    <form action="<?php echo get_the_permalink(); ?>" method="post" id="edit_course_search_form">

        <?php if ($cja_user->postcode) { ?>
            <p class="label">Maximum Distance from my Postcode:</p>
            <select name="max_distance" form="edit_course_search_form">
                <option value="">-- Any --</option>
                <option value="10" <?php if ($cja_coursesearch->max_distance == '10') { echo 'selected'; } ?>>10 Miles</option>
                <option value="20" <?php if ($cja_coursesearch->max_distance == '20') { echo 'selected'; } ?>>20 Miles</option>
                <option value="30" <?php if ($cja_coursesearch->max_distance == '30') { echo 'selected'; } ?>>30 Miles</option>
                <option value="50" <?php if ($cja_coursesearch->max_distance == '50') { echo 'selected'; } ?>>50 Miles</option>
                <option value="100" <?php if ($cja_coursesearch->max_distance == '100') { echo 'selected'; } ?>>100 Miles</option>
            </select>
        <?php } ?>

        <p class="label">Offer Type</p>
        <select name="offer_type" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="classroom_online" <?php if ($cja_coursesearch->offer_type == 'classroom_online') { echo 'selected'; } ?>>Classroom and Online Mode</option>
            <option value="cp_cpd" <?php if ($cja_coursesearch->offer_type == 'cp_cpd') { echo 'selected'; } ?>>Course Pathway: CPD Development</option>
            <option value="cp_employment" <?php if ($cja_coursesearch->offer_type == 'cp_employment') { echo 'selected'; } ?>>Course Pathway: Employment</option>
            <option value="cp_university" <?php if ($cja_coursesearch->offer_type == 'cp_university') { echo 'selected'; } ?>>Course Pathway: University</option>
            <option value="cp_work_or_university" <?php if ($cja_coursesearch->offer_type == 'cp_work_or_university') { echo 'selected'; } ?>>Course Pathway: Work or University</option>
            <option value="full_time" <?php if ($cja_coursesearch->offer_type == 'full_time') { echo 'selected'; } ?>>Full Time</option>
            <option value="fully_funded_16_19" <?php if ($cja_coursesearch->offer_type == 'fully_funded_16_19') { echo 'selected'; } ?>>Fully-funded Course for 16-19s</option>
            <option value="online_own_pace" <?php if ($cja_coursesearch->offer_type == 'online_own_pace') { echo 'selected'; } ?>>Online - Study at your Own Pace</option>
            <option value="online_distance" <?php if ($cja_coursesearch->offer_type == 'online_distance') { echo 'selected'; } ?>>Online and Distance Learning</option>
            <option value="part_time" <?php if ($cja_coursesearch->offer_type == 'part_time') { echo 'selected'; } ?>>Part Time</option>
            <option value="payment_plan_available" <?php if ($cja_coursesearch->offer_type == 'payment_plan_available') { echo 'selected'; } ?>>Payment Plan Available</option>
            <option value="payment_plan_19" <?php if ($cja_coursesearch->offer_type == 'payment_plan_19') { echo 'selected'; } ?>>Payment Plan Available for 19s</option>
            <option value="self_fund_no_plan" <?php if ($cja_coursesearch->offer_type == 'self_fund_no_plan') { echo 'selected'; } ?>>Self-funded - No Payment Plan Available</option>
            <option value="self_fund_plan" <?php if ($cja_coursesearch->offer_type == 'self_fund_plan') { echo 'selected'; } ?>>Self-funded - Payment Plan Available</option>
            <option value="student_loan" <?php if ($cja_coursesearch->offer_type == 'student_loan') { echo 'selected'; } ?>>Student Loan Available</option>
            <option value="temporary" <?php if ($cja_coursesearch->offer_type == 'temporary') { echo 'selected'; } ?>>Temporary</option>
            <option value="volunteer" <?php if ($cja_coursesearch->offer_type == 'volunteer') { echo 'selected'; } ?>>Volunteer</option>
            <option value="work_based_learning" <?php if ($cja_coursesearch->offer_type == 'work_based_learning') { echo 'selected'; } ?>>Work Based Learning</option>
            <option value="other" <?php if ($cja_coursesearch->offer_type == 'other') { echo 'selected'; } ?>>Other</option>
        </select>


 
        <p class="label">Category</p>
        <select name="category" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="ab_english" <?php if ($cja_coursesearch->category == 'ab_english') { echo 'selected'; } ?>>A1, A2, B1 English Courses</option>
            <option value="assessor_cava" <?php if ($cja_coursesearch->category == 'assessor_cava') { echo 'selected'; } ?>>Assessor Course (CAVA)</option>
            <option value="b1_english_cab" <?php if ($cja_coursesearch->category == 'b1_english_cab') { echo 'selected'; } ?>>B1 English Course for Cab Drivers</option>
            <option value="bespoke_training" <?php if ($cja_coursesearch->category == 'bespoke_training') { echo 'selected'; } ?>>Bespoke Training</option>
            <option value="bsl_course" <?php if ($cja_coursesearch->category == 'bsl_course') { echo 'selected'; } ?>>British Sign Language Course</option>
            <option value="business_admin" <?php if ($cja_coursesearch->category == 'business_admin') { echo 'selected'; } ?>>Business Administration Courses</option>
            <option value="bus_course_university" <?php if ($cja_coursesearch->category == 'bus_course_university') { echo 'selected'; } ?>>Business Course for University</option>
            <option value="business_sector_courses" <?php if ($cja_coursesearch->category == 'business_sector_courses') { echo 'selected'; } ?>>Business Sector Courses</option>
            <option value="childcare_sector" <?php if ($cja_coursesearch->category == 'childcare_sector') { echo 'selected'; } ?>>Childcare Sector</option>
            <option value="cpd" <?php if ($cja_coursesearch->category == 'cpd') { echo 'selected'; } ?>>CPD</option>
            <option value="cscs" <?php if ($cja_coursesearch->category == 'cscs') { echo 'selected'; } ?>>CSCS</option>
            <option value="customer_service" <?php if ($cja_coursesearch->category == 'customer_service') { echo 'selected'; } ?>>Customer Service Courses</option>
            <option value="driving_courses" <?php if ($cja_coursesearch->category == 'driving_courses') { echo 'selected'; } ?>>Driving Courses</option>
            <option value="education_sector" <?php if ($cja_coursesearch->category == 'education_sector') { echo 'selected'; } ?>>Education Sector Courses</option>
            <option value="engineering_construction" <?php if ($cja_coursesearch->category == 'engineering_construction') { echo 'selected'; } ?>>Engineering & Construction Courses</option>
            <option value="esol" <?php if ($cja_coursesearch->category == 'esol') { echo 'selected'; } ?>>ESOL Courses</option>
            <option value="first_aid" <?php if ($cja_coursesearch->category == 'first_aid') { echo 'selected'; } ?>>First Aid Courses</option>
            <option value="fork_lift" <?php if ($cja_coursesearch->category == 'fork_lift') { echo 'selected'; } ?>>Fork Lift</option>
            <option value="health_safety" <?php if ($cja_coursesearch->category == 'health_safety') { echo 'selected'; } ?>>Health and Safety</option>
            <option value="health_social_university" <?php if ($cja_coursesearch->category == 'health_social_university') { echo 'selected'; } ?>>Health and Social Care Course for University</option>
            <option value="health_social_work" <?php if ($cja_coursesearch->category == 'health_social_work') { echo 'selected'; } ?>>Health and Social Care Courses for Work</option>
            <option value="hca_courses" <?php if ($cja_coursesearch->category == 'hca_courses') { echo 'selected'; } ?>>Health Care Assistant Courses or Training</option>
            <option value="healthcare_industry" <?php if ($cja_coursesearch->category == 'healthcare_industry') { echo 'selected'; } ?>>Health Care Industry Course</option>
            <option value="hospitality_catering" <?php if ($cja_coursesearch->category == 'hospitality_catering') { echo 'selected'; } ?>>Hospitality and Catering Courses</option>
            <option value="human_resources" <?php if ($cja_coursesearch->category == 'human_resources') { echo 'selected'; } ?>>Human Resources</option>
            <option value="it_courses" <?php if ($cja_coursesearch->category == 'it_courses') { echo 'selected'; } ?>>Information Technology Courses</option>
            <option value="internal_verifier" <?php if ($cja_coursesearch->category == 'internal_verifier') { echo 'selected'; } ?>>Internal Verifier Courses</option>
            <option value="legal_sector" <?php if ($cja_coursesearch->category == 'legal_sector') { echo 'selected'; } ?>>Legal Sector Courses</option>
            <option value="marketing_pr" <?php if ($cja_coursesearch->category == 'marketing_pr') { echo 'selected'; } ?>>Marketing and PR Courses</option>
            <option value="private_gcse_alevel" <?php if ($cja_coursesearch->category == 'private_gcse_alevel') { echo 'selected'; } ?>>Private GCSE and A-level Exam Centres</option>
            <option value="recruitment" <?php if ($cja_coursesearch->category == 'recruitment') { echo 'selected'; } ?>>Recruitment</option>
            <option value="retail_courses" <?php if ($cja_coursesearch->category == 'retail_courses') { echo 'selected'; } ?>>Retail Courses</option>
            <option value="s-accountancy" <?php if ($cja_coursesearch->category == 's-accountancy') { echo 'selected'; } ?>>S-Accountancy, Banking and Finance</option>
            <option value="s-business" <?php if ($cja_coursesearch->category == 's-business') { echo 'selected'; } ?>>S-Business, Consulting and Management</option>
            <option value="s-charity" <?php if ($cja_coursesearch->category == 's-charity') { echo 'selected'; } ?>>S-Charity and Voluntary Work</option>
            <option value="s-creative" <?php if ($cja_coursesearch->category == 's-creative') { echo 'selected'; } ?>>S-Creative Arts and Design</option>
            <option value="s-energy" <?php if ($cja_coursesearch->category == 's-energy') { echo 'selected'; } ?>>S-Energy and Utilities</option>
            <option value="s-engineering" <?php if ($cja_coursesearch->category == 's-engineering') { echo 'selected'; } ?>>S-Engineering and Manufacturing</option>
            <option value="s-environment" <?php if ($cja_coursesearch->category == 's-environment') { echo 'selected'; } ?>>S-Environment and Agriculture</option>
            <option value="s-healthcare" <?php if ($cja_coursesearch->category == 's-healthcare') { echo 'selected'; } ?>>S-Healthcare</option>
            <option value="s-hospitality" <?php if ($cja_coursesearch->category == 's-hospitality') { echo 'selected'; } ?>>S-Hospitality and Events Management</option>
            <option value="s-it" <?php if ($cja_coursesearch->category == 's-it') { echo 'selected'; } ?>>S-Information Technology</option>
            <option value="s-law" <?php if ($cja_coursesearch->category == 's-law') { echo 'selected'; } ?>>S-Law</option>
            <option value="s-law_enforcement" <?php if ($cja_coursesearch->category == 's-law_enforcement') { echo 'selected'; } ?>>S-Law Enforcement and Security</option>
            <option value="s-leisure" <?php if ($cja_coursesearch->category == 's-leisure') { echo 'selected'; } ?>>S-Leisure, Sports and Tourism</option>
            <option value="s-marketing" <?php if ($cja_coursesearch->category == 's-marketing') { echo 'selected'; } ?>>S-Marketing, Advertising and PR</option>
            <option value="s-media" <?php if ($cja_coursesearch->category == 's-media') { echo 'selected'; } ?>>S-Media and Internet</option>
            <option value="s-property" <?php if ($cja_coursesearch->category == 's-property') { echo 'selected'; } ?>>S-Property and Construction</option>
            <option value="s-public_services" <?php if ($cja_coursesearch->category == 's-public_services') { echo 'selected'; } ?>>S-Public Services and Administration</option>
            <option value="s-recruitment" <?php if ($cja_coursesearch->category == 's-recruitment') { echo 'selected'; } ?>>S-Retail</option>
            <option value="s-sales" <?php if ($cja_coursesearch->category == 's-sales') { echo 'selected'; } ?>>S-Sales</option>
            <option value="s-science" <?php if ($cja_coursesearch->category == 's-science') { echo 'selected'; } ?>>S-Science and Pharmacuticals</option>
            <option value="s-social" <?php if ($cja_coursesearch->category == 's-social') { echo 'selected'; } ?>>S-Social Care</option>
            <option value="s-teacher" <?php if ($cja_coursesearch->category == 's-teacher') { echo 'selected'; } ?>>S-Teacher Training and Education</option>
            <option value="s-transport" <?php if ($cja_coursesearch->category == 's-transport') { echo 'selected'; } ?>>S-Transport and Logistics</option>
            <option value="sales_marketing" <?php if ($cja_coursesearch->category == 'sales_marketing') { echo 'selected'; } ?>>Sales and Marketing Courses</option>
            <option value="sia" <?php if ($cja_coursesearch->category == 'sia') { echo 'selected'; } ?>>SIA Course</option>
            <option value="software" <?php if ($cja_coursesearch->category == 'software') { echo 'selected'; } ?>>Software and Web Dev Courses</option>
            <option value="teacher_training" <?php if ($cja_coursesearch->category == 'teacher_training') { echo 'selected'; } ?>>Teacher Training Courses</option>
            <option value="teaching_assistant" <?php if ($cja_coursesearch->category == 'teaching_assistant') { echo 'selected'; } ?>>Teaching Assistant Courses</option>
            <option value="team_leading" <?php if ($cja_coursesearch->category == 'team_leading') { echo 'selected'; } ?>>Team Leading</option>
            <option value="topographical" <?php if ($cja_coursesearch->category == 'topographical') { echo 'selected'; } ?>>Topographical Test Training for Cab Drivers</option>
            <option value="traineeships" <?php if ($cja_coursesearch->category == 'traineeships') { echo 'selected'; } ?>>Traineeships</option>
            <option value="travel_tourism" <?php if ($cja_coursesearch->category == 'travel_tourism') { echo 'selected'; } ?>>Travel and Tourism Courses</option>
            <option value="tree_surgeon" <?php if ($cja_coursesearch->category == 'tree_surgeon') { echo 'selected'; } ?>>Tree Surgeon Course</option>
        </select>
<!--
<p class="label">Price for Students not Eligible for Funding (if applicable)</p>
<input type="text" name="price" value="<?php if ($cja_coursesearch->price) { echo $cja_coursesearch->price; } ?>">
-->

        <p class="label">Sector</p>
        <select name="sector" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="accountancy_business_finance" <?php if ($cja_coursesearch->sector == 'accountancy_business_finance') { echo 'selected'; } ?>>Accountancy, Business and Finance</option>
            <option value="business_consulting_management" <?php if ($cja_coursesearch->sector == 'business_consulting_management') { echo 'selected'; } ?>>Business, Consulting and Management</option>
            <option value="charity_voluntary" <?php if ($cja_coursesearch->sector == 'charity_voluntary') { echo 'selected'; } ?>>Charity and Voluntary Work</option>
            <option value="creative_design" <?php if ($cja_coursesearch->sector == 'creative_design') { echo 'selected'; } ?>>Creative Arts and Design</option>
            <option value="energy_utilities" <?php if ($cja_coursesearch->sector == 'energy_utilities') { echo 'selected'; } ?>>Energy and Utilities</option>
            <option value="engineering_manufacturing" <?php if ($cja_coursesearch->sector == 'engineering_manufacturing') { echo 'selected'; } ?>>Engineering and Manufacturing</option>
            <option value="environment_agriculture" <?php if ($cja_coursesearch->sector == 'environment_agriculture') { echo 'selected'; } ?>>Environment and Agriculture</option>
            <option value="healthcare" <?php if ($cja_coursesearch->sector == 'healthcare') { echo 'selected'; } ?>>Healthcare</option>
            <option value="hospitality_events" <?php if ($cja_coursesearch->sector == 'hospitality_events') { echo 'selected'; } ?>>Hospitality and Events Management</option>
            <option value="information_technology" <?php if ($cja_coursesearch->sector == 'information_technology') { echo 'selected'; } ?>>Information Technology</option>
            <option value="law" <?php if ($cja_coursesearch->sector == 'law') { echo 'selected'; } ?>>Law</option>
            <option value="law_enforcement_security" <?php if ($cja_coursesearch->sector == 'law_enforcement_security') { echo 'selected'; } ?>>Law Enforcement and Security</option>
            <option value="leisure_sport_tourism" <?php if ($cja_coursesearch->sector == 'leisure_sport_tourism') { echo 'selected'; } ?>>Leisure, Sport and Tourism</option>
            <option value="marketing_advertising_pr" <?php if ($cja_coursesearch->sector == 'marketing_advertising_pr') { echo 'selected'; } ?>>Marketing, Advertising and PR</option>
            <option value="media_internet" <?php if ($cja_coursesearch->sector == 'media_internet') { echo 'selected'; } ?>>Media and Internet</option>
            <option value="property_construction" <?php if ($cja_coursesearch->sector == 'property_construction') { echo 'selected'; } ?>>Property and Construction</option>
            <option value="public_services_administration" <?php if ($cja_coursesearch->sector == 'public_services_administration') { echo 'selected'; } ?>>Public Services and Administration</option>
            <option value="recruitment_hr" <?php if ($cja_coursesearch->sector == 'recruitment_hr') { echo 'selected'; } ?>>Recruitment and HR</option>
            <option value="retail" <?php if ($cja_coursesearch->sector == 'retail') { echo 'selected'; } ?>>Retail</option>
            <option value="sales" <?php if ($cja_coursesearch->sector == 'sales') { echo 'selected'; } ?>>Sales</option>
            <option value="science_pharmaceuticals" <?php if ($cja_coursesearch->sector == 'science_pharmaceuticals') { echo 'selected'; } ?>>Science and Pharmaceuticals</option>
            <option value="social_care" <?php if ($cja_coursesearch->sector == 'social_care') { echo 'selected'; } ?>>Social Care</option>
            <option value="teacher_education" <?php if ($cja_coursesearch->sector == 'teacher_education') { echo 'selected'; } ?>>Teacher Training and Education</option>
            <option value="transport_logistics" <?php if ($cja_coursesearch->sector == 'transport_logistics') { echo 'selected'; } ?>>Transport and Logistics</option>
        </select>

        <p class="label">Deposit Required</p>
        <select name="deposit_required" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="100-500" <?php if ($cja_coursesearch->deposit_required == '100-500') { echo 'selected'; } ?>>£100-500</option>
            <option value="600-1000" <?php if ($cja_coursesearch->deposit_required == '600-1000') { echo 'selected'; } ?>>£600-1000</option>
            <option value="1000+" <?php if ($cja_coursesearch->deposit_required == '1000+') { echo 'selected'; } ?>>£1000+</option>
            <option value="half_prie" <?php if ($cja_coursesearch->deposit_required == 'half_prie') { echo 'selected'; } ?>>Half Price</option>
            <option value="full_payment" <?php if ($cja_coursesearch->deposit_required == 'full_payment') { echo 'selected'; } ?>>Full Payment Required</option>
            <option value="negotiated" <?php if ($cja_coursesearch->deposit_required == 'negotiated') { echo 'selected'; } ?>>Can be negotiated based on your current circumstances</option>
            <option value="refer_ad" <?php if ($cja_coursesearch->deposit_required == 'refer_ad') { echo 'selected'; } ?>>Refer to Ad</option>
            <option value="other" <?php if ($cja_coursesearch->deposit_required == 'other') { echo 'selected'; } ?>>Other</option>
        </select>

        <p class="label">Career Level</p>
        <select name="career_level" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="manager" <?php if ($cja_coursesearch->career_level == 'manager') { echo 'selected'; } ?>>Manager</option>
            <option value="officer" <?php if ($cja_coursesearch->career_level == 'officer') { echo 'selected'; } ?>>Officer</option>
            <option value="student" <?php if ($cja_coursesearch->career_level == 'student') { echo 'selected'; } ?>>Student</option>
            <option value="executive" <?php if ($cja_coursesearch->career_level == 'executive') { echo 'selected'; } ?>>Executive</option>
            <option value="consultant" <?php if ($cja_coursesearch->career_level == 'consultant') { echo 'selected'; } ?>>Consultant</option>
            <option value="entry_level" <?php if ($cja_coursesearch->career_level == 'entry_level') { echo 'selected'; } ?>>Entry Level</option>
            <option value="other" <?php if ($cja_coursesearch->career_level == 'other') { echo 'selected'; } ?>>Other</option>
            <option value="any_level" <?php if ($cja_coursesearch->career_level == 'any_level') { echo 'selected'; } ?>>Any Level</option>
        </select>

        <p class="label">Experience Required</p>
        <select name="experience_required" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="none" <?php if ($cja_coursesearch->experience_required == 'none') { echo 'selected'; } ?>>None</option>
            <option value="3months" <?php if ($cja_coursesearch->experience_required == '3months') { echo 'selected'; } ?>>Up to 3 Months</option>
            <option value="6months" <?php if ($cja_coursesearch->experience_required == '6months') { echo 'selected'; } ?>>Up to 6 Months</option>
            <option value="1year" <?php if ($cja_coursesearch->experience_required == '1year') { echo 'selected'; } ?>>Up to 1 Year</option>
            <option value="2year" <?php if ($cja_coursesearch->experience_required == '2year') { echo 'selected'; } ?>>2 Years Plus</option>
        </select>

        <p class="label">Training Provider Type</p>
        <select name="provider_type" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="university" <?php if ($cja_coursesearch->provider_type == 'university') { echo 'selected'; } ?>>University</option>
            <option value="college" <?php if ($cja_coursesearch->provider_type == 'college') { echo 'selected'; } ?>>College</option>
            <option value="private_training" <?php if ($cja_coursesearch->provider_type == 'private_training') { echo 'selected'; } ?>>Private Training Provider</option>
            <option value="private_freelancer" <?php if ($cja_coursesearch->provider_type == 'private_freelancer') { echo 'selected'; } ?>>Private Freelancer</option>
            <option value="government_organisation" <?php if ($cja_coursesearch->provider_type == 'government_organisation') { echo 'selected'; } ?>>Government Organisation</option>
            <option value="recruitment_agency" <?php if ($cja_coursesearch->provider_type == 'recruitment_agency') { echo 'selected'; } ?>>Recruitment Agency</option>
            <option value="employer" <?php if ($cja_coursesearch->provider_type == 'employer') { echo 'selected'; } ?>>Employer</option>
            <option value="online_programme" <?php if ($cja_coursesearch->provider_type == 'online_programme') { echo 'selected'; } ?>>Online Programme</option>
            <option value="other" <?php if ($cja_coursesearch->provider_type == 'other') { echo 'selected'; } ?>>Other</option>
        </select>

        <p class="label">Previous Qualification Required</p>
        <select name="previous_qualification" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="none" <?php if ($cja_coursesearch->previous_qualification == 'none') { echo 'selected'; } ?>>None Required</option>
            <option value="gcse" <?php if ($cja_coursesearch->previous_qualification == 'gcse') { echo 'selected'; } ?>>GCSE's</option>
            <option value="alevels" <?php if ($cja_coursesearch->previous_qualification == 'alevels') { echo 'selected'; } ?>>A Levels</option>
            <option value="award" <?php if ($cja_coursesearch->previous_qualification == 'award') { echo 'selected'; } ?>>Award</option>
            <option value="certificate" <?php if ($cja_coursesearch->previous_qualification == 'certificate') { echo 'selected'; } ?>>Certificate</option>
            <option value="diploma" <?php if ($cja_coursesearch->previous_qualification == 'diploma') { echo 'selected'; } ?>>Diploma</option>
            <option value="studying_degree" <?php if ($cja_coursesearch->previous_qualification == 'studying_degree') { echo 'selected'; } ?>>Studying towards a Degree</option>
            <option value="degree" <?php if ($cja_coursesearch->previous_qualification == 'degree') { echo 'selected'; } ?>>Degree</option>
            <option value="masters_degree" <?php if ($cja_coursesearch->previous_qualification == 'masters_degree') { echo 'selected'; } ?>>Masters Degree</option>
            <option value="doctorate_degree" <?php if ($cja_coursesearch->previous_qualification == 'doctorate_degree') { echo 'selected'; } ?>>Doctorate Degree</option>
        </select>

        <p class="label">Course Pathway</p>
        <select name="course_pathway" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="work_university" <?php if ($cja_coursesearch->course_pathway == 'work_university') { echo 'selected'; } ?>>Courses for both Work & University Progression</option>
            <option value="university" <?php if ($cja_coursesearch->course_pathway == 'university') { echo 'selected'; } ?>>Courses for University Progression</option>
            <option value="employment" <?php if ($cja_coursesearch->course_pathway == 'employment') { echo 'selected'; } ?>>Courses to Enter Employment</option>
            <option value="cpd_only" <?php if ($cja_coursesearch->course_pathway == 'cpd_only') { echo 'selected'; } ?>>CPD Development Only</option>
            <option value="career_development" <?php if ($cja_coursesearch->course_pathway == 'career_development') { echo 'selected'; } ?>>Courses for Career Development (CPD)</option>
        </select>

        <p class="label">Course Funding Options</p>
        <select name="funding_options" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="all_options" <?php if ($cja_coursesearch->funding_options == 'all_options') { echo 'selected'; } ?>>All Options</option>
            <option value="self_funded_full" <?php if ($cja_coursesearch->funding_options == 'self_funded_full') { echo 'selected'; } ?>>Self-funded - Full Payment Required</option>
            <option value="self_funded_plan" <?php if ($cja_coursesearch->funding_options == 'self_funded_plan') { echo 'selected'; } ?>>Self-funded - Payment Plan Available</option>
            <option value="student_loan" <?php if ($cja_coursesearch->funding_options == 'student_loan') { echo 'selected'; } ?>>Student Loan</option>
            <option value="fully_funded" <?php if ($cja_coursesearch->funding_options == 'fully_funded') { echo 'selected'; } ?>>Fully Funded</option>
            <option value="funded_16" <?php if ($cja_coursesearch->funding_options == 'funded_16') { echo 'selected'; } ?>>Funded (16-18s & Eligible 19s)</option>
        </select>

        <p class="label">Payment Plan</p>
        <select name="payment_plan" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="yes" <?php if ($cja_coursesearch->payment_plan == 'yes') { echo 'selected'; } ?>>Yes</option>
            <option value="no" <?php if ($cja_coursesearch->payment_plan == 'no') { echo 'selected'; } ?>>No</option>
            <option value="discussed" <?php if ($cja_coursesearch->payment_plan == 'discussed') { echo 'selected'; } ?>>Can Be Discussed</option>
        </select>

        <p class="label">Qualification Level</p>
        <select name="qualification_level" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="entry12" <?php if ($cja_coursesearch->qualification_level == 'entry12') { echo 'selected'; } ?>>Entry Level, Level 1 or Level 2</option>
            <option value="all" <?php if ($cja_coursesearch->qualification_level == 'all') { echo 'selected'; } ?>>All Levels</option>
            <option value="entry" <?php if ($cja_coursesearch->qualification_level == 'entry') { echo 'selected'; } ?>>Entry Level</option>
            <option value="level1" <?php if ($cja_coursesearch->qualification_level == 'level1') { echo 'selected'; } ?>>Level 1</option>
            <option value="level2" <?php if ($cja_coursesearch->qualification_level == 'level2') { echo 'selected'; } ?>>Level 2</option>
            <option value="level3" <?php if ($cja_coursesearch->qualification_level == 'level3') { echo 'selected'; } ?>>Level 3</option>
            <option value="level47" <?php if ($cja_coursesearch->qualification_level == 'level47') { echo 'selected'; } ?>>Level 4-7</option>
            <option value="other" <?php if ($cja_coursesearch->qualification_level == 'other') { echo 'selected'; } ?>>Other</option>
        </select>

        <p class="label">Qualification Type</p>
        <select name="qualification_type" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="award" <?php if ($cja_coursesearch->qualification_type == 'award') { echo 'selected'; } ?>>Award</option>
            <option value="certificate" <?php if ($cja_coursesearch->qualification_type == 'certificate') { echo 'selected'; } ?>>Certificate</option>
            <option value="diploma" <?php if ($cja_coursesearch->qualification_type == 'diploma') { echo 'selected'; } ?>>Diploma</option>
            <option value="extended_diploma" <?php if ($cja_coursesearch->qualification_type == 'extended_diploma') { echo 'selected'; } ?>>Extended Diploma</option>
            <option value="subsidiary_diploma" <?php if ($cja_coursesearch->qualification_type == 'subsidiary_diploma') { echo 'selected'; } ?>>Subsidiary Diploma</option>
            <option value="90credit" <?php if ($cja_coursesearch->qualification_type == '90credit') { echo 'selected'; } ?>>90 Credit Diploma</option>
            <option value="degree" <?php if ($cja_coursesearch->qualification_type == 'degree') { echo 'selected'; } ?>>Degree</option>
            <option value="associate_degree" <?php if ($cja_coursesearch->qualification_type == 'associate_degree') { echo 'selected'; } ?>>Associate Degree</option>
            <option value="hnd" <?php if ($cja_coursesearch->qualification_type == 'hnd') { echo 'selected'; } ?>>HND</option>
            <option value="hnc" <?php if ($cja_coursesearch->qualification_type == 'hnc') { echo 'selected'; } ?>>HNC</option>
            <option value="masters_degree" <?php if ($cja_coursesearch->qualification_type == 'masters_degree') { echo 'selected'; } ?>>Masters Degree</option>
            <option value="doctorate_degree" <?php if ($cja_coursesearch->qualification_type == 'doctorate_degree') { echo 'selected'; } ?>>Doctorate Degree</option>
            <option value="gcse" <?php if ($cja_coursesearch->qualification_type == 'gcse') { echo 'selected'; } ?>>GCSE</option>
            <option value="alevel" <?php if ($cja_coursesearch->qualification_type == 'alevel') { echo 'selected'; } ?>>A Levels</option>
        </select>
<!--
<p class="label">Contact for Course Enquiry</p>
<select name="contact_for_enquiry" form="edit_course_search_form">
    <option value="">-- Any --</option>
    <option value="phone" <?php if ($cja_coursesearch->contact_for_enquiry == 'phone') { echo 'selected'; } ?>>Phone</option>
    <option value="email" <?php if ($cja_coursesearch->contact_for_enquiry == 'email') { echo 'selected'; } ?>>Email</option>
    <option value="discuss" <?php if ($cja_coursesearch->contact_for_enquiry == 'discuss') { echo 'selected'; } ?>>Can be discussed</option>
</select>
--> 

        <p class="label">Total Units</p>
        <select name="total_units" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="1unit" <?php if ($cja_coursesearch->total_units == '1unit') { echo 'selected'; } ?>>1 unit</option>
            <option value="2unit" <?php if ($cja_coursesearch->total_units == '2unit') { echo 'selected'; } ?>>2 units</option>
            <option value="3unit" <?php if ($cja_coursesearch->total_units == '3unit') { echo 'selected'; } ?>>3 units</option>
            <option value="4unit" <?php if ($cja_coursesearch->total_units == '4unit') { echo 'selected'; } ?>>4 units</option>
            <option value="5unit" <?php if ($cja_coursesearch->total_units == '5unit') { echo 'selected'; } ?>>5 units</option>
            <option value="6unit" <?php if ($cja_coursesearch->total_units == '6unit') { echo 'selected'; } ?>>6 units</option>
            <option value="7unit" <?php if ($cja_coursesearch->total_units == '7unit') { echo 'selected'; } ?>>7 units</option>
            <option value="8unit" <?php if ($cja_coursesearch->total_units == '8unit') { echo 'selected'; } ?>>8 units</option>
            <option value="9unit" <?php if ($cja_coursesearch->total_units == '9unit') { echo 'selected'; } ?>>9 units</option>
            <option value="10unit" <?php if ($cja_coursesearch->total_units == '10unit') { echo 'selected'; } ?>>10 units</option>
            <option value="11unit" <?php if ($cja_coursesearch->total_units == '11unit') { echo 'selected'; } ?>>11 units</option>
            <option value="12unit" <?php if ($cja_coursesearch->total_units == '12unit') { echo 'selected'; } ?>>12 units</option>
            <option value="13unit" <?php if ($cja_coursesearch->total_units == '13unit') { echo 'selected'; } ?>>13 units</option>
            <option value="14unit" <?php if ($cja_coursesearch->total_units == '14unit') { echo 'selected'; } ?>>14 units</option>
            <option value="15unit" <?php if ($cja_coursesearch->total_units == '15unit') { echo 'selected'; } ?>>15 units</option>
            <option value="16unit" <?php if ($cja_coursesearch->total_units == '16unit') { echo 'selected'; } ?>>16 units</option>
            <option value="17unit" <?php if ($cja_coursesearch->total_units == '17unit') { echo 'selected'; } ?>>17 units</option>
            <option value="18unit" <?php if ($cja_coursesearch->total_units == '18unit') { echo 'selected'; } ?>>18 units</option>
            <option value="19unit" <?php if ($cja_coursesearch->total_units == '19unit') { echo 'selected'; } ?>>19 units</option>
            <option value="20unit" <?php if ($cja_coursesearch->total_units == '20unit') { echo 'selected'; } ?>>20+ units</option>
        </select>

        <p class="label">DBS Required</p>
        <select name="dbs_required" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="yes" <?php if ($cja_coursesearch->dbs_required == 'yes') { echo 'selected'; } ?>>Yes</option>
            <option value="no" <?php if ($cja_coursesearch->dbs_required == 'no') { echo 'selected'; } ?>>No</option>
        </select>

        <p class="label">Availability Period</p>
        <select name="availability_period" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="morning" <?php if ($cja_coursesearch->availability_period == 'morning') { echo 'selected'; } ?>>Morning</option>
            <option value="afternoon" <?php if ($cja_coursesearch->availability_period == 'afternoon') { echo 'selected'; } ?>>Afternoon</option>
            <option value="night" <?php if ($cja_coursesearch->availability_period == 'night') { echo 'selected'; } ?>>Night</option>
            <option value="weekend" <?php if ($cja_coursesearch->availability_period == 'weekend') { echo 'selected'; } ?>>Weekend</option>
        </select>

        <p class="label">Allowance Available</p>
        <select name="allowance_available" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="bursary" <?php if ($cja_coursesearch->allowance_available == 'bursary') { echo 'selected'; } ?>>Bursary</option>
            <option value="care_to_learn" <?php if ($cja_coursesearch->allowance_available == 'care_to_learn') { echo 'selected'; } ?>>Care to Learn for Childcare</option>
            <option value="dbs_check" <?php if ($cja_coursesearch->allowance_available == 'dbs_check') { echo 'selected'; } ?>>DBS Check Allowance</option>
            <option value="travel_expense" <?php if ($cja_coursesearch->allowance_available == 'travel_expense') { echo 'selected'; } ?>>Travel Expense</option>
            <option value="meal" <?php if ($cja_coursesearch->allowance_available == 'meal') { echo 'selected'; } ?>>Meal e.g. Lunch</option>
            <option value="other" <?php if ($cja_coursesearch->allowance_available == 'other') { echo 'selected'; } ?>>Other - Can be Discussed</option>
        </select>

        <p class="label">Awarding Body</p>
        <select name="awarding_body" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="edexcel" <?php if ($cja_coursesearch->awarding_body == 'edexcel') { echo 'selected'; } ?>>Edexcel</option>
            <option value="ncfe" <?php if ($cja_coursesearch->awarding_body == 'ncfe') { echo 'selected'; } ?>>NCFE</option>
            <option value="high_fields" <?php if ($cja_coursesearch->awarding_body == 'high_fields') { echo 'selected'; } ?>>High Fields</option>
            <option value="cache" <?php if ($cja_coursesearch->awarding_body == 'cache') { echo 'selected'; } ?>>CACHE</option>
            <option value="ocr" <?php if ($cja_coursesearch->awarding_body == 'ocr') { echo 'selected'; } ?>>OCR</option>
            <option value="aqa" <?php if ($cja_coursesearch->awarding_body == 'aqa') { echo 'selected'; } ?>>AQA</option>
            <option value="city_guilds" <?php if ($cja_coursesearch->awarding_body == 'city_guilds') { echo 'selected'; } ?>>City & Guilds</option>
            <option value="other" <?php if ($cja_coursesearch->awarding_body == 'other') { echo 'selected'; } ?>>Other</option>
        </select>

        <p class="label">Duration</p>
        <select name="duration" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="depends_assessment" <?php if ($cja_coursesearch->duration == 'depends_assessment') { echo 'selected'; } ?>>It depends on assessment</option>
            <option value="own_pace" <?php if ($cja_coursesearch->duration == 'own_pace') { echo 'selected'; } ?>>At your own pace</option>
            <option value="6weeks" <?php if ($cja_coursesearch->duration == '6weeks') { echo 'selected'; } ?>>Less than 6 weeks</option>
            <option value="3months" <?php if ($cja_coursesearch->duration == '3months') { echo 'selected'; } ?>>Up to 3 months</option>
            <option value="6months" <?php if ($cja_coursesearch->duration == '6months') { echo 'selected'; } ?>>Up to 6 months</option>
            <option value="1year" <?php if ($cja_coursesearch->duration == '1year') { echo 'selected'; } ?>>Up to 1 year</option>
            <option value="18month" <?php if ($cja_coursesearch->duration == '18month') { echo 'selected'; } ?>>Up to 18 months</option>
            <option value="2year" <?php if ($cja_coursesearch->duration == '2year') { echo 'selected'; } ?>>Up to 2 years</option>
            <option value="3year" <?php if ($cja_coursesearch->duration == '3year') { echo 'selected'; } ?>>Up to 3 years</option>
            <option value="4year" <?php if ($cja_coursesearch->duration == '4year') { echo 'selected'; } ?>>Up to 4 years</option>
            <option value="depends_agreed" <?php if ($cja_coursesearch->duration == 'depends_agreed') { echo 'selected'; } ?>>It depends on what is agreed</option>
        </select>

        <p class="label">Suitable for Those on Benefits</p>
        <select name="suitable_benefits" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="universal_credit" <?php if ($cja_coursesearch->suitable_benefits == 'universal_credit') { echo 'selected'; } ?>>Yes - Universal Credit</option>
            <option value="esa" <?php if ($cja_coursesearch->suitable_benefits == 'esa') { echo 'selected'; } ?>>Yes - ESA</option>
            <option value="housing_allowance" <?php if ($cja_coursesearch->suitable_benefits == 'housing_allowance') { echo 'selected'; } ?>>Yes - Housing Allowance</option>
            <option value="child_tax" <?php if ($cja_coursesearch->suitable_benefits == 'child_tax') { echo 'selected'; } ?>>Yes - Child Tax Credit</option>
            <option value="income_support" <?php if ($cja_coursesearch->suitable_benefits == 'income_support') { echo 'selected'; } ?>>Yes - Income Support</option>
            <option value="other" <?php if ($cja_coursesearch->suitable_benefits == 'other') { echo 'selected'; } ?>>Yes - Other</option>
            <option value="not_applicable" <?php if ($cja_coursesearch->suitable_benefits == 'not_applicable') { echo 'selected'; } ?>>Not Applicable</option>
        </select>

        <p class="label">Social Services - Service Users</p>
        <select name="social_services" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="care" <?php if ($cja_coursesearch->social_services == 'care') { echo 'selected'; } ?>>Course is suitable for those in care</option>
            <option value="care_leavers" <?php if ($cja_coursesearch->social_services == 'care_leavers') { echo 'selected'; } ?>>Course is suitable for care leavers</option>
            <option value="prepare" <?php if ($cja_coursesearch->social_services == 'prepare') { echo 'selected'; } ?>>Course is suitable for those who are preparing to leave care</option>
            <option value="not_applicable" <?php if ($cja_coursesearch->social_services == 'not_applicable') { echo 'selected'; } ?>>Not Applicable</option>
        </select>

        <p class="label">Delivery Route</p>
        <select name="delivery_route" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="paid_work" <?php if ($cja_coursesearch->delivery_route == 'paid_work') { echo 'selected'; } ?>>Paid Work with a Course</option>
            <option value="classroom_only" <?php if ($cja_coursesearch->delivery_route == 'classroom_only') { echo 'selected'; } ?>>Classroom Delivery Only</option>
            <option value="work_based_learning" <?php if ($cja_coursesearch->delivery_route == 'work_based_learning') { echo 'selected'; } ?>>Work-based Learning - No Classroom</option>
            <option value="classroom_work" <?php if ($cja_coursesearch->delivery_route == 'classroom_work') { echo 'selected'; } ?>>Classroom & Work-based</option>
            <option value="work_experience" <?php if ($cja_coursesearch->delivery_route == 'work_experience') { echo 'selected'; } ?>>Work Experience with a Course</option>
            <option value="online_only" <?php if ($cja_coursesearch->delivery_route == 'online_only') { echo 'selected'; } ?>>Online Course Only</option>
            <option value="online_classroom" <?php if ($cja_coursesearch->delivery_route == 'online_classroom') { echo 'selected'; } ?>>Online & Classroom</option>
            <option value="distance_learning" <?php if ($cja_coursesearch->delivery_route == 'distance_learning') { echo 'selected'; } ?>>Distance Learning (paper-based only)</option>
        </select>

        <p class="label">Available to Start</p>
        <select name="available_start" form="edit_course_search_form">
            <option value="">-- Any --</option>
            <option value="immediately" <?php if ($cja_coursesearch->available_start == 'immediately') { echo 'selected'; } ?>>Immediately</option>
            <option value="few_days" <?php if ($cja_coursesearch->available_start == 'few_days') { echo 'selected'; } ?>>Within a few days</option>
            <option value="2weeks" <?php if ($cja_coursesearch->available_start == '2weeks') { echo 'selected'; } ?>>Within the next 2 weeks</option>
            <option value="month" <?php if ($cja_coursesearch->available_start == 'month') { echo 'selected'; } ?>>Within a month</option>
            <option value="68weeks" <?php if ($cja_coursesearch->available_start == '68weeks') { echo 'selected'; } ?>>Within 6 to 8 weeks</option>
            <option value="flexible" <?php if ($cja_coursesearch->available_start == 'flexible') { echo 'selected'; } ?>>Flexible</option>
        </select>

        <?php if ($cja_user->postcode) { ?>
            <p class="label">Order Results By</p>
            <select name="order_by" form="edit_course_search_form">
                <option value="date">Newest Courses First</option>
                <option value="distance" <?php if ($cja_coursesearch->order_by == 'distance') { echo 'selected'; } ?>>Closest Courses First</option>
            </select>
        <?php } else { ?>
            <input type="hidden" name="order_by" value="date">
        <?php } ?>

        <p><input type="checkbox" name="show_applied" <?php if ($cja_coursesearch->show_applied) { echo 'checked'; } ?>> Include courses I have already applied for</p>

        <input type="hidden" name="update_course_search" value="true">
        <input type="hidden" name="cja_set_course_cookies" value="true">

        <p>
            <input type="submit" class="cja_button cja_button--2" value="Search Courses">
        </p>
    </form>

    <?php
    $display_search = false;
}

?>