<?php
if (!is_admin()) {
    return;
}

if (!isset($_GET['backtory_action'])) {
    return;
}

if ($_GET['backtory_action'] == 'moveAll') {
    $posts = get_posts(['post_type' => 'attachment', 'numberposts' => PHP_INT_MAX ]);

    $extensions = get_option(BACKTORY_WHITE_LIST_EXTENSIONS);
    $extensions = !empty($extensions) ? explode(',', $extensions . ',') : [];

    $post = get_post($id);

    foreach ($posts as $post) {
        if (empty($extensions) || in_array(end(explode(".", $post->guid)), $extensions ) ){
            echo "move---> " .$post->guid."<br>";


            backtory_file_transfer($post->ID, true);
        } else {
            echo "not move---> " .$post->guid."<br>";

        }
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
