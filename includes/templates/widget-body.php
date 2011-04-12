<?php
    extract( $args, EXTR_SKIP );
    echo $before_widget;
    if ( $title )
        echo $before_title . $title . $after_title;
?>
<form action="" method="post">
    <input type="text" name="mailchimp_subscriber" style="width: 50%;" value="" />
    <input type="hidden" name="mailchimp_list" value="<?php echo $list; ?>" />
    <?php wp_nonce_field( 'scrm_mc_wg', 'scrm_mc_wg_nonce' ); ?>
    <input type="submit" id="mailchimp_submit" value="<?php _e( 'Subscribe', 'scrm_mc_wg' ); ?>">
    <?php
        $classname = '';
        if( isset( $_GET['subscription'] ) ) {
            if( $_GET['subscription'] == 'success' )
                $message = __( 'Your email address was subscribed to our list. Thank you.', 'scrm_mc_wg' );
            else
                $message = __( 'We were unable to subscribe your email address. Please try again.', 'scrm_mc_wg' );
            
            if( in_array( $_GET['subscription'], array( 'success', 'failure' ) ) )
                $classname = $_GET['subscription'];
        }
    ?>
    <p class="<?php echo $classname; ?>">
        <?php echo $message; ?>
    </p>
</form>
<?php echo $after_widget; ?>
