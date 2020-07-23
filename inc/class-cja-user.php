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
    public $cv_filename;
    public $cv_url;
    public $credits;

    
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
        $this->cv_filename = get_user_meta($this->id, 'cv_filename', true);
        $this->cv_url = get_user_meta($this->id, 'cv_url', true);
        $this->credits = get_user_meta($this->id, 'cja_credits', true);
        
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
        if ($_FILES['cv-file']) {
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
        update_user_meta($this->id, 'cv_filename', $this->cv_filename);
        update_user_meta($this->id, 'cv_url', $this->cv_url);
    }
}