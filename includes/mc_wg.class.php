<?php
class MC_WG extends WP_Widget {
    /**
     * Static method hooked to init
     */
    function init() {
        add_action( 'widgets_init', array( 'MC_WG', 'register' ) );
        add_action( 'init', array( 'MC_WG', 'subscribe' ) );
    }
    
    /**
     * Callback to register the widget
     */
    function register() {
        register_widget( "MC_WG" );
    }
    
    /**
     * Widget constructor
     */
    function MC_WG() {
        $widget_name = __( 'MailChimp list subscribe form', 'scrm_mc_wg' );
        $widget_vars = array(
            'classname' => 'mailchimp-subscribe-widget',
            'description' => __( 'Show a form to allow visitors subscribe to a list using MailChimp API', 'scrm_mc_wg' )
        );
        parent::WP_Widget( "mailchimp-subscribe-widget", $widget_name, $widget_vars );
    }
    
    /**
     * Widget content
     */
    function widget( $args, $instance ) {
        $args['title'] = '';
        $args['message'] = '';
        
        if( isset( $instance['title'] ) )
            $args['title'] = apply_filters( 'widget_title', $instance['title'] );
        
        if( isset( $instance['message'] ) )
            $args['message'] = apply_filters( 'mailchimp_widget_message', $instance['message'] );
        
        if( isset( $instance['list'] ) )
            $args['list'] = apply_filters( 'mailchimp_widget_list', $instance['list'] );
        
        $vars['args'] = $args;
        $vars['path'] = SCRM_MC_WG_ROOT . '/includes/templates/';
        template_render( 'widget-body', $vars, true );
    }
    
    /**
     * Widget on update handler
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['message'] = sanitize_text_field( $new_instance['message'] );
        $instance['list'] = sanitize_text_field( $new_instance['list'] );
        
        return $instance;
    }

    /**
     * Widget form
     */
    function form( $instance ) {
        $vars['lists'] = null;
        $api_key = get_option( 'scrm_mc_api_key', '' );
        
        if( $api_key ) {
            $mc_api = new MCAPI( $api_key );
            $vars['lists'] = $mc_api->lists();
        }
        
        $vars['title'] = '';
        $vars['title_id'] = $this->get_field_id( 'title' );
        $vars['title_name'] = $this->get_field_name( 'title' );
        
        $vars['message'] = '';
        $vars['message_id'] = $this->get_field_id( 'message' );
        $vars['message_name'] = $this->get_field_name( 'message' );
        
        $vars['list'] = '';
        $vars['list_id'] = $this->get_field_id( 'list' );
        $vars['list_name'] = $this->get_field_name( 'list' );
        
        if( isset( $instance['title'] ) )
            $vars['title'] = sanitize_text_field( $instance['title'] );
        
        if( isset( $instance['message'] ) )
            $vars['message'] = sanitize_text_field( $instance['message'] );
        
        if( isset( $instance['list'] ) )
            $vars['list'] = sanitize_text_field( $instance['list'] );
        
        $vars['path'] = SCRM_MC_WG_ROOT . '/includes/templates/';
        template_render( 'widget-form', $vars, true );
    }
    
    /**
     * Handle the proper MailChimp subscription
     */
    function subscribe() {
        if( isset( $_POST['scrm_mc_wg_nonce'] ) && wp_verify_nonce( $_POST['scrm_mc_wg_nonce'], 'scrm_mc_wg' ) ) {
            if( isset( $_POST['mailchimp_subscriber'] ) && isset( $_POST['mailchimp_list'] ) ) {
                $subscriber = sanitize_email( $_POST['mailchimp_subscriber'] );
                $list_id = sanitize_text_field( $_POST['mailchimp_list'] );
                $api_key = null;
                $response = false;
                
                if( $subscriber && $list_id )
                    $api_key = get_option( 'scrm_mc_api_key', '' );
                
                if( $api_key ) {
                    $mc_api = new MCAPI( $api_key );
                    $response = $mc_api->listSubscribe(
                        $list_id,
                        $subscriber,
                        array(),
                        'html',
                        false,
                        true,
                        true,
                        true // Send welcome
                    );
                }
                
                // Send a notice
                $same_url = get_site_url() . $_POST["_wp_http_referer"];
                if( $response )
                    wp_redirect( add_query_arg( array( 'subscription' => 'success' ), $same_url ) );
                else
                    wp_redirect( add_query_arg( array( 'subscription' => 'failure' ), $same_url ) );
            }
        }
    }
}
?>
