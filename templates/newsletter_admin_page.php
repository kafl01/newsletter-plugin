<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form action="options.php" method="POST">
    <?php
    settings_fields('wcm_newsletter_settings');
    do_settings_sections('wcm_newsletter_settings');
    // do_settings_fields('wcm_newletter_settings', 'default');
    submit_button(__('Save settings', 'wcm_newsletter'));
    ?>
</form>
<?php
$args = [
    'headers' => [
        'Content-Type'  => 'application/json',
        'Authorization' => 'Token ' . get_option('wcm_newsletter_api_key'),
    ],
];

$listToken = "uw89hs6Y8l2aOC1rq";

$apiUrls   = [
    'lists'       => "https://api.getanewsletter.com/v3/lists/",
    'contacts'    => "https://api.getanewsletter.com/v3/contacts/",
    'subscribers' => "https://api.getanewsletter.com/v3/lists/$listToken/subscribers/",
];
$response = wp_remote_get($apiUrls['lists'], $args);
var_dump(json_decode(wp_remote_retrieve_body($response)));
