<?php

class CJA_Advert {

    /**
     * PROPERTIES
     */

    public $id; // ID of advert post
    public $ad_type; // job_ad or course_ad 
    public $status; // active, expired, etc.
    public $expiry_date; // expiry date as timestamp
    public $activation_date; // activation date as timestamp
    public $human_activation_date; // human readable
    public $days_old;
    public $days_left;
    public $author; // ID of user placing ad
    public $author_human_name; // Humain readable author (company) name
    public $created_by_current_user; // Boolean
    public $applied_to_by_current_user; // Boolean
    
    // Form fields
    public $title;
    public $salary_numeric;
    public $salary_per;
    public $content; // job description
    public $job_type;
    public $sector;
    public $contact_person;
    public $contact_phone_number;
    public $career_level;
    public $experience_required;
    public $employer_type;
    public $minimum_qualification;
    public $dbs_required;
    public $payment_frequency;
    public $shift_work;
    public $shifts = array();
    public $location_options;
    public $deadline; // YYYY-MM-DD
    public $job_spec_filename;
    public $job_spec_url;

    /**
     * CONSTRUCTOR
     */

    function __construct($id = 0) {
        if($id) {
            $this->id = $id;
            $this->ad_type = get_post_type($id);
            $this->status = get_post_meta($id, 'cja_ad_status', true);
            $this->expiry_date = get_post_meta($id, 'cja_ad_expiry_date', true);
            $this->activation_date = get_post_meta($id, 'cja_ad_activation_date', true);
            $this->human_activation_date = $this->get_human_activation_date();
            $this->days_left = $this->days_left();
            $this->days_old = $this->get_days_old();
            $this->author = get_post_field( 'post_author', $id );
            $this->author_human_name = $this->get_human_name();
            $this->created_by_current_user = $this->is_current_user_ad();
            $this->applied_to_by_current_user = $this->is_applied_to_by_current_user();
            
            // Form Fields
            $this->title = get_the_title($id);
            $this->salary_numeric = get_post_meta($id, 'cja_salary_numeric', true);
            $this->salary_per = get_post_meta($id, 'cja_salary_per', true);
            $this->content = get_the_content(null, false, $id);
            $this->job_type = get_post_meta($id, 'cja_job_type', true);
            $this->sector = get_post_meta($id, 'cja_sector', true);
            $this->contact_person = get_post_meta($id, 'cja_contact_person', true);
            $this->contact_phone_number = get_post_meta($id, 'cja_contact_phone_number', true);
            $this->career_level = get_post_meta($id, 'cja_career_level', true);
            $this->experience_required = get_post_meta($id, 'cja_experience_required', true);
            $this->employer_type = get_post_meta($id, 'cja_employer_type', true);
            $this->minimum_qualification = get_post_meta($id, 'cja_minimum_qualification', true);
            $this->dbs_required = get_post_meta($id, 'cja_dbs_required', true);
            $this->payment_frequency = get_post_meta($id, 'cja_payment_frequency', true);
            $this->shift_work = get_post_meta($id, 'cja_shift_work', true);
            $this->shifts = unserialize(get_post_meta($id, 'cja_shifts', true));
            $this->location_options = get_post_meta($id, 'cja_location_options', true);
            $this->deadline = get_post_meta($id, 'cja_deadline', true);
            $this->job_spec_filename = get_post_meta($id, 'cja_job_spec_filename', true);
            $this->job_spec_url = get_post_meta($id, 'cja_job_spec_url', true);
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Create a new WP Post
    public function create() {
        $postarray = array(
            'post_type' => 'job_ad',
            'post_status' => 'publish'
        );
        $this->id = wp_insert_post( $postarray, true );
        $this->status = 'inactive';
        $this->expiry_date = 100;
        return $this->id;
    }

    // Update object from $_POST data
    public function update_from_form() {
        if ($_POST['ad-title']) {
            $this->title = $_POST['ad-title'];
        }
        if (array_key_exists('salary_numeric',$_POST)) {
            $sal_num = (float) filter_var( $_POST['salary_numeric'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $this->salary_numeric = $sal_num;
        }
        if (array_key_exists('salary_per',$_POST)) {
            $this->salary_per = $_POST['salary_per'];
        }
        if (array_key_exists('ad-content',$_POST)) {
            $this->content = $_POST['ad-content'];
        }
        if (array_key_exists('job_type',$_POST)) {
            $this->job_type = $_POST['job_type'];
        }
        if (array_key_exists('sector',$_POST)) {
            $this->sector = $_POST['sector'];
        }
        if (array_key_exists('contact_person',$_POST)) {
            $this->contact_person = $_POST['contact_person'];
        }
        if (array_key_exists('contact_phone_number',$_POST)) {
            $this->contact_phone_number = $_POST['contact_phone_number'];
        }
        if (array_key_exists('career_level',$_POST)) {
            $this->career_level = $_POST['career_level'];
        }
        if (array_key_exists('experience_required',$_POST)) {
            $this->experience_required = $_POST['experience_required'];
        }
        if (array_key_exists('employer_type',$_POST)) {
            $this->employer_type = $_POST['employer_type'];
        }
        if (array_key_exists('minimum_qualification',$_POST)) {
            $this->minimum_qualification = $_POST['minimum_qualification'];
        }
        if (array_key_exists('dbs_required',$_POST)) {
            $this->dbs_required = $_POST['dbs_required'];
        }
        if (array_key_exists('payment_frequency',$_POST)) {
            $this->payment_frequency = $_POST['payment_frequency'];
        }
        if (array_key_exists('shift_work',$_POST)) {
            $this->shift_work = $_POST['shift_work'];
        }
        if (array_key_exists('shifts',$_POST)) {
            $this->shifts = $_POST['shifts'];
        }
        if (array_key_exists('location_options',$_POST)) {
            $this->location_options = $_POST['location_options'];
        }
        if (array_key_exists('deadline',$_POST)) {
            $this->deadline = $_POST['deadline'];
        }
        if ( $_FILES['job_specification']['size'] != 0 ) {
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['job_specification'];

            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->job_spec_filename = $uploadedfile['name'];
            $this->job_spec_url = $movefile['url'];
        }
    }

    // Update all properties in the WP database
    public function save() {
        $values = array(
            'ID'           => $this->id,
            'post_title'   => $this->title,
            'post_content' => $this->content,
        );
        wp_update_post( $values );

        update_post_meta($this->id, 'cja_ad_status', $this->status);
        update_post_meta($this->id, 'cja_ad_expiry_date', $this->expiry_date);
        update_post_meta($this->id, 'cja_ad_activation_date', $this->activation_date);

        // form fields
        update_post_meta($this->id, 'cja_salary_numeric', $this->salary_numeric);
        update_post_meta($this->id, 'cja_salary_per', $this->salary_per);
        update_post_meta($this->id, 'cja_job_type', $this->job_type);
        update_post_meta($this->id, 'cja_sector', $this->sector);
        update_post_meta($this->id, 'cja_contact_person', $this->contact_person);
        update_post_meta($this->id, 'cja_contact_phone_number', $this->contact_phone_number);
        update_post_meta($this->id, 'cja_career_level', $this->career_level);
        update_post_meta($this->id, 'cja_experience_required', $this->experience_required);
        update_post_meta($this->id, 'cja_employer_type', $this->employer_type);
        update_post_meta($this->id, 'cja_minimum_qualification', $this->minimum_qualification);
        update_post_meta($this->id, 'cja_dbs_required', $this->dbs_required);
        update_post_meta($this->id, 'cja_payment_frequency', $this->payment_frequency);
        update_post_meta($this->id, 'cja_shift_work', $this->shift_work);
        update_post_meta($this->id, 'cja_shifts', serialize($this->shifts));
        update_post_meta($this->id, 'cja_location_options', $this->location_options);
        update_post_meta($this->id, 'cja_deadline', $this->deadline);
        update_post_meta($this->id, 'cja_job_spec_filename', $this->job_spec_filename);
        update_post_meta($this->id, 'cja_job_spec_url', $this->job_spec_url);
    }

    // Activate the advert
    public function activate() {
        $this->status = 'active';
        $this->activation_date = strtotime(date('j F Y'));
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y')))));
    }

    // Extend the advert
    public function extend() {
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", $this->expiry_date)));
    }

    // Delete ad (not delete post but set status to deleted)
    public function delete() {
        $this->status = 'deleted';
    }

    public function return_human($field) {
        if ($field == 'job_type') {
            if ($this->job_type == 'full_time') { return 'Full Time'; }
            if ($this->job_type == 'part_time') { return 'Part Time'; }
            if ($this->job_type == 'freelance') { return 'Freelance'; }
            if ($this->job_type == 'intern') { return 'Internship'; }
            if ($this->job_type == 'temporary') { return 'Temporary'; }
            if ($this->job_type == 'volunteer') { return 'Volunteer'; }
            if ($this->job_type == 'work_based_learning') { return 'Work Based Learning'; }
            if ($this->job_type == 'other') { return 'Other'; }
        }

        if ($field == 'sector') {
            if ($this->sector == 'accountancy_business_finance') { return 'Accountancy, Business and Finance'; }
            if ($this->sector == 'business_consulting_management') { return 'Business, Consulting and Management'; }
            if ($this->sector == 'charity_voluntary') { return 'Charity and Voluntary Work'; }
            if ($this->sector == 'creative_design') { return 'Creative Arts and Design'; }
            if ($this->sector == 'energy_utilities') { return 'Energy and Utilities'; }
            if ($this->sector == 'engineering_manufacturing') { return 'Engineering and Manufacturing'; }
            if ($this->sector == 'environment_agriculture') { return 'Environment and Agriculture'; }
            if ($this->sector == 'healthcare') { return 'Healthcare'; }
            if ($this->sector == 'hospitality_events') { return 'Hospitality and Events Management'; }
            if ($this->sector == 'information_technology') { return 'Information Technology'; }
            if ($this->sector == 'law') { return 'Law'; }
            if ($this->sector == 'law_enforcement_security') { return 'Law Enforcement and Security'; }
            if ($this->sector == 'leisure_sport_tourism') { return 'Leisure, Sport and Tourism'; }
            if ($this->sector == 'marketing_advertising_pr') { return 'Marketing, Advertising and PR'; }
            if ($this->sector == 'media_internet') { return 'Media and Internet'; }
            if ($this->sector == 'property_construction') { return 'Property and Construction'; }
            if ($this->sector == 'public_services_administration') { return 'Public Services and Administration'; }
            if ($this->sector == 'recruitment_hr') { return 'Recruitment and HR'; }
            if ($this->sector == 'retail') { return 'Retail'; }
            if ($this->sector == 'sales') { return 'Sales'; }
            if ($this->sector == 'science_pharmaceuticals') { return 'Science and Pharmaceuticals'; }
            if ($this->sector == 'social_care') { return 'Social Care'; }
            if ($this->sector == 'teacher_education') { return 'Teacher Training and Education'; }
            if ($this->sector == 'transport_logistics') { return 'Transport and Logistics'; }
        }

        if ($field == 'career_level') {
            if ($this->career_level == 'student') { return 'Student'; }
            if ($this->career_level == 'intern') { return 'Intern'; }
            if ($this->career_level == 'trainee') { return 'Trainee'; }
            if ($this->career_level == 'entry_level') { return 'Entry Level'; }
            if ($this->career_level == 'apprentice') { return 'Apprentice'; }
            if ($this->career_level == 'team_leader') { return 'Team Leader'; }
            if ($this->career_level == 'manager') { return 'Manager'; }
            if ($this->career_level == 'consultant') { return 'Consultant'; }
            if ($this->career_level == 'executive') { return 'Executive'; }
        }

        if ($field == 'experience_required') {
            if ($this->experience_required == 'none') { return 'None'; }
            if ($this->experience_required == '3months') { return '3 Months'; }
            if ($this->experience_required == '6months') { return '6 Months'; }
            if ($this->experience_required == '1year') { return '1 Year'; }
            if ($this->experience_required == '2years') { return '2 Years'; }
            if ($this->experience_required == '3years') { return '3 Years'; }
            if ($this->experience_required == '4years') { return '4+ Years'; }
        }

        if ($field == 'employer_type') {
            if ($this->employer_type == 'university') { return 'University'; }
            if ($this->employer_type == 'college') { return 'College'; }
            if ($this->employer_type == 'private_training_provider') { return 'Private Training Provider'; }
            if ($this->employer_type == 'private_individual') { return 'Private Individual'; }
            if ($this->employer_type == 'recruitment_agency') { return 'Recruitment Agency'; }
            if ($this->employer_type == 'employer_large') { return 'Employer (large)'; }
            if ($this->employer_type == 'employer_medium') { return 'Employer (medium)'; }
            if ($this->employer_type == 'employer_small') { return 'Employer (small)'; }
            if ($this->employer_type == 'sole_trader') { return 'Sole Trader'; }
            if ($this->employer_type == 'charity') { return 'Charity'; }
            if ($this->employer_type == 'government_organisation') { return 'Government Organisation'; }
            if ($this->employer_type == 'other') { return 'Other'; }
        }

        if ($field == 'minimum_qualification') {
            if ($this->minimum_qualification == 'gcse') { return 'GCSE\'s'; }
            if ($this->minimum_qualification == 'alevels') { return 'A Levels'; }
            if ($this->minimum_qualification == 'award') { return 'Award'; }
            if ($this->minimum_qualification == 'certificate') { return 'Certificate'; }
            if ($this->minimum_qualification == 'diploma') { return 'Diploma'; }
            if ($this->minimum_qualification == 'studying_degree') { return 'Studying towards a Degree'; }
            if ($this->minimum_qualification == 'degree') { return 'Degree'; }
            if ($this->minimum_qualification == 'masters_degree') { return 'Masters Degree'; }
            if ($this->minimum_qualification == 'doctorate_degree') { return 'Doctorate Degree'; }
        }

        if ($field == 'dbs_required') {
            if ($this->dbs_required == 'yes') { return 'Yes'; }
            if ($this->dbs_required == 'no') { return 'No'; }
            if ($this->dbs_required == 'arranged') { return 'Can Be Arranged'; }
        }

        if ($field == 'payment_frequency') {
            if ($this->payment_frequency == 'daily') { return 'Daily'; }
            if ($this->payment_frequency == 'weekly') { return 'Weekly'; }
            if ($this->payment_frequency == 'fortnightly') { return 'Fortnightly'; }
            if ($this->payment_frequency == 'monthly') { return 'Monthly'; }
            if ($this->payment_frequency == 'to_be_discussed') { return 'To Be Discussed'; }
        }

        if ($field == 'shift_work') {
            if ($this->shift_work == 'yes') { return 'Yes'; }
            if ($this->shift_work == 'no') { return 'No'; }
        }

        if ($field == 'shifts') {
            $return_string = '';
            $first = true;
            foreach ($this->shifts as $current_field) {
                if (!$first) {
                    $return_string .= ", ";
                }
                if ($current_field == 'morning') { $return_string .= 'Morning'; }
                if ($current_field == 'afternoon') { $return_string .= 'Afternoon'; }
                if ($current_field == 'evening') { $return_string .= 'Evening'; }
                if ($current_field == 'night') { $return_string .= 'Night'; }
                $first = false;
            }

            return $return_string;
        }

        if ($field == 'location_options') {
            if ($this->location_options == 'on_premises') { return 'On Premises'; }
            if ($this->location_options == 'remotely') { return 'Remotely'; }
            if ($this->location_options == 'both') { return 'On Premises and Remotely'; }
        }

        if ($field == 'deadline') {
            return date("j F Y", strtotime($this->deadline));
        }
    }

    /**
     * PRIVATE FUNCTIONS
     */

    // Calculate number of days left for ad to run as integer
    private function days_left() {
        if ($this->status == 'active') {
            return abs(round($this->expiry_date - strtotime(date('j F Y'))) / 86400);
        } else {
            return 0;
        }
    }

    // Return human friendly activation date
    private function get_human_activation_date() {
        if (is_numeric($this->activation_date)) {
            return date("j F Y", $this->activation_date);
        } else {
            return "Not activated";
        }
    }

    // Return number of days since the ad was activated
    private function get_days_old() {
        $diff = strtotime(date("j F Y")) - $this->activation_date;
        return abs(round($diff / 86400));
    }

    // Return human friendly author (company) name 
    private function get_human_name() {
        return get_user_meta($this->author, 'company_name', true);
    }

    // Is the ad by the current user
    private function is_current_user_ad() {
        if ($this->author == get_current_user_id()) {
            return 1;
        } else {
            return 0;
        }
    }
    
    // Has the ad been applied to by the current user?
    private function is_applied_to_by_current_user() {

        $newargs = array(
            'post_type' => 'application',
            'meta_query' => array(
                array(
                    'key' => 'advertID',
                    'value' => $this->id
                )
            )
        );

        $the_new_query = new WP_Query( $newargs );

        if ( $the_new_query->have_posts() ) {
            while ( $the_new_query->have_posts() ) : $the_new_query->the_post();

                $check_application = new CJA_Application(get_the_ID());
                if ($check_application->applicant_ID == get_current_user_id()) {
                    wp_reset_postdata();
                    return $check_application->id;
                }

            endwhile;
        }

        wp_reset_postdata();
        return 0;
    }
}

?>