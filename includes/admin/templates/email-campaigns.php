<div class="wrap noptin">
	<h1 id="noptin_email_campaigns_table"><?php echo __( 'Email Campaigns', 'newsletter-optin-box' ); ?></h1>

	<?php

	// Fetch a list of all tabs
	$tabs = array(
		'newsletters' => __( 'Newsletters', 'newsletter-optin-box' ),
		'automations' => __( 'Automated Emails', 'newsletter-optin-box' ),
	);
	$tabs = apply_filters( 'noptin_email_campaign_tabs', $tabs );

	// Prepare the current section and maybe subsection
	$section     = !empty( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'newsletters';
	$sub_section = !empty( $_GET['sub_section'] ) ? sanitize_text_field( $_GET['sub_section'] ) : '';

	// Default to displaying the list of newsletters if no section is provided
	if ( ! $section || empty( $tabs[$section] ) ) {
		$section = 'newsletters';
	}

	// Display the tabs list
	echo '<div class="nav-tab-wrapper noptin-nav-tab-wrapper">';

	foreach( $tabs as $key => $label ) {

		$url = esc_url( add_query_arg( array(
			'page'   => 'noptin-email-campaigns',
			'section' => $key
		), admin_url( '/admin.php' ) ) );

		$class = 'nav-tab';

		if( $section == $key ) {
			$class = 'nav-tab nav-tab-active';
		}

		echo "<a href='$url' class='$class'>$label</a>";
	}

	echo '</div>';

	/**
     * Runs before displaying a tabs content.
     *
     * @param string $section
	 * @param string $sub_section
     */
	do_action( 'noptin_before_display_email_campaigns_tab', $section, $sub_section );

	/**
     * Runs when displaying a specific tab's content.
     *
     * @param string $section
	 * @param string $sub_section
     */
	do_action( "noptin_email_campaigns_tab_$section", $sub_section);

	/**
     * Runs after displaying a tabs content.
     *
     * @param string $section
	 * @param string $sub_section
     */
	do_action( 'noptin_after_display_email_campaigns_tab', $section, $sub_section );

	echo '</div>';
