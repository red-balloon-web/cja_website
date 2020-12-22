        <?php
        // array field
        if ($this->form_fields[$field]['is_array']) {
            foreach($this->form_fields[$field]['options'] as $option) {
                if (in_array($option['value'], $this->$field)) {
                    echo '<p class="array_list">' . $option['label'] . '</p>';
                }
            }
        }

        // select field
        if ($this->form_fields[$field]['type'] == 'select' && !$this->form_fields[$field]['is_array']) {

            foreach($this->form_fields[$field]['options'] as $option) {
                if ($option['value'] == $this->$field) { ?>
                    <?php echo $option['label']; ?><?php
                }
            }
        }

        // text field
        if ($this->form_fields[$field]['type'] == 'text') {
            echo $this->$field;
        }

        // textarea field
        if ($this->form_fields[$field]['type'] == 'textarea') {
            echo wpautop($this->$field);
        }

        // date field
        if ($this->form_fields[$field]['type'] == 'date') {
            echo date("j F Y", strtotime($this->$field));
        }