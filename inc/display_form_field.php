        <?php
        // Text field
        if ($this->form_fields[$field]["type"] == "text") { 
            
            if ($do_label) { ?>
                <p class="label"><?php echo $this->form_fields[$field]["label"]; ?></p><?php
            } ?>

            <input type="text" name="<?php echo $field; ?>" value="<?php echo $this->$field; ?>"><?php
        }

        // Select field
        if ($this->form_fields[$field]["type"] == "select") { 
            if ($do_label) { ?>
                <p class="label"><?php echo $this->form_fields[$field]["label"]; ?></p><?php
            } ?>
            <select name="<?php echo $field; ?>">
                <?php if ($search_field) {
                    echo '<option value=""> -- Any -- </option>';
                } else {
                    echo '<option value=""> -- Select -- </option>';
                }
                foreach($this->form_fields[$field]['options'] as $option) { ?>
                    <option value="<?php echo $option['value']; ?>" <?php if ($this->$field == $option['value']) { echo 'selected'; } ?>><?php echo $option['label']; ?></option><?php
                } ?>
            </select>
        <?php
        }

        // Boolean field
        if ($this->form_fields[$field]["type"] == "checkbox") { ?>
            <p><input type="checkbox" name="<?php echo $field; ?>" value="<?php echo $this->form_fields[$field]['value']; ?>" <?php if ($this->$field == $this->form_fields[$field]['value']) { echo 'checked'; } ?>> <?php echo $this->form_fields[$field]['label']; ?></p><?php
        }

        // Textarea field
        if ($this->form_fields[$field]["type"] == "textarea") { 
            if ($do_label) { ?>
                <p class="label"><?php echo $this->form_fields[$field]["label"]; ?></p><?php 
            } ?>
            <textarea name="<?php echo $field; ?>" cols="30" rows="10"><?php echo stripslashes($this->$field); ?></textarea><?php
        }

        // Array field
        if ($this->form_fields[$field]["type"] == "checkboxes") {
            if ($do_label) { ?>
                <p class="label checkbox_list_label"><?php echo $this->form_fields[$field]["label"]; ?></p><?php 
            }
            echo '<div class="checkbox_list">';
            foreach($this->form_fields[$field]["options"] as $option => $data) { ?>
                <p class="checkbox_list"><input type="checkbox" name="<?php echo $field; ?>[]" value="<?php echo $data['value']; ?>"<?php if ($this->$field && in_array($data['value'], $this->$field)) { echo ' checked'; } ?>> <?php echo $data['label']; ?></p><?php
            }
            echo '</div>';
        }

        // Date field
        if ($this->form_fields[$field]["type"] == "date") {
            if ($do_label) { ?>
                <p class="label"><?php echo $this->form_fields[$field]["label"]; ?></p><?php 
            } ?>
            <input type="date" name="<?php echo $field; ?>" value="<?php echo $this->$field; ?>"><?php 
        }