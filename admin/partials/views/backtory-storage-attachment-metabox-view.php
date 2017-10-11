<?php
$metadata = get_metadata('post', $_GET['post'], BACKTORY_META);
if (empty($metadata)): ?>
    <div class="misc-pub-section misc-pub-attachment">
        <div><a href="<?php echo admin_url("?backtory_action=move&id={$_GET['post']}") ?>">move to backtory</a></div>
    </div>
<?php else: ?>
    <div class="misc-pub-section misc-pub-attachment">
        <div><a href="<?php echo admin_url("?backtory_action=remove&id={$_GET['post']}") ?>">remove from backtory</a></div>
        <div><a href="<?php echo admin_url("?backtory_action=copy&id={$_GET['post']}") ?>">download from backtory</a></div>
    </div>
<?php endif;