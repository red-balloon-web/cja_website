<?php

class CJA_User {

    /**
     * PROPERTIES
     */
    public $id;
    public $is_logged_in;
    public $login_name;
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
        $this->role = get_userdata($this->id)->roles[0];
        $this->first_name = get_user_meta($this->id, 'first_name', true);
        $this->last_name = get_user_meta($this->id, 'last_name', true);
        $this->full_name = $this->first_name . ' ' . $this->last_name;
        $this->company_name = get_user_meta($this->id, 'company_name', true);
        $this->company_description = get_user_meta($this->id, 'company_description', true);
        $this->address = get_user_meta($this->id, 'cja_address', true);
        $this->contact_person = get_user_meta($this->id, 'cja_contact_person', true);
        $this->cv_filename = get_user_meta($this->id, 'cv_filename', true);
        $this->cv_url = get_user_meta($this->id, 'cv_url', true);
        $this->credits = get_user_meta($this->id, 'cja_credits', true);
        $this->classified_credits = get_user_meta($this->id, 'cja_classified_credits', true);
        $this->phone = get_user_meta($this->id, 'phone', true);
        $this->postcode = get_user_meta($this->id, 'postcode', true);
        $this->age_category = get_user_meta($this->id, 'age_category', true);
        $this->gcse_maths = get_user_meta($this->id, 'gcse_maths', true);
        $this->weekends_availability = get_user_meta($this->id, 'weekends_availability', true);
        $this->company_details_complete = $this->company_details_complete();
        $this->is_jobseeker = get_user_meta($this->id, 'is_jobseeker', true);
        $this->is_student = get_user_meta($this->id, 'is_student', true);
        
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Update object from $_POST data
    public function updateFromForm() {
        if ($_POST['company_name']) {
            $this->company_name = $_POST['company_name'];
        }
        if ($_POST['first_name']) {
            $this->first_name = $_POST['first_name'];
        }
        if ($_POST['last_name']) {
            $this->last_name = $_POST['last_name'];
        }
        if ($_POST['company_description']) {
            $this->company_description = $_POST['company_description'];
        }
        if ($_POST['phone']) {
            $this->phone = $_POST['phone'];
        }
        if ($_POST['postcode']) {
            $this->postcode = $_POST['postcode'];
        }
        if ($_POST['address']) {
            $this->address = $_POST['address'];
        }
        if ($_POST['contact_person']) {
            $this->contact_person = $_POST['contact_person'];
        }
        // Jobseekers

        if ($_POST['age_category']) {
            $this->age_category = $_POST['age_category'];
        }
        if ($_POST['gcse_maths']) {
            $this->gcse_maths = $_POST['gcse_maths'];
        }
        if ($_POST['weekends_availability']) {
            $this->weekends_availability = $_POST['weekends_availability'];
        }
        if ($_POST['is_jobseeker']) {
            $this->is_jobseeker = $_POST['is_jobseeker'];
        } else {
            $this->is_jobseeker = false;
        }
        if ($_POST['is_student']) {
            $this->is_student = $_POST['is_student'];
        } else {
            $this->is_student = false;
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

        // Search

        if ($_POST['max_distance']) {
            $this->max_distance = $_POST['max_distance'];
        }
        if ($_POST['order_by']) {
            $this->order_by = $_POST['order_by'];
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
    }

    // Update search object from cookies
    public function update_from_cookies() {
        $this->max_distance = $_COOKIE[ get_current_user_id() . '_cv_max_distance'];
        $this->order_by = $_COOKIE[ get_current_user_id() . '_cv_order_by'];
        $this->age_category = $_COOKIE[ get_current_user_id() . '_cv_age_category'];
        $this->gcse_maths = $_COOKIE[ get_current_user_id() . '_cv_gcse_maths'];
        $this->weekends_availability = $_COOKIE[ get_current_user_id() . '_cv_weekends_availability'];
    }

    // Build WP User Query
    public function build_wp_query() {
        $return_wp_query = array(
            'role' => 'jobseeker'
        );
        $meta_query = array();

        if ($this->age_category) {
            $meta_query_item = array(
                'key' => 'age_category',
                'value' => $this->age_category
            );
            $meta_query[] = $meta_query_item;
        }

        if ($this->gcse_maths) {
            $meta_query_item = array(
                'key' => 'gcse_maths',
                'value' => $this->gcse_maths
            );
            $meta_query[] = $meta_query_item;
        }

        if ($this->weekends_availability) {
            $meta_query_item = array(
                'key' => 'weekends_availability',
                'value' => $this->weekends_availability
            );
            $meta_query[] = $meta_query_item;
        }

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