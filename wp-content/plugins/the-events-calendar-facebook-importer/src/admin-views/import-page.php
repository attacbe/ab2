<?php

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$fb_uids = Tribe__Events__Main::getOption( 'fb_uids' );
$settings_url = esc_url( add_query_arg( array( 'post_type' => Tribe__Events__Main::POSTTYPE, 'page' => 'tribe-events-calendar', 'tab' => 'fb-import' ), admin_url( 'edit.php' ) ) );
?>

<div class="tribe_settings wrap">

	<?php screen_icon( 'edit' ); ?>
	<h2><?php esc_html_e( 'Import Facebook Events', 'tribe-fb-import' ); ?></h2>

	<?php if ( ! empty( $this->errors ) ) : ?>
		<div class="error">
			<p><strong><?php esc_html_e( 'The following errors have occurred:', 'tribe-fb-import' ); ?></strong></p>
			<ul class="admin-list">
				<?php foreach ( $this->errors as $error ) : ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $this->no_events_imported ) : ?>
				<p><?php esc_html_e( 'Please note that as a result, no events were successfully imported.', 'tribe-fb-import' ); ?></p>
			<?php else : ?>
				<p><?php esc_html_e( 'Please note that other events have been successfully imported.', 'tribe-fb-import' ); ?></p>
			<?php endif; ?>
		</div>
	<?php elseif ( $this->success ) : ?>
		<div class="updated">
			<p><?php
				printf( esc_html( _n( 'The selected event has been successfully imported.', 'The %d selected events have been successfully imported.', $this->imported_total, 'tribe-fb-import' ) ), absint( $this->imported_total ) );
				?>
				<a href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'tribe_events' ), admin_url( 'edit.php' ) ) ); ?>"><?php esc_html_e( 'Go take a look at your event(s)', 'tribe-fb-import' ); ?> &raquo; </a>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $this->errors_images ) ) : ?>
		<div class="error">
			<p><strong><?php esc_html_e( 'The following errors have occurred during importing images:', 'tribe-fb-import' ); ?></strong></p>
			<ul class="admin-list">
				<?php foreach ( $this->errors_images as $error ) : ?>
					<li><?php echo $error; ?></li>
				<?php endforeach; ?>
			</ul>
			<p><?php esc_html_e( 'Please note that this does not effect importing of associated events unless noted.', 'tribe-fb-import' ); ?></p>
		</div>
	<?php endif; ?>

	<div id="modern-tribe-info" style="max-width: 800px; padding-top: 15px;">
		<h2><?php esc_html_e( 'How to Import Facebook Events', 'tribe-fb-import' ); ?></h2>
		<?php if ( empty( $fb_uids ) ) : ?>
			<p><?php printf( esc_html__( 'Select which events you want to import from specific Facebook Pages or Users by entering their details on the  %ssettings page%s. Return to this page to choose which of their events you would like to import.', 'tribe-fb-import' ), '<a href="' . esc_url( $settings_url ) . '">', '</a>' ); ?></p>
		<?php else : ?>
			<p><?php printf( esc_html__( 'Since you\'ve already setup some Facebook organization(s) or page(s) to import from, you can import their events below. Visit the %ssettings page%s to modify the Facebook organization(s) or page(s) you want to import from.', 'tribe-fb-import' ), '<a href="' . esc_url( $settings_url ) . '">', '</a>' ); ?></p>
		<?php endif; ?>
			<p><?php esc_html_e( 'You can also import any specific event by entering Facebook event IDs in the text area below.', 'tribe-fb-import' ); ?></p>
			<p><?php printf( esc_html__( 'You can determine an event\'s Facebook ID by looking at the URL of the event. For example, the ID of this event: %1$s would be %2$s', 'tribe-fb-import' ), 'https://www.facebook.com/events/12345689', '123456789' ); ?></p>
	</div>

	<div class="tribe-settings-form">

	<form method="post">
		<div class="tribe-settings-form-wrap">

		<?php if ( ! empty( $fb_uids ) ) : ?>
			<h3><?php esc_html_e( "Events from Facebook organizations or pages you've added:", 'tribe-fb-import' ); ?></h3>
			<p>
				<?php $this->build_import_fields( $fb_uids ) ?>
			</p>
		<?php endif; ?>

		<h3><?php esc_html_e( 'Import events by their Facebook ID:', 'tribe-fb-import' ); ?></h3>
		<div>
			<label for="tribe-fb-import-events-by-id"></label><br><textarea id="tribe-fb-import-events-by-id" name="tribe-fb-import-events-by-id" rows="5" cols="50"></textarea>
			<p><span class="description"><?php esc_html_e( 'One event ID per line', 'tribe-fb-import' ); ?></span></p>
			<br><br>
		</div>

		<?php wp_nonce_field( 'tribe-fb-import', 'tribe-confirm-import' ) ?>
		<input id="tribe-fb-import-submit" class="button-primary" type="submit" value="<?php esc_html_e( 'Import events', 'tribe-fb-import' ); ?>">

		</div>
	</form>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		$('#tribe-fb-import-submit').click(function(e){
			var any_checked = false;
			$('.checkbox').each(function(){
				if ( $(this).prop('checked') && !$(this).prop('disabled') ) {
					any_checked = true;
				}
			});
			if ( !any_checked && $('#tribe-fb-import-events-by-id').val() == '' ) {
				e.preventDefault();
				alert("<?php esc_html_e( 'Please select or enter the ID of at least one event to import', 'tribe-fb-import' ) ?>");
			}
		});;
	});
</script>
