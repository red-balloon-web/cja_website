<?php

class Cja_current_user {

    public $is_logged_in = 0;
    public $id;
    public $loginname;
    public $role;
    public $nicename;
    public $firstname;
    public $surname;
    public $fullname;
    public $companyname;
    // number of credits
    public $statement;
    public $cvfilename;
    public $cvurl;
    
    public function populate() {
        $this->is_logged_in = is_user_logged_in();
        
        if ($this->is_logged_in) {
            $this->id = get_current_user_id();
            $this->loginname = wp_get_current_user()->data->user_login;
            $this->role = $this->cja_get_user_role();
            $this->nicename = wp_get_current_user()->data->user_nicename;
            $this->firstname = wp_get_current_user()->first_name;
            $this->surname = wp_get_current_user()->last_name;
            $this->fullname = $this->firstname . ' ' . $this->surname;
            $this->companyname = get_user_meta($this->id, 'companyname', true);
            $this->statement = get_user_meta($this->id, 'statement', true);
            $this->cvfilename = get_user_meta($this->id, 'cvfilename', true);
            $this->cvurl = get_user_meta($this->id, 'cvurl', true);
        }
    }
    
    private function cja_get_user_role() {
        $userObj = wp_get_current_user();
        $role = $userObj->roles[0];
        return $role;
    }

    // Update object from $_POST data
    public function updateFromForm() {
        if ($_POST['companyname']) {
            $this->companyname = $_POST['companyname'];
        }
        if ($_POST['nicename']) {
            $this->nicename = $_POST['nicename'];
        }
        if ($_POST['firstname']) {
            $this->firstname = $_POST['firstname'];
        }
        if ($_POST['surname']) {
            $this->surname = $_POST['surname'];
        }
        if ($_POST['statement']) {
            $this->statement = $_POST['statement'];
        }
        if ($_FILES['cv-file']) {
            print_r($_FILES['cv-file']);
            if ( ! function_exists( 'wp_handle_upload' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            }
            $uploadedfile = $_FILES['cv-file'];

            $upload_overrides = array(
                'test_form' => false
            );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            $this->cvfilename = $uploadedfile['name'];
            $this->cvurl = $movefile['url'];
        }
    }

    // Update all properties in the WP database
    public function saveToDatabase() {
        $userdata = array(
            'ID' => $this->id,
            'user_nicename' => $this->nicename,
            'first_name' => $this->firstname,
            'last_name' => $this->surname
        );
        wp_update_user($userdata);
        update_user_meta($this->id, 'companyname', $this->companyname);
        update_user_meta($this->id, 'statement', $this->statement);
        update_user_meta($this->id, 'cvfilename', $this->cvfilename);
        update_user_meta($this->id, 'cvurl', $this->cvurl);
    }

}