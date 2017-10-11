<?php
if (!is_admin()) {
    return;
}

if (!isset($_GET['backtory_action'])) {
    return;
}

if ($_GET['backtory_action'] == 'moveAll') {
    $posts = get_posts(['post_type' => 'attachment']);

    foreach ($posts as $post) {
        backtory_file_transfer($post->ID, get_option(BACKTORY_REMOVE_AFTER_TRANSFER));
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    return;
}

if (!isset($_GET['id'])) {
    return;
}

$id = (int) $_GET['id'];
switch (strtolower($_GET['backtory_action'])) {
    case 'move':
        backtory_file_transfer($id);
        break;
    case 'remove':
        backtory_file_remove($id);
        break;
    case 'copy':
        backtory_file_download($id);
        break;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
return;