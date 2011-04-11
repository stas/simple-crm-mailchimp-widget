<p>
    <label for="<?php echo $title_id; ?>">
        <?php _e( 'Title', 'scrm_mc_wg' ); ?>:
    </label> 
    <input class="widefat" id="<?php echo $title_id; ?>" name="<?php echo $title_name; ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
    <label for="<?php echo $message_id; ?>">
        <?php _e( 'Message', 'scrm_mc_wg' ); ?>:
    </label> 
    <textarea class="widefat" id="<?php echo $message_id; ?>" name="<?php echo $message_name; ?>"><?php
        echo $message;
    ?></textarea>
</p>
<p>
    <label for="<?php echo $list_id; ?>">
        <?php _e( 'Mailchimp list ID', 'scrm_mc_wg' ); ?>:
    </label> 
    <?php if( $lists && $lists['total'] != 0 ): ?>
        <select class="widefat" id="<?php echo $list_id; ?>" name="<?php echo $list_name; ?>">
            <?php foreach( $lists['data'] as $l ): ?>
                <option value="<?php echo $l['id']; ?>" <?php selected( $l['id'], $list ); ?> ><?php echo $l['name']; ?></option>
            <?php endforeach; ?>
        </select>
    <?php else: ?>
        <br/>
        <em>
            <?php _e( 'No api key or lists found. Start by adding one on MailChimp website.','scrm_mc' )?>
        </em>
    <?php endif; ?>
</p>
