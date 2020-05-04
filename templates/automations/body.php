<div style="margin-top: 20px;"></div>
<?php
    $body = wp_kses_post( stripslashes_deep( $campaign->post_content ) );

    wp_editor(
        $body,
        'noptinemailbody',
        array(
            'media_buttons'    => true,
            'drag_drop_upload' => true,
            'textarea_rows'    => 15,
            'textarea_name'    => 'email_body',
            'tabindex'         => 4,
            'tinymce'          => array(
                'theme_advanced_buttons1' => 'bold,italic,underline,|,bullist,numlist,blockquote,|,link,unlink,|,spellchecker,fullscreen,|,formatselect,styleselect',
            ),
        )
    );
