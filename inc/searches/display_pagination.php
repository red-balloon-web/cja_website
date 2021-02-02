<?php
// Pagination
if ($cja_pages > 1) { // don't display if only one page

    ?><div class="cja_pagination"><?php
        if ($cja_page > 1) {
            ?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page - 1; ?>"><<<</a><?php
        } 
        for ($i=0; $i < $cja_pages; $i++) {
            //echo ('link to page ' . $i . ' ');
            ?><a class="page-numbers<?php if ($cja_page == $i + 1) {echo ' current'; } ?> " href="<?php echo get_page_link(); ?>?cjapage=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
            <?php
        }
        if ($cja_page < $cja_pages) {
            ?><a class="page-numbers" href="<?php echo get_page_link(); ?>?cjapage=<?php echo $cja_page + 1; ?>">>>></a><?php
        } ?>
    </div><?php 
}