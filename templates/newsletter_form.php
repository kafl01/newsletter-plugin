<form id="our_newsletter" method="POST" action="<?php echo admin_url('admin-ajax.php') //skriver alltid så här i samband med ett ajax anrop 
                                                ?>">
    <label>
        <input type="email" name="email">
    </label>

    <!-- <input type="hidden" name="wcm_newsletter_id" value="<?php the_ID(); ?>"> -->
    <input type="hidden" name="action" value="my_newsletter_ajax_action">
    <?php wp_nonce_field('newsletter_nonce', 'nonce'); ?>
    <button type="submit" name="register_newsletter">Skicka</button>
</form>