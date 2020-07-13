<?php

class Advert {

    public $id; // ID of advert post
    public $adType; // job_ad or course_ad
    public $title; // ad title
    public $content; // ad content
    public $status; // active, expired, etc.
    public $expiryDate; // expiry date as timestamp
    public $activationDate; // activation date as timestamp
    public $author; // ID of user placing ad
    public $authorHumanName; // Humain readable author (company) name

    // Create a new WP Post
    public function create() {
        $postarray = array(
            'post_type' => 'job_ad',
            'post_status' => 'publish'
        );
        $this->id = wp_insert_post( $postarray, true );
        return $this->id;
    }

    // Update object from $_POST data
    public function updateFromForm() {
        if ($_POST['ad-title']) {
            $this->title = $_POST['ad-title'];
        }
        if ($_POST['ad-content']) {
            $this->content = $_POST['ad-content'];
        }
    }

    // Update all properties in the WP database
    public function saveToDatabase() {
        $values = array(
            'ID'           => $this->id,
            'post_title'   => $this->title,
            'post_content' => $this->content,
        );
        wp_update_post( $values );

        update_post_meta($this->id, 'cja_ad_status', $this->status);
        update_post_meta($this->id, 'cja_ad_expiry_date', $this->expiryDate);
    }

    // Activate the advert
    public function activate() {
        $this->status = 'active';
        $this->activationDate = strtotime(date('j F Y'));
        $this->expiryDate = strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y')))));
        update_post_meta($this->id, 'cja_ad_status', 'active');
        update_post_meta($this->id, 'cja_ad_activation_date', strtotime(date('j F Y')));
        update_post_meta($this->id, 'cja_ad_expiry_date', strtotime(date("j F Y", strtotime("+1 month", strtotime(date('j F Y'))))));
    }

    // Extend the advert
    public function extend() {
        $this->expiryDate = strtotime(date("j F Y", strtotime("+1 month", $this->expiryDate)));
        update_post_meta($this->id, 'cja_ad_expiry_date', $this->expiryDate);
    }

    // Populate the object with values from the database according to ID
    public function populate($id) {
        $this->id = $id;
        $this->adType = get_post_type($id);
        $this->title = get_the_title($id);
        $this->content = get_the_content(null, false, $id);
        $this->status = get_post_meta($id, 'cja_ad_status', true);
        $this->expiryDate = get_post_meta($id, 'cja_ad_expiry_date', true);
        $this->activationDate = get_post_meta($id, 'cja_ad_activation_date', true);
        $this->humanActivationDate = $this->getHumanActivationDate();
        $this->author = get_post_field( 'post_author', $id );
        $this->authorHumanName = $this->getHumanName();
    }

    // Delete ad (not delete post but set status to deleted)
    public function delete() {
        $this->status = 'deleted';
        update_post_meta($this->id, 'cja_ad_status', $this->status);
    }

    // Calculate number of days left for ad to run as integer
    public function daysLeft() {
        return abs(round($this->expiryDate - strtotime(date('j F Y'))) / 86400);
    }

    // Return whether ad is active
    public function isActive() {
        if ($this->status == 'active') {
            return true;
        } else {
            return false;
        }
    }

    // Return human friendly activation date
    private function getHumanActivationDate() {
        return date("j F Y", $this->activationDate);
    }

    // Return human friendly author (company) name 
    private function getHumanName() {
        return get_user_meta($this->author, 'companyname', true);
    }
}

?>