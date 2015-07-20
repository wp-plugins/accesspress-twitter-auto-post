<div class="asap-section" id="asap-section-logs" <?php if ($active_tab != 'logs') { ?>style="display: none;"<?php } ?>>
    <?php
    $table_name = $wpdb->prefix . "atap_logs";
    $logs = $wpdb->get_results("select * from $table_name order by log_id DESC limit 0,100", 'ARRAY_A');
    $afap_clear_log_nonce = wp_create_nonce('atap-clear-log-nonce');
    //$this->print_array($logs);
    ?>
    <div class="asap-clear-log"><a href="<?php echo admin_url("admin-post.php?action=atap_clear_log&_wpnonce=$afap_clear_log_nonce"); ?>" onclick="return confirm('<?php _e('Are you sure you want to clear all the logs', ATAP_TD); ?>')"><input type="button" value="<?php _e('Clear Log', ATAP_TD) ?>"/></a></div>
    <table class="widefat stripped">
        <thead>
            <tr>
                <th><?php _e('Post ID', ATAP_TD); ?></th>
                <th><?php _e('Status', ATAP_TD); ?></th>
                <th><?php _e('Time', ATAP_TD); ?></th>
                <th><?php _e('Log Details', ATAP_TD); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e('Post ID', ATAP_TD); ?></th>
                <th><?php _e('Status', ATAP_TD); ?></th>
                <th><?php _e('Time', ATAP_TD); ?></th>
                <th><?php _e('Log Details', ATAP_TD); ?></th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            if (count($logs) > 0) {
                $log_count = 1;
                foreach ($logs as $log) {
                    $log_id = $log['log_id'];
                    $delete_nonce = wp_create_nonce('atap_delete_nonce');
                    $row_class = ($log_count % 2 == 0) ? 'asap-even-row' : 'asap-odd-row';
                    ?>
                    <tr class="<?php echo $row_class; ?>">
                        <td class="title column-title">
                            <a href="<?php echo admin_url("post.php?post={$log['post_id']}&action=edit"); ?>"><?php echo $log['post_id']; ?></a>
                            <div class="row-actions">
                                <span class="post-link"><a href="<?php echo admin_url("post.php?post={$log['post_id']}&action=edit"); ?>" target="_blank"><?php _e('Go to Post', ATAP_TD) ?></a></span>&nbsp;|&nbsp;
                                <span class="delete"><a href="<?php echo admin_url("admin-post.php?action=atap_delete_log&log_id=$log_id&_wpnonce=$delete_nonce"); ?>" onclick="return confirm('<?php _e('Are you sure you want to delete this log?', ATAP_TD); ?>');">Delete</a></span>
                            </div>
                        </td>
                        <td>
                            <?php echo ($log['log_status'] == 1) ? __('Success', ATAP_TD) : __('Error', ATAP_TD); ?> 
                        </td>
                        <td><?php echo $log['log_time']; ?></td>
                        <td><?php echo $log['log_details']; ?></td>
                    </tr>
                    <?php
                    $log_count++;
                }
            } else {
                ?>
                <tr colspan="3"><td><?php _e('No Logs found', ATAP_TD); ?></td></tr>
                <?php
            }
            ?>

        </tbody>
    </table>
</div>