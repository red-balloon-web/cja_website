<?php

class CJA_User {

    /**
     * PROPERTIES
     */
    public $id;
    public $is_logged_in;
    public $login_name;
    public $email;
    public $role;
    public $first_name;
    public $last_name;
    public $full_name;
    public $company_name;
    public $company_description;
    public $address;
    public $contact_person;
    public $cv_filename;
    public $cv_url;
    public $credits;
    public $classified_credits;
    public $phone;
    public $postcode;
    public $age_category;
    public $gcse_maths;
    public $weekends_availability;
    public $company_details_complete;
    public $is_jobseeker;
    public $is_student;

    public $files_array = array();
    public $photo_filename;
    public $photo_url;

    /* FORM FIELDS */

    public $form_fields = array(
        "email" => array(
            "meta_field" => false,
            "label" => "Email Address"
        ),
        "first_name" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "First Name",
            "meta_label" => 'first_name'
        ),
        "last_name" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Last Name",
            "meta_label" => "last_name"
        ),
        "company_name" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Company Name",
            "meta_label" => "company_name"
        ),
        "company_description" => array(
            "meta_field" => true,
            "type" => "textarea",
            "label" => "Company Description",
            "meta_label" => "company_description"
        ),
        "address" => array(
            "meta_field" => true,
            "type" => "textarea",
            "label" => "Address",
            "meta_label" => "cja_address"
        ),
        "town_city" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Town / City",
            "meta_label" => "town_city"
        ),
        "opportunity_required" => array(
            "meta_field" => true,
            "is_array" => true,
            "label" => "Opportunity Required",
            "meta_label" => "opportunity_required",
            "type" => "checkboxes",
            "options" => array(
                array(
                    "label" => "Apprenticeship",
                    "value" => "apprenticeship"
                ),
                array(
                    "label" => "Traineeship",
                    "value" => "traineeship"
                ),
                array(
                    "label" => "Internship for University",
                    "value" => "internship"
                ),
                array(
                    "label" => "Work Experience",
                    "value" => "work_experience"
                ),
                array(
                    "label" => "Paid Employment",
                    "value" => "paid_employment"
                ),
                array(
                    "label" => "Course for Employment",
                    "value" => "course_employment"
                ),
                array(
                    "label" => "Course for University",
                    "value" => "course_university"
                ),
                array(
                    "label" => "A Placement for my Course",
                    "value" => "placement_course"
                )
            )
        ),
        "contact_person" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Contact Person",
            "meta_label" => "cja_contact_person"
        ),
        "cv_filename" => array(
            "meta_field" => true,
            "meta_label" => "cv_filename"
        ),
        "cv_url" => array(
            "meta_field" => true,
            "meta_label" => "cv_url"
        ),
        "credits" => array(
            "meta_field" => true,
            "meta_label" => "cja_credits"
        ),
        "classified_credits" => array(
            "meta_field" => true,
            "meta_label" => "cja_classified_credits"
        ),
        "phone" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Phone",
            "meta_label" => "phone"
        ),
        "postcode" => array(
            "meta_field" => true,
            "type" => "text",
            "label" => "Postcode",
            "meta_label" => "postcode"
        ),
        "age_category" => array(
            "meta_field" => true,
            "type" => "select",
            "options" => array(
                array(
                    "label" => "16-18",
                    "value" => "16-18"
                ),
                array(
                    "label" => "19-24",
                    "value" => "19+"
                ),
                array(
                    "label" => "24+",
                    "value" => "24+"
                )
            ),
            "label" => "Age Category",
            "meta_label" => "age_category"
        ),
        "gcse_maths" => array(
            "meta_field" => true,
            "type" => "select",
            "options" => array(
                array(
                    "label" => "A-B Grade",
                    "value" => "ab",
                    "rank" => 4
                ),
                array(
                    "label" => "C Grade",
                    "value" => "c",
                    "rank" => 3
                ),
                array(
                    "label" => "D Grade",
                    "value" => "d",
                    "rank" => 2
                ),
                array(
                    "label" => "Below D Grade",
                    "value" => "belowd",
                    "rank" => 1
                ),
                array(
                    "label" => "Grade 6-7",
                    "value" => "6-7",
                    "rank" => 4
                ),
                array(
                    "label" => "Grade 4-5",
                    "value" => "4-5",
                    "rank" => 3
                ),
                array(
                    "label" => "Grade 3",
                    "value" => "3",
                    "rank" => 2
                ),
                array(
                    "label" => "Below Grade 3",
                    "value" => "below3",
                    "rank" => 1
                )
            ),
            "label" => "GCSE Maths Grade",
            "meta_label" => "gcse_maths"
        ),
        "gcse_english" => array(
            "meta_field" => true,
            "type" => "select",
            "options" => array(
                array(
                    "label" => "A-B Grade",
                    "value" => "ab",
                    "rank" => 4
                ),
                array(
                    "label" => "C Grade",
                    "value" => "c",
                    "rank" => 3
                ),
                array(
                    "label" => "D Grade",
                    "value" => "d",
                    "rank" => 2
                ),
                array(
                    "label" => "Below D Grade",
                    "value" => "belowd",
                    "rank" => 1
                ),
                array(
                    "label" => "Grade 6-7",
                    "value" => "6-7",
                    "rank" => 4
                ),
                array(
                    "label" => "Grade 4-5",
                    "value" => "4-5",
                    "rank" => 3
                ),
                array(
                    "label" => "Grade 3",
                    "value" => "3",
                    "rank" => 2
                ),
                array(
                    "label" => "Below Grade 3",
                    "value" => "below3",
                    "rank" => 1
                )
            ),
            "label" => "GCSE English Grade",
            "meta_label" => "gcse_english"
        ),
        "functional_maths" => array(
            "meta_field" => true,
            "label" => "Functional Skills Maths Grade",
            "meta_label" => "functional_maths",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none",
                    "rank" => 0
                ),
                array(
                    "label" => "Entry 2",
                    "value" => "entry2",
                    "rank" => 1
                ),
                array(
                    "label" => "Entry 3",
                    "value" => "entry3",
                    "rank" => 2
                ),
                array(
                    "label" => "Level 1",
                    "value" => "level1",
                    "rank" => 3
                ),
                array(
                    "label" => "Level 2",
                    "value" => "level2",
                    "rank" => 4
                )
            )
        ),
        "functional_english" => array(
            "meta_field" => true,
            "label" => "Functional Skills English Grade",
            "meta_label" => "functional_english",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none",
                    "rank" => 0
                ),
                array(
                    "label" => "Entry 2",
                    "value" => "entry2",
                    "rank" => 1
                ),
                array(
                    "label" => "Entry 3",
                    "value" => "entry3",
                    "rank" => 2
                ),
                array(
                    "label" => "Level 1",
                    "value" => "level1",
                    "rank" => 3
                ),
                array(
                    "label" => "Level 2",
                    "value" => "level2",
                    "rank" => 4
                )
            )
        ),
        "weekends_availability" => array(
            "meta_field" => true,
            "type" => "select",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none"
                ),
                array(
                    "label" => "Saturday Only",
                    "value" => "sat"
                ),
                array(
                    "label" => "Sunday Only",
                    "value" => "sun"
                ),
                array(
                    "label" => "Saturday and Sunday",
                    "value" => "satsun"
                )
            ),
            "label" => "Weekends Availability",
            "meta_label" => "weekends_availability"
        ),
        "is_jobseeker" => array(
            "meta_field" => true,
            "type" => "checkbox",
            "value" => "true",
            "meta_label" => "is_jobseeker",
            "label" => "I am looking for employment, include my profile in CV searches"
        ),
        "is_student" => array(
            "meta_field" => true,
            "type" => "checkbox",
            "value" => "true",
            "meta_label" => "is_student",
            "label" => "I am looking for courses, include my profile in student searches"
        ),
        "specialism_area" => array(
            "meta_field" => true,
            "is_array" => true,
            "type" => "checkboxes",
            "meta_label" => "specialism_area",
            "label" => "Specialism Area(s)",
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
        "course_time" => array(
            "meta_field" => true,
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
                    "label" => "Any",
                    "value" => "any"
                )
            ),
            "label" => "Courses FT/PT (if applicable)",
            "meta_label" => "course_time"
        ),
        "job_role" => array(
            "meta_field" => true,
            "label" => "Job Role(s)",
            "type" => "text",
            "meta_label" => "job_role"
        ),
        "job_time" => array(
            "meta_field" => true,
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
                    "label" => "Any",
                    "value" => "any"
                )
            ),
            "label" => "Jobs FT/PT (if applicable)",
            "meta_label" => "job_time"
        ),
        "cover_work" => array(
            "meta_field" => true,
            "label" => "Would you be interested to do cover work",
            "meta_label" => "cover_work",
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
        "receiving_benefits" => array(
            "meta_field" => true,
            "label" => "Are you receiving benefits",
            "meta_label" => "receiving_benefits",
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
        "current_status" => array(
            "meta_field" => true,
            "label" => "Current Employment or Education Status",
            "meta_label" => "current_status",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Unemployed looking for work",
                    "value" => "unemployed_work"
                ),
                array(
                    "label" => "Unemployed looking for a course",
                    "value" => "unemployed_course"
                ),
                array(
                    "label" => "Unemployed and not in education",
                    "value" => "unemployed_not_education"
                ),
                array(
                    "label" => "Unemployed seeking work experience ",
                    "value" => "unemployed_work_experience"
                ),
                array(
                    "label" => "Employed but looking for career change",
                    "value" => "employed_career_change"
                ),
                array(
                    "label" => "Not in education or training ",
                    "value" => "not_education_training"
                ),
                array(
                    "label" => "In education looking for work experience",
                    "value" => "education_work_experience"
                ),
            )
        ),
        "contact_preference" => array(
            "meta_field" => true,
            "label" => "Contact Preference",
            "meta_label" => "contact_preference",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Phone",
                    "value" => "phone"
                ),
                array(
                    "label" => "Email",
                    "value" => "email"
                )
            )
        ),
        "highest_qualification" => array(
            "meta_field" => true,
            "label" => "Highest Current Qualification",
            "meta_label" => "highest_qualification",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "None",
                    "value" => "none",
                    "rank" => 0
                ),
                array(
                    "label" => "GCSE's",
                    "value" => "gcse",
                    "rank" => 1
                ),
                array(
                    "label" => "A Levels",
                    "value" => "alevels",
                    "rank" => 2
                ),
                array(
                    "label" => "Award",
                    "value" => "award",
                    "rank" => 3
                ),
                array(
                    "label" => "Certificate",
                    "value" => "certificate",
                    "rank" => 4
                ),
                array(
                    "label" => "Diploma",
                    "value" => "diploma",
                    "rank" => 5
                ),
                array(
                    "label" => "Studying Towards a Degree",
                    "value" => "study_degree",
                    "rank" => 6
                ),
                array(
                    "label" => "Masters Degree",
                    "value" => "masters",
                    "rank" => 7
                ),
                array(
                    "label" => "Doctorate Degree",
                    "value" => "doctorate",
                    "rank" => 8
                ),
            )
        ),
        "unemployed" => array(
            "meta_field" => true,
            "label" => "Are You Unemployed?",
            "meta_label" => "unemployed",
            "type" => "select",
            "options" => array(
                array(
                    "label" => "Yes, registered with Job Centre",
                    "value" => "yes-jc"
                ),
                array(
                    "label" => "Yes, not registered with Job Centre",
                    "value" => "yes-nojc"
                ),
                array(
                    "label" => "No",
                    "value" => "no"
                ),
            )
        )
    );
    
    /**
     * CONSTRUCTOR FUNCTION
     * FROM ID OR CURRENT USER IF NO ID SUPPLIED
     */
    function __construct($id = 0) {

        if($id) {
            $this->id = $id;
            if ($this->id == get_current_user_id()) {
                $this->is_logged_in = 1;
            } else {
                $this->is_logged_in = 0;
            }
        } else {
            $this->id = get_current_user_id();
            $this->is_logged_in = is_user_logged_in();
        }

        $this->login_name = get_userdata($this->id)->data->user_login; 
        $this->email = get_userdata($this->id)->data->user_email;
        $this->role = get_userdata($this->id)->roles[0];

        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['meta_field']) {
                if ($this->form_fields[$field]['is_array']) {
                    $this->$field = unserialize(get_user_meta($this->id, $this->form_fields[$field]['meta_label'], true));
                    if (!is_array($this->$field)) {
                        $this->$field = array();
                    }
                } else {
                    $this->$field = get_user_meta($this->id, $this->form_fields[$field]['meta_label'], true);
                }
            }
        }

        $this->company_details_complete = $this->company_details_complete();
        $this->full_name = $this->first_name . ' ' . $this->last_name;

        $this->files_array = unserialize(get_user_meta($this->id, 'files_array', true));

        $this->photo_filename = get_user_meta($this->id, 'photo_filename', true);
        $this->photo_url = get_user_meta($this->id, 'photo_url', true);
    }

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

    // Update object from $_POST data
    public function updateFromForm() {
        
        // Go through form fields
        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['type'] == 'checkbox' || $this->form_fields[$field]['type'] == 'checkboxes') {
                $this->$field = false; // blank checkbox value first
            }
            if (isset($_POST[$field])) {
                $this->$field = $_POST[$field];
            }
        }
        /*
        if ($_POST['delete_cv']) {
            $this->cv_filename = null;
            $this->cv_url = null;
        }

        if ( $_FILES['cv-file']['size'] != 0 ) {
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['cv-file'];

            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->cv_filename = $uploadedfile['name'];
            $this->cv_url = $movefile['url'];
        }
        */

        // Search

        if ($_POST['max_distance']) {
            $this->max_distance = $_POST['max_distance'];
        }
        if ($_POST['order_by']) {
            $this->order_by = $_POST['order_by'];
        }

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

        // files
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
        $userdata = array(
            'ID' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        );
        wp_update_user($userdata);

        foreach($this->form_fields as $field => $value) {
            if ($this->form_fields[$field]['is_array']) {
                update_user_meta($this->id, $this->form_fields[$field]['meta_label'], serialize($this->$field));
            } else {
                update_user_meta($this->id, $this->form_fields[$field]['meta_label'], $this->$field);
            }
        }

        update_user_meta($this->id, 'files_array', serialize($this->files_array));
        update_user_meta($this->id, 'photo_filename', $this->photo_filename);
        update_user_meta($this->id, 'photo_url', $this->photo_url);
        
        /*
        update_user_meta($this->id, 'company_name', $this->company_name);
        update_user_meta($this->id, 'company_description', $this->company_description);
        update_user_meta($this->id, 'phone', $this->phone);
        update_user_meta($this->id, 'postcode', $this->postcode);
        update_user_meta($this->id, 'cja_address', $this->address);
        update_user_meta($this->id, 'cja_contact_person', $this->contact_person);
        
        // Jobseekers
        update_user_meta($this->id, 'cv_filename', $this->cv_filename);
        update_user_meta($this->id, 'cv_url', $this->cv_url);
        update_user_meta($this->id, 'age_category', $this->age_category);
        update_user_meta($this->id, 'gcse_maths', $this->gcse_maths);
        update_user_meta($this->id, 'weekends_availability', $this->weekends_availability);
        update_user_meta($this->id, 'is_jobseeker', $this->is_jobseeker);
        update_user_meta($this->id, 'is_student', $this->is_student);
        */
    }

    // Update search object from cookies
    public function update_from_cv_cookies() {
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_cv_max_distance'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_cv_order_by'];
        $this->opportunity_required = unserialize(base64_decode($_COOKIE[ get_current_user_id() . '_cv_opportunity_required']));
        $this->course_time = $_COOKIE[ get_current_user_id() . '_cv_course_time'];
        $this->job_time = $_COOKIE[ get_current_user_id() . '_cv_job_time'];
        $this->weekends_availability = $_COOKIE[ get_current_user_id() . '_cv_weekends_availability'];
        $this->cover_work = $_COOKIE[ get_current_user_id() . '_cv_cover_work'];

        $this->specialism_area = unserialize(base64_decode($_COOKIE[ get_current_user_id() . '_cv_specialism_area']));

        $this->gcse_maths = $_COOKIE[ get_current_user_id() . '_cv_gcse_maths'];
        $this->gcse_english = $_COOKIE[ get_current_user_id() . '_cv_gcse_english'];
        $this->functional_maths = $_COOKIE[ get_current_user_id() . '_cv_functional_maths'];
        $this->functional_english = $_COOKIE[ get_current_user_id() . '_cv_functional_english'];
        $this->highest_qualification = $_COOKIE[ get_current_user_id() . '_cv_highest_qualification'];
        
        $this->age_category = $_COOKIE[ get_current_user_id() . '_cv_age_category'];
        $this->current_status = $_COOKIE[ get_current_user_id() . '_cv_current_status'];
        $this->unemployed = $_COOKIE[ get_current_user_id() . '_cv_unemployed'];
        $this->receiving_benefits = $_COOKIE[ get_current_user_id() . '_cv_receiving_benefits'];
    }

    public function update_from_student_cookies() {
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_student_max_distance'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_student_order_by'];
        $this->opportunity_required = unserialize(base64_decode($_COOKIE[ get_current_user_id() . '_student_opportunity_required']));
        $this->course_time = $_COOKIE[ get_current_user_id() . '_student_course_time'];
        $this->job_time = $_COOKIE[ get_current_user_id() . '_student_job_time'];
        $this->weekends_availability = $_COOKIE[ get_current_user_id() . '_student_weekends_availability'];
        $this->cover_work = $_COOKIE[ get_current_user_id() . '_student_cover_work'];

        $this->specialism_area = unserialize(base64_decode($_COOKIE[ get_current_user_id() . '_student_specialism_area']));

        $this->gcse_maths = $_COOKIE[ get_current_user_id() . '_student_gcse_maths'];
        $this->gcse_english = $_COOKIE[ get_current_user_id() . '_student_gcse_english'];
        $this->functional_maths = $_COOKIE[ get_current_user_id() . '_student_functional_maths'];
        $this->functional_english = $_COOKIE[ get_current_user_id() . '_student_functional_english'];
        $this->highest_qualification = $_COOKIE[ get_current_user_id() . '_student_highest_qualification'];
        
        $this->age_category = $_COOKIE[ get_current_user_id() . '_student_age_category'];
        $this->current_status = $_COOKIE[ get_current_user_id() . '_student_current_status'];
        $this->unemployed = $_COOKIE[ get_current_user_id() . '_student_unemployed'];
        $this->receiving_benefits = $_COOKIE[ get_current_user_id() . '_student_receiving_benefits'];
    }

    // Build WP User Query
    public function build_wp_query() {
        $return_wp_query = array(
            'role' => 'jobseeker'
        );
        $meta_query = array();

        if ($this->opportunity_required) {
            $meta_query = $this->add_query_item($meta_query, 'opportunity_required', 'in_array');
        }
        if ($this->course_time) {
            $meta_query = $this->add_query_item($meta_query, 'course_time', 'select');
        }
        if ($this->job_time) {
            $meta_query = $this->add_query_item($meta_query, 'job_time', 'select');
        }
        if ($this->weekends_availability) {
            $meta_query = $this->add_query_item($meta_query, 'weekends_availability', 'select');
        }
        if ($this->cover_work) {
            $meta_query = $this->add_query_item($meta_query, 'cover_work', 'select');
        }
        if ($this->specialism_area) {
            $meta_query = $this->add_query_item($meta_query, 'specialism_area', 'in_array');
        }

        // education
        if ($this->gcse_maths) {
            $meta_query = $this->add_query_item($meta_query, 'gcse_maths', 'rank');
        }
        if ($this->gcse_english) {
            $meta_query = $this->add_query_item($meta_query, 'gcse_english', 'rank');
        }
        if ($this->functional_maths) {
            $meta_query = $this->add_query_item($meta_query, 'functional_maths', 'rank');
        }
        if ($this->functional_english) {
            $meta_query = $this->add_query_item($meta_query, 'functional_english', 'rank');
        }
        if ($this->highest_qualification) {
            $meta_query = $this->add_query_item($meta_query, 'highest_qualification', 'rank');
        }

        // other
        if ($this->age_category) {
            $meta_query = $this->add_query_item($meta_query, 'age_category', 'select');
        }
        if ($this->current_status) {
            $meta_query = $this->add_query_item($meta_query, 'current_status', 'select');
        }
        if ($this->unemployed) {
            $meta_query = $this->add_query_item($meta_query, 'unemployed', 'select');
        }
        if ($this->receiving_benefits) {
            $meta_query = $this->add_query_item($meta_query, 'receiving_benefits', 'select');
        }

        // in search
        if ($this->is_jobseeker) {
            $meta_query_item = array(
                'key' => 'is_jobseeker',
                'value' => 'true'
            );
            $meta_query[] = $meta_query_item;
        }

        if ($this->is_student) {
            $meta_query_item = array(
                'key' => 'is_student',
                'value' => 'true'
            );
            $meta_query[] = $meta_query_item;
        }
    
        $return_wp_query['meta_query'] = $meta_query;
        return $return_wp_query;
    }

    private function add_query_item($meta_query, $field, $type) {

        if ($type == 'select') {
            $meta_query_item = array(
                'key' => $field,
                'value' => $this->$field
            );
        }

        if ($type == 'in_array') {
            $meta_query_item = array(
                'relation' => 'OR'
            );

            foreach ($this->$field as $option) {
                $meta_query_sub_item = array(
                    'key' => $field,
                    'value' => $option,
                    'compare' => 'LIKE'
                );
                $meta_query_item[] = $meta_query_sub_item;
            }
        }

        if ($type == 'rank') {
            $rank;
            // get rank of selected value
            foreach ($this->form_fields[$field]['options'] as $option) {
                if ($option['value'] == $this->$field) {
                    $rank = $option['rank'];
                }
            }
            // set up meta query item
            $meta_query_item = array(
                'relation' => 'OR'
            );
            foreach ($this->form_fields[$field]['options'] as $option) {
                if ($option['rank'] >= $rank) {
                    $meta_query_sub_item = array(
                        'key' => $field,
                        'value' => $option['value']
                    );
                    $meta_query_item[] = $meta_query_sub_item;
                }
            }
        }

        $meta_query[] = $meta_query_item;
        return $meta_query;
    }



    // Return human-friendly values
    public function return_human($field) {
        if ($field == 'gcse_maths') {
            if ($this->gcse_maths == 'n') {
                return 'N/A';
            } else {
                return strtoupper($this->gcse_maths);
            }
        }

        if ($field == 'weekends_availability') {
            switch($this->weekends_availability) {
                case 'none':
                    return 'None';
                    break;
                case 'sat':
                    return 'Saturdays Only';
                    break;
                case 'sun':
                    return 'Sundays Only';
                    break;
                case 'satsun':
                    return 'Saturdays and Sundays';
                    break;
            }
        }

        if ($field == 'opportunity_required') {
            echo "<ul>";

            foreach($this->form_fields['opportunity_required']['options'] as $option) {
                if (in_array($option['value'], $this->opportunity_required)) {
                    echo '<li><strong>' . $option['label'] . '</strong></li>';
                }
            }

            echo "</ul>";
        }
    }

    // Return display name
    public function display_name() {
        if ($this->company_name) {
            return $this->company_name;
        } else if ($this->first_name) {
            return $this->full_name;
        } else {
            return $this->login_name;
        }
    }

    // set variable for whether company details have been completed
    private function company_details_complete() {
        if ($this->company_name && $this->company_description && $this->postcode && $this->address) {
            return true;
        } else {
            return false;
        }
    }
}