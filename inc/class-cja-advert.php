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
    public $hourly_equivalent_rate;
    
    // Form fields
    public $title;
    public $salary_numeric;
    public $salary_per;
    public $content; // job description
    public $job_type;
    public $sector;
    public $contact_person;
    public $contact_phone_number;
    public $postcode = 0;
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
    public $can_apply_online;
    public $show_applied;

    public $files_array = array();
    public $photo_filename;
    public $photo_url;

    // For search
    public $order_by = 'date';
    public $max_distance;

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
            $this->salary_numeric = (float) filter_var( get_post_meta($id, 'cja_salary_numeric', true), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $this->salary_per = get_post_meta($id, 'cja_salary_per', true);
            $this->content = get_the_content(null, false, $id);
            $this->job_type = get_post_meta($id, 'cja_job_type', true);
            $this->sector = get_post_meta($id, 'cja_sector', true);
            $this->contact_person = get_post_meta($id, 'cja_contact_person', true);
            $this->contact_phone_number = get_post_meta($id, 'cja_contact_phone_number', true);
            $this->postcode = get_post_meta($id, 'cja_postcode', true);
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

            $this->hourly_equivalent_rate = $this->get_hourly_equivalent_rate();
            $this->can_apply_online = get_post_meta($id, 'cja_can_apply_online', true);

            $this->files_array = unserialize(get_post_meta($id, 'files_array', true));

            $this->photo_filename = get_post_meta($id, 'photo_filename', true);
            $this->photo_url = get_post_meta($id, 'photo_url', true);
            $this->more_information = get_post_meta($id, 'more_information', true);
        }
    }

    /* FORM FIELDS */

    public $form_fields = array(
        "can_apply_online" => array(
            "meta_field" => true,
            "label" => "Allow applicants to apply online",
            "meta_label" => "cja_can_apply_online",
            "type" => "checkbox",
            "value" => "true"
        ),
        "salary_per" => array(
            "meta_field" => true,
            "label" => "",
            "meta_label" => "cja_salary_per",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "per hour",
                    "value" => "hour"
                ),
                array(
                    "label" => "per day",
                    "value" => "day"
                ),
                array(
                    "label" => "per annum",
                    "value" => "year"
                )
            )
        ),
        "job_type" => array(
            "meta_field" => true,
            "label" => "Job Type",
            "meta_label" => "cja_job_type",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Full Time",
                    "value" => "full_time"
                ),
                array(
                    "label" => "Part Time",
                    "value" => "part_time"
                ),
                array(
                    "label" => "Freelance",
                    "value" => "freelance"
                ),
                array(
                    "label" => "Internship",
                    "value" => "intern"
                ),
                array(
                    "label" => "Temporary",
                    "value" => "temporary"
                ),
                array(
                    "label" => "Volunteer",
                    "value" => "volunteer"
                ),
                array(
                    "label" => "Work-based Learning",
                    "value" => "work_based_learning"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                ),
            )
        ),
        "sector" => array(
            "meta_field" => true,
            "type" => "select",
            "meta_label" => "cja_sector",
            "label" => "Sector",
            "options" => array(
                array(
                    "label" => "Accountancy, Business and Finance",
                    "value" => "accountancy_business_finance"
                ),
                array(
                    "label" => "Business, Consulting and Management",
                    "value" => "business_consulting_management"
                ),
                array(
                    "label" => "Charity and Voluntary Work",
                    "value" => "charity_voluntary"
                ),
                array(
                    "label" => "Creative Arts and Design",
                    "value" => "creative_design"
                ),
                array(
                    "label" => "Energy and Utilities",
                    "value" => "energy_utilities"
                ),
                array(
                    "label" => "Engineering and Manufacturing",
                    "value" => "engineering_manufacturing"
                ),
                array(
                    "label" => "Environment and Agriculture",
                    "value" => "environment_agriculture"
                ),
                array(
                    "label" => "Healthcare",
                    "value" => "healthcare"
                ),
                array(
                    "label" => "Hospitality and Events Management",
                    "value" => "hospitality_events"
                ),
                array(
                    "label" => "Information Technology",
                    "value" => "information_technology"
                ),
                array(
                    "label" => "Law",
                    "value" => "law"
                ),
                array(
                    "label" => "Law Enforcement and Security",
                    "value" => "law_enforcement_security"
                ),
                array(
                    "label" => "Leisure, Sport and Tourism",
                    "value" => "leisure_sport_tourism"
                ),
                array(
                    "label" => "Marketing, Advertising and PR",
                    "value" => "marketing_advertising_pr"
                ),
                array(
                    "label" => "Media and Internet",
                    "value" => "media_internet"
                ),
                array(
                    "label" => "Property and Construction",
                    "value" => "property_construction"
                ),
                array(
                    "label" => "Public Services and Administration",
                    "value" => "public_services_administration"
                ),
                array(
                    "label" => "Recruitment and HR",
                    "value" => "recruitment_hr"
                ),
                array(
                    "label" => "Retail",
                    "value" => "retail"
                ),
                array(
                    "label" => "Sales",
                    "value" => "sales"
                ),
                array(
                    "label" => "Science and Pharmaceuticals",
                    "value" => "science_pharmaceuticals"
                ),
                array(
                    "label" => "Social Care",
                    "value" => "social_care"
                ),
                array(
                    "label" => "Teacher Training and Education",
                    "value" => "teacher_education"
                ),
                array(
                    "label" => "Transport and Logistics",
                    "value" => "transport_logistics"
                ),
            )
        ),
        "contact_person" => array(
            "meta_field" => true,
            "label" => "Contact Person",
            "meta_label" => "cja_contact_person",
            "type" => "text"
        ),
        "contact_phone_number" => array(
            "meta_field" => true,
            "label" => "Contact Phone Number",
            "meta_label" => "cja_contact_phone_number",
            "type" => "text"
        ),
        "postcode" => array(
            "meta_field" => true,
            "label" => "Postcode",
            "meta_label" => "cja_postcode",
            "type" => "text"
        ),
        "career_level" => array(
            "meta_field" => true,
            "label" => "Career Level",
            "meta_label" => "cja_career_level",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Student",
                    "value" => "student"
                ),
                array(
                    "label" => "Intern",
                    "value" => "intern"
                ),
                array(
                    "label" => "Trainee",
                    "value" => "trainee"
                ),
                array(
                    "label" => "Entry Level",
                    "value" => "entry_level"
                ),
                array(
                    "label" => "General Staff",
                    "value" => "general_staff"
                ),
                array(
                    "label" => "Apprentice",
                    "value" => "apprentice"
                ),
                array(
                    "label" => "Team Leader",
                    "value" => "team_leader"
                ),
                array(
                    "label" => "Manager",
                    "value" => "manager"
                ),
                array(
                    "label" => "Consultant",
                    "value" => "consultant"
                ),
                array(
                    "label" => "Executive",
                    "value" => "executive"
                ),
            )
        ),
        "experience_required" => array(
            "meta_field" => true,
            "label" => "Experience Required",
            "meta_label" => "cja_experience_required",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none"
                ),
                array(
                    "label" => " Up to 3 Months",
                    "value" => "3months"
                ),
                array(
                    "label" => "Up to 6 Months",
                    "value" => "6months"
                ),
                array(
                    "label" => "Up to 1 Year",
                    "value" => "1year"
                ),
                array(
                    "label" => "Up to 2 Years",
                    "value" => "2years"
                ),
                array(
                    "label" => "Up to 3 Years",
                    "value" => "3years"
                ),
                array(
                    "label" => "Up to 4+ Years",
                    "value" => "4years"
                )
            )
        ),
        "employer_type" => array(
            "meta_field" => true,
            "label" => "Employer Type",
            "meta_label" => "cja_employer_type",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "University",
                    "value" => "university"
                ),
                array(
                    "label" => "College",
                    "value" => "college"
                ),
                array(
                    "label" => "Private Training Provider",
                    "value" => "private_training_provider"
                ),
                array(
                    "label" => "Private Individual",
                    "value" => "private_individual"
                ),
                array(
                    "label" => "Recruitment Agency",
                    "value" => "recruitment_agency"
                ),
                array(
                    "label" => "Employer (large)",
                    "value" => "employer_large"
                ),
                array(
                    "label" => "Employer (medium)",
                    "value" => "employer_medium"
                ),
                array(
                    "label" => "Employer (small)",
                    "value" => "employer_small"
                ),
                array(
                    "label" => "Sole Trader",
                    "value" => "sole_trader"
                ),
                array(
                    "label" => "Charity",
                    "value" => "charity"
                ),
                array(
                    "label" => "Government Organisation",
                    "value" => "government_organisation"
                ),
                array(
                    "label" => "Other",
                    "value" => "other"
                ),
            )
        ),
        "minimum_qualification" => array(
            "meta_field" => true,
            "label" => "Minimum Qualificiation Required",
            "meta_label" => "cja_minimum_qualification",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "GCSE's",
                    "value" => "gcse"
                ),
                array(
                    "label" => "A Levels",
                    "value" => "alevels"
                ),
                array(
                    "label" => "Award",
                    "value" => "award"
                ),
                array(
                    "label" => "Certificate",
                    "value" => "certificate"
                ),
                array(
                    "label" => "Diploma",
                    "value" => "diploma"
                ),
                array(
                    "label" => "Studying towards a Degree",
                    "value" => "studying_degree"
                ),
                array(
                    "label" => "Degree",
                    "value" => "degree"
                ),
                array(
                    "label" => "Masters Degree",
                    "value" => "masters_degree"
                ),
                array(
                    "label" => "Doctorate Degree",
                    "value" => "doctorate_degree"
                )
            )
        ),
        "dbs_required" => array(
            "meta_field" => true,
            "label" => "DBS Required",
            "meta_label" => "cja_dbs_required",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Yes",
                    "value" => "yes"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                ),
                array(
                    "label" => "Can Be Arranged",
                    "value" => "arranged"
                )
            )
        ),
        "dbs_required" => array(
            "meta_field" => true,
            "label" => "DBS Required",
            "meta_label" => "cja_dbs_required",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Yes",
                    "value" => "yes"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                ),
                array(
                    "label" => "Can Be Arranged",
                    "value" => "arranged"
                )
            )
        ),
        "payment_frequency" => array(
            "meta_field" => true,
            "label" => "Payment Frequency",
            "meta_label" => "cja_payment_frequency",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Hourly",
                    "value" => "hourly"
                ),
                array(
                    "label" => "Daily",
                    "value" => "daily"
                ),
                array(
                    "label" => "Weekly",
                    "value" => "weekly"
                ),
                array(
                    "label" => "Fortnightly",
                    "value" => "fortnightly"
                ),
                array(
                    "label" => "Monthly",
                    "value" => "monthly"
                ),
                array(
                    "label" => "To Be Discussed",
                    "value" => "to_be_discussed"
                )
            )
        ),
        "shift_work" => array(
            "meta_field" => true,
            "label" => "Shift Work",
            "meta_label" => "cja_shift_work",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Yes",
                    "value" => "yes"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                )
            )
        ),
        "shifts" => array(
            "meta_field" => true,
            "is_array" => true,
            "label" => "Shifts (if applicable)",
            "meta_label" => "cja_shifts",
            "type" => "checkboxes",
            "options" => array(
                array(
                    "label" => "Morning",
                    "value" => "morning"
                ),
                array(
                    "label" => "Afternoon",
                    "value" => "afternoon"
                ),
                array(
                    "label" => "Evening",
                    "value" => "evening"
                ),
                array(
                    "label" => "Night",
                    "value" => "night"
                )
            )
        ),
        "location_options" => array(
            "meta_field" => true,
            "label" => "Location Options",
            "meta_label" => "cja_location_options",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "On Premises",
                    "value" => "on_premises"
                ),
                array(
                    "label" => "Remotely",
                    "value" => "remotely"
                ),
                array(
                    "label" => "On Premises and Remotely",
                    "value" => "both"
                )
            )
        ),
        "deadline" => array(
            "meta_field" => true,
            "label" => "Deadline",
            "meta_label" => "cja_deadline",
            "type" => "date"
        ),
        "more_information" => array(
            "meta_field" => true,
            "label" => "More Information",
            "meta_label" => "more_information",
            "type" => "textarea"
        )

    );

    /**
     * PUBLIC FUNCTIONS
     */

    // Display form field
    public function display_form_field($field, $do_label = true, $search_field = false) {
        include('display_form_field.php');
    }

    // Display field
    public function display_field($field) {
        include('display_field.php');
    }

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

        // meta fields
        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['type'] == 'checkbox') {
                $this->$field = false; // blank checkbox value first
            }
            if (isset($_POST[$field])) {
                $this->$field = $_POST[$field];
                if ($field == 'salary_numeric') {
                    $sal_num = (float) filter_var( $_POST['salary_numeric'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                    $this->salary_numeric = $sal_num;
                }
            }
        }


        if (array_key_exists('salary_numeric',$_POST)) {
            $sal_num = (float) filter_var( $_POST['salary_numeric'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            $this->salary_numeric = $sal_num;
        }
/*
        if (array_key_exists('salary_per',$_POST)) {
            $this->salary_per = $_POST['salary_per'];
        }
*/
        if (array_key_exists('max_distance',$_POST)) {
            $this->max_distance = $_POST['max_distance'];
        }
        if (array_key_exists('ad-content',$_POST)) {
            $this->content = $_POST['ad-content'];
        }
/*
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
        if (array_key_exists('postcode',$_POST)) {
            $this->postcode = $_POST['postcode'];
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
*/
        if (array_key_exists('order_by',$_POST)) {
            $this->order_by = $_POST['order_by'];
        }
        /*
        if (array_key_exists('can_apply_online', $_POST)) {
            $this->can_apply_online = $_POST['can_apply_online'];
        } else {
            $this->can_apply_online = NULL;
        }
        */
        if (array_key_exists('show_applied', $_POST)) {
            $this->show_applied = 'true';
        } else {
            $this->show_applied = NULL;
        }

        /*
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
        */

        // photo

        if ($_POST['delete_photo']) {
            $this->photo_filename = '';
            $this->photo_url = '';
        }

        if ( $_FILES['photo']['size'] != 0 ) {
            
            $info = getimagesize($_FILES['photo']['tmp_name']);
            if ($info === FALSE) {
                return 'filetype_error';
            }
            
            if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
                return 'filetype_error';
            }
    
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['photo'];
    
            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->photo_filename = $uploadedfile['name'];
            $this->photo_url = $movefile['url'];
        }


        //files
        if ( $_POST['delete_files'] ) {
            foreach ($_POST['delete_files'] as $delete_file) {
                foreach ($this->files_array as $key => $value) {
                    if ($delete_file == $value['url']) {
                        unset($this->files_array[$key]);
                    }
                }
            }
        }
        
        if ( $_FILES['files']['size'][0] != 0 ) {
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $files = $_FILES['files'];
            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                    );
                    $upload_overrides = array(
                        'test_form' => false
                    );
                    $movefile = wp_handle_upload($file, $upload_overrides);
                    $new_file_data = array(
                        'name' => $files['name'][$key],
                        'url' => $movefile['url']
                    );
                    $this->files_array[] = $new_file_data;
                }
            }
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
        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['is_array']) {
                update_post_meta($this->id, $this->form_fields[$field]['meta_label'], serialize($this->$field));
            } else {
                update_post_meta($this->id, $this->form_fields[$field]['meta_label'], $this->$field);
            }
        }
        update_post_meta($this->id, 'cja_salary_numeric', $this->salary_numeric);

        update_post_meta($this->id, 'files_array', serialize($this->files_array));

        update_post_meta($this->id, 'photo_filename', $this->photo_filename);
        update_post_meta($this->id, 'photo_url', $this->photo_url);
        
        /*
        update_post_meta($this->id, 'cja_salary_per', $this->salary_per);
        update_post_meta($this->id, 'cja_hourly_equivalent_rate', $this->get_hourly_equivalent_rate());
        update_post_meta($this->id, 'cja_job_type', $this->job_type);
        update_post_meta($this->id, 'cja_sector', $this->sector);
        update_post_meta($this->id, 'cja_contact_person', $this->contact_person);
        update_post_meta($this->id, 'cja_contact_phone_number', $this->contact_phone_number);
        update_post_meta($this->id, 'cja_postcode', $this->postcode);
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
        update_post_meta($this->id, 'cja_can_apply_online', $this->can_apply_online);
        */

        update_post_meta($this->id, 'cja_job_spec_filename', $this->job_spec_filename);
        update_post_meta($this->id, 'cja_job_spec_url', $this->job_spec_url);
    }

    // Activate the advert
    public function activate() {
        $this->status = 'active';
        $this->activation_date = strtotime(date('j F Y'));
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y')))));
        $this->send_approval_email();
    }

    private function send_approval_email() {
        $advertiser = new CJA_User($this->author);
        $to = $advertiser->email;
        $subject = 'Your advert has been approved';
        $message = 'Your advert for ' . $this->title . ' has been approved and is now live.';
        wp_mail($to, $subject, $message);
    }

    // Extend the advert
    public function extend() {
        $this->expiry_date = strtotime(date("j F Y", strtotime("+1 month", $this->expiry_date)));
    }

    // Delete ad (not delete post but set status to deleted)
    public function delete() {
        $this->status = 'deleted';
    }

    // Update search object from cookies
    public function update_from_cookies() {
        $this->salary_numeric = $_COOKIE[ get_current_user_id() . '_salary_numeric'];
        $this->salary_per = $_COOKIE[ get_current_user_id() . '_salary_per'];
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_max_distance'];
        $this->job_type = $_COOKIE[ get_current_user_id() . '_job_type'];
        $this->sector = $_COOKIE[ get_current_user_id() . '_sector'];
        $this->career_level = $_COOKIE[ get_current_user_id() . '_career_level'];
        $this->experience_required = $_COOKIE[ get_current_user_id() . '_experience_required'];
        $this->employer_type = $_COOKIE[ get_current_user_id() . '_employer_type'];
        $this->minimum_qualification = $_COOKIE[ get_current_user_id() . '_minimum_qualification'];
        $this->dbs_required = $_COOKIE[ get_current_user_id() . '_dbs_required'];
        $this->payment_frequency = $_COOKIE[ get_current_user_id() . '_payment_frequency'];
        $this->shift_work = $_COOKIE[ get_current_user_id() . '_shift_work'];
        $this->location_options = $_COOKIE[ get_current_user_id() . '_location_options'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_order_by'];
        if (!$this->order_by) { $this->order_by = 'date'; }
        $this->show_applied = $_COOKIE[ get_current_user_id() . '_show_applied'];
    }

    // Build WP Query from search values
    public function build_wp_query() {

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $wp_query_args = array(
            'post_type' => 'job_ad',
            'orderby' => 'order_clause',
            'order' => 'DSC',
            //'paged' => $paged
            'posts_per_page' => -1
        );

        $meta_query = array();
        $meta_query['order-clause'] = array(
            'key' => 'cja_ad_activation_date',
            'type' => 'NUMERIC'
        );

        $meta_item = array(
            'key' => 'cja_ad_status',
            'value' => 'active'
        );
        $meta_query[] = $meta_item;

        if ($this->salary_numeric) {
            $meta_item = array();
            $meta_item['key'] = 'cja_hourly_equivalent_rate';
            $meta_item['value'] = $this->get_hourly_equivalent_rate();
            //$meta_item['value'] = (float) filter_var( $this->salary_numeric, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
            //$meta_item['value'] = 5;
            $meta_item['type'] = 'numeric';
            $meta_item['compare'] = '>=';
            $meta_query[] = $meta_item;
        }

        if ($this->minimum_qualification) {
            $meta_item = array();
            $meta_item['relation'] = 'OR';

            if ($this->minimum_qualification == 'gcse' ||
            $this->minimum_qualification == 'alevels' ||
            $this->minimum_qualification == 'award' ||
            $this->minimum_qualification == 'certificate' ||
            $this->minimum_qualification == 'diploma' ||
            $this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'gcse';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'alevels' ||
            $this->minimum_qualification == 'award' ||
            $this->minimum_qualification == 'certificate' ||
            $this->minimum_qualification == 'diploma' ||
            $this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'alevels';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'award' ||
            $this->minimum_qualification == 'certificate' ||
            $this->minimum_qualification == 'diploma' ||
            $this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'award';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'certificate' ||
            $this->minimum_qualification == 'diploma' ||
            $this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'certificate';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'diploma' ||
            $this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'diploma';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'studying_degree' ||
            $this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'studying_degree';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'degree' ||
            $this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'degree';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'masters_degree' ||
            $this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'masters_degree';
                $meta_item[] = $sub_meta;
            }

            if ($this->minimum_qualification == 'doctorate_degree') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_minimum_qualification';
                $sub_meta['value'] = 'doctorate_degree';
                $meta_item[] = $sub_meta;
            }

            $meta_query[] = $meta_item;
        }

        if ($this->experience_required) {
            $meta_item = array();
            $meta_item['relation'] = 'OR';

            if ($this->experience_required == 'none' ||
            $this->experience_required == '3months' ||
            $this->experience_required == '6months' ||
            $this->experience_required == '1year' ||
            $this->experience_required == '2years' ||
            $this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = 'none';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '3months' ||
            $this->experience_required == '6months' ||
            $this->experience_required == '1year' ||
            $this->experience_required == '2years' ||
            $this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '3months';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '6months' ||
            $this->experience_required == '1year' ||
            $this->experience_required == '2years' ||
            $this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '6months';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '1year' ||
            $this->experience_required == '2years' ||
            $this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '1year';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '2years' ||
            $this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '2years';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '3years' ||
            $this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '3years';
                $meta_item[] = $sub_meta;
            }

            if ($this->experience_required == '4years') {
                $sub_meta = array();
                $sub_meta['key'] = 'cja_experience_required';
                $sub_meta['value'] = '4years';
                $meta_item[] = $sub_meta;
            }

            $meta_query[] = $meta_item;
        }

        $fields = array( 'job_type', 'sector', 'career_level', 'employer_type', 'dbs_required', 'payment_frequency', 'shift_work', 'location_options');

        foreach($fields as $field) {
            if ($this->$field) {
                $meta_item = array();
                $meta_item['key'] = 'cja_' . $field;
                $meta_item['value'] = $this->$field;
                $meta_query[] = $meta_item;
            }
        }

        $wp_query_args['meta_query'] = $meta_query;

        return $wp_query_args;
    }

    // Return human values
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

    public function get_hourly_equivalent_rate() {
        
        if (!$this->salary_numeric || !$this->salary_per) {
            return 0;
        }

        if ($this->salary_per == 'hour') {
            return round($this->salary_numeric, 2);
        } else if ($this->salary_per == 'day') {
            return round($this->salary_numeric / 8, 2);
        } else if ($this->salary_per == 'year') {
            return round($this->salary_numeric / 1958, 2);
        }
    }
}

?>