<?php

class Application {

    public $id; // ID of application post
    public $advertID; // ID of advert post
    public $applicantID; // ID of applicant
    public $advertiserID; // ID of advertiser
    public $applicantName; // Name of applicant
    public $applicantLetter; // Covering letter
    public $cvurl; // Applicant CV
    public $applicationDate; // Timestamp
    public $humanActivationDate; // Human readable date

    // Populate the object from POST form
    public function populateFromForm($currentAd, $cja_current_user_obj) {
        $this->advertID = $currentAd->id;
        $this->applicantID = $cja_current_user_obj->id;
        $this->advertiserID = $currentAd->author;
        $this->applicantName = $cja_current_user_obj->fullname;
        $this->applicantLetter = $_POST['letter'];
        $this->cvurl = $cja_current_user_obj->cvurl;
    }

    // When a user submits an application, create new Application post and store all meta in the database
    public function createPost() {

        $postArray = array(
            'post_title' => 'Application for Advert #' . $this->advertID . ' by User #' . $this->applicantID,
            'post_content' => 'Application',
            'post_status' => 'publish',
            'post_type' => 'application'
        );

        $success = wp_insert_post($postArray);
        if (is_int($success)) {
            $this->id = $success;
        }

        update_post_meta($this->id, 'advertID', $this->advertID);
        update_post_meta($this->id, 'applicantID', $this->applicantID);
        update_post_meta($this->id, 'advertiserID', $this->advertiserID);
        update_post_meta($this->id, 'applicantName', $this->applicantName);
        update_post_meta($this->id, 'applicantLetter', $this->applicantLetter);
        update_post_meta($this->id, 'cvurl', $this->cvurl);
        update_post_meta($this->id, 'applicationDate', strtotime(date('j F Y')));
    }

    
    public function populate($id) {
        $this->id = $id;
        $this->advertID = get_post_meta($this->id, 'advertID', true);
        $this->applicantID = get_post_meta($this->id, 'applicantID', true);
        $this->advertiserID = get_post_meta($this->id, 'advertiserID', true);
        $this->applicantName = get_post_meta($this->id, 'applicantName', true);
        $this->applicantLetter = get_post_meta($this->id, 'applicantLetter', true);
        $this->cvurl = get_post_meta($this->id, 'cvurl', true);
        $this->applicationDate = get_post_meta($this->id, 'applicationDate', true);
        $this->humanApplicationDate = $this->getHumanApplicationDate();
    }
    
    // Return human friendly application date
    private function getHumanApplicationDate() {

        if (is_numeric($this->applicationDate)) {
            return date("j F Y", $this->applicationDate);
        } else {
            return "Application Date not Set";
        }
    }
}

?>