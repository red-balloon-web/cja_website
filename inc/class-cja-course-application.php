<?php

class CJA_Course_Application {

    /**
     * PROPERTIES
     */

    public $id; // ID of application post
    public $advert_ID; // ID of advert post
    public $applicant_ID; // ID of applicant
    public $advertiser_ID; // ID of advertiser
    public $applicant_name; // Name of applicant
    public $applicant_letter; // Covering letter
    public $cv_url; // Applicant CV
    public $application_date; // Timestamp
    public $human_application_date; // Human readable date
    public $applicant_archived; // Timestamp
    public $advertiser_archived; // Timestamp

    /**
     * CONSTRUCTOR
     */

    function __construct($id = 0) {
        if ($id) {
            $this->id = $id;
            $this->advert_ID = get_post_meta($this->id, 'advertID', true);
            $this->applicant_ID = get_post_meta($this->id, 'applicantID', true);
            $this->advertiser_ID = get_post_meta($this->id, 'advertiserID', true);
            $this->applicant_name = get_post_meta($this->id, 'applicantName', true);
            $this->applicant_letter = get_post_meta($this->id, 'applicantLetter', true);
            $this->cv_url = get_post_meta($this->id, 'cvurl', true);
            $this->application_date = get_post_meta($this->id, 'applicationDate', true);
            $this->human_application_date = $this->get_human_application_date();
            $this->applicant_archived = get_post_meta($this->id, 'applicant_archived', true);
            $this->advertiser_archived = get_post_meta($this->id, 'advertiser_archived', true);
        }
    }

    /**
     * PUBLIC FUNCTIONS
     */

    // Populate the object from POST form
    public function update_from_form($cja_current_ad, $cja_current_user_obj) {
        $this->advert_ID = $cja_current_ad->id;
        $this->applicant_ID = $cja_current_user_obj->id;
        $this->advertiser_ID = $cja_current_ad->author;
        $this->applicant_name = $cja_current_user_obj->full_name;
        // $this->applicant_letter = $_POST['letter'];
        $this->cv_url = $cja_current_user_obj->cv_url;
        $this->applicant_archived = 0;
        $this->advertiser_archived = 0;
    }

    // When a user submits an application, create new Application WP Post
    public function create($id) {

        $post_array = array(
            'post_title' => 'Application to Advert #' . $id,
            'post_content' => 'Application',
            'post_status' => 'publish',
            'post_type' => 'course_application'
        );

        $success = wp_insert_post($post_array);
        if (is_int($success)) {
            $this->id = $success;
        }
    }

    // Save object in the database
    public function save() {

        update_post_meta($this->id, 'advertID', $this->advert_ID);
        update_post_meta($this->id, 'applicantID', $this->applicant_ID);
        update_post_meta($this->id, 'advertiserID', $this->advertiser_ID);
        update_post_meta($this->id, 'applicantName', $this->applicant_name);
        update_post_meta($this->id, 'applicantLetter', $this->applicant_letter);
        update_post_meta($this->id, 'cvurl', $this->cv_url);
        update_post_meta($this->id, 'applicationDate', strtotime(date('j F Y')));
        update_post_meta($this->id, 'applicant_archived', $this->applicant_archived);
        update_post_meta($this->id, 'advertiser_archived', $this->advertiser_archived);
    }

    // Archive application for applicant
    public function applicant_archive() {
        $this->applicant_archived = strtotime(date('j F Y'));
    }

    // Archive function for advertiser
    public function advertiser_archive() {
        $this->advertiser_archived = strtotime(date('j F Y'));
    }

    /**
     * PRIVATE FUNCTIONS
     */

    // Return human friendly application date
    private function get_human_application_date() {

        if (is_numeric($this->application_date)) {
            return date("j F Y", $this->application_date);
        } else {
            return "Application Date not Set";
        }
    }
}

?>