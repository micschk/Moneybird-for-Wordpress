<?php

add_action( 'load-post.php', 'moneybird_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'moneybird_post_meta_boxes_setup' );

function moneybird_post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'moneybird_add_post_meta_boxes' );
}

function moneybird_add_post_meta_boxes(){
	add_meta_box(
		'moneybird-post-class',			// Unique ID
		esc_html__( 'Moneybird verstuur factuur', 'example' ),		// Title
		'moneybird_post_class_meta_box',		// Callback function
		'mb_invoices',					// Admin page (or post type)
		'side',					// Context
		'default'				// Priority
	);
	add_meta_box(
		'moneybird-create-post-class',			// Unique ID
		esc_html__( 'Moneybird maak factuur', 'example' ),		// Title
		'moneybird_create_post_class_meta_box',		// Callback function
		'mb_companies',					// Admin page (or post type)
		'side',					// Context
		'default'				// Priority
	);
	add_meta_box(
		'moneybird-reminder-post-class',			// Unique ID
		esc_html__( 'Moneybird verstuur reminder', 'example' ),		// Title
		'moneybird_reminder_post_class_meta_box',		// Callback function
		'mb_invoices',					// Admin page (or post type)
		'side',					// Context
		'default'				// Priority
	);
}
function moneybird_post_class_meta_box( $object, $box ) { ?>

	<p id="verstuurfactuur-response"></p>
	<p>
		<?php echo '<strong>Stap 1:</strong> Klik op <strong>publiceren/bijwerken</strong> om een concept factuur te maken. <br/> <strong>Stap 2:</strong> Klik op <strong>maak definitief</strong> om de factuur te versturen en definitief te maken.'; ?>
		<br/><br/>
		<input name="save" class="button-primary" id="verstuurfactuur" tabindex="5" accesskey="p" value="Maak definitief" rel="<?php echo $_GET['post']; ?>">
	</p>
	
<?php }

function moneybird_create_post_class_meta_box( $object, $box ) { ?>

	<p id="maakfactuur-response"></p>
	<p style="text-align:justify;">
		Klik hieronder om een factuur te maken.
		<br/><br/>
		<input name="save" class="button-primary" id="maakfactuur" tabindex="5" accesskey="p" value="Maak factuur" rel="<?php echo $_GET['post']; ?>">
	</p>
	
<?php }

function moneybird_reminder_post_class_meta_box( $object, $box ) { ?>

	<p id="sendreminder-response"></p>
	<p>
		<input name="save" class="button-primary" id="sendreminder" tabindex="5" accesskey="p" value="Verstuur" rel="<?php echo $_GET['post']; ?>">
	</p>
	
<?php }

?>