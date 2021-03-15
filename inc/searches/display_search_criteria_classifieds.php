<div class="cja_search_criteria"><?php 

    global $pagenow;

    if ($cja_search->cja_id) { ?>
    <p>Advert ID: <strong><?php echo $cja_search->cja_id; ?></strong></p>
    <?php }

    if ($cja_search->max_distance) { ?>
        <p>Maximum Distance: <strong><?php echo $cja_search->max_distance; ?> miles</strong></p><?php 
    }
    
    if ($cja_search->category) { ?>
        <p>Category: <strong><?php echo $cja_search->return_human('category'); ?></strong></p><?php 
    } 

    if ($cja_search->earliest_creation_date || $cja_search->latest_creation_date) { ?>
        <p>Display adverts posted<?php
        if ($cja_search->earliest_creation_date) {
            $date_time = new DateTime($cja_search->earliest_creation_date);
            echo ' after ';
            echo $date_time->format('D d F Y');
            if ($cja_search->latest_creation_date) {
                echo ' and ';
            }
        }
        if ($cja_search->latest_creation_date) {
            $date_time = new DateTime($cja_search->latest_creation_date);
            echo ' before ';
            echo $date_time->format('D d F Y');
        }
    } 
    
    if ($pagenow != 'edit.php') {?>
    
        <p>Order results by: <strong><?php 
            if ($cja_search->order_by == 'date') {
                echo 'Newest Adverts First';
            } else if ($cja_search->order_by == 'distance') {
                echo 'Closest Adverts First';
            } ?></strong>
        </p> <?php
    } ?>

</div>