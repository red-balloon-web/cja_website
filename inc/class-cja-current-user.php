<?php

class Cja_current_user {

    public $is_logged_in = 0;
    public $id;
    public $role;
    
    private function cja_get_user_role() {
        $userObj = wp_get_current_user();
        $role = $userObj->roles[0];
        return $role;
    }

    public function populate() {
        $this->is_logged_in = is_user_logged_in();

        if ($this->is_logged_in) {
            $this->id = get_current_user_id();
            $this->role = $this->cja_get_user_role();
        }
    }


}