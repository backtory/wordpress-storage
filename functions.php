<?php

use Backtory\Storage\Core\Contract\Keys;
use Backtory\Storage\Core\Exception\BacktoryException;
use Backtory\Storage\Core\Facade\BacktoryStorage;


if (!function_exists('wp_generate_attachment_metadata')) {
    include(ABSPATH . "wp-admin/includes/image.php");
}
if (!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php");
}

function initBacktory() {
    if (!empty(get_option(X_BACKTORY_AUTHENTICATION_ID) &&
        !empty(get_option(X_BACKTORY_AUTHENTICATION_KEY)) &&
        !empty(get_option(X_BACKTORY_OBJECT_STORAGE_ID)))) {
        BacktoryStorage::init(
            get_option(X_BACKTORY_AUTHENTICATION_ID),
            get_option(X_BACKTORY_AUTHENTICATION_KEY),
            get_option(X_BACKTORY_OBJECT_STORAGE_ID)
        );
    }
}

function get_backtory_path_metadata($id) {
    $attachedFileMeta = get_metadata('post', $id, BACKTORY_META);
    if (empty($attachedFileMeta) || !isset($attachedFileMeta[0])) {
        return "";
    }

    return $attachedFileMeta[0];
}

function backtory_file_transfer($id, $force = null) {
    $uploadDir = wp_get_upload_dir();
    $attachedFileMeta = get_metadata('post', $id, '_wp_attached_file');
    if (empty($attachedFileMeta) || !isset($attachedFileMeta[0])) {
        return;
    }

    if (!empty(get_backtory_path_metadata($id))) {
        return;
    }

    initBacktory();

    $dir = $uploadDir['path'] . DIRECTORY_SEPARATOR;
    $storagePath = str_replace('//', '/', '/' . get_option(BACKTORY_UPLOAD_PATH) . dirname($attachedFileMeta[0]) . '/');
    $fileName = basename($attachedFileMeta[0]);
    $remove = (get_option(BACKTORY_REMOVE_AFTER_TRANSFER) == 1) ? true : false;

    $address = BacktoryStorage::put($dir . $fileName, $storagePath);

    if (!wp_attachment_is_image($id)) {
        if (isset($address[0])) {
            add_metadata("post", $id, BACKTORY_META, $address[0]);
        }

        if ($remove) {
            unlink($dir . $fileName);
        }

        return;
    }

    $files = [];
    $metadata = wp_generate_attachment_metadata($id, $dir . $fileName);
    if (empty($metadata) || !isset($metadata['sizes'])) {
        return;
    }

    foreach ($metadata['sizes'] as $image) {
        $files[] = [
            Keys::FILE => fopen($dir . $image['file'], 'r'),
            Keys::BACKTORY_STORAGE_PATH => $storagePath
        ];
    }

    BacktoryStorage::putFiles($files);
    if (isset($address[0])) {
        add_metadata("post", $id, BACKTORY_META, $address[0]);
    }

    if (empty($force)) {
        return;
    }

    try {
        unlink($dir . $fileName);
//        foreach ($metadata['sizes'] as $image) {
//            unlink($dir . $image['file']);
//        }
    } catch (Exception $exception) {
    }
}

function backtory_file_remove($id) {
    if (empty($path = get_backtory_path_metadata($id))) {
        return;
    }

    initBacktory();

    try {
        BacktoryStorage::delete($path);

        if (!wp_attachment_is_image($id)) {
            delete_metadata('post', $id, BACKTORY_META);

            return;
        }

        $dir = dirname($path);
        $meta = get_metadata('post', $id, '_wp_attachment_metadata');
        if (empty($meta) || !isset($meta[0]) || !isset($meta[0]['sizes'])) {
            delete_metadata('post', $id, BACKTORY_META);

            return;
        }

        foreach ($meta[0]['sizes'] as $image) {
            BacktoryStorage::delete($dir . '/' . $image['file']);
        }

        delete_metadata('post', $id, BACKTORY_META);
    } catch (BacktoryException $exception) {
        throw $exception;
    }
}

function backtory_file_download($id) {
    if (empty($path = get_backtory_path_metadata($id))) {
        return;
    }

    $dest = str_replace(
        '//',
        '/',
        wp_get_upload_dir()['basedir']  . '/' . dirname(str_replace(get_option(BACKTORY_UPLOAD_PATH), '', $path))
    );

    if (!file_exists($dest)) {
        mkdir($dest, 0777, true);
    }

    initBacktory();
    BacktoryStorage::get($path, $dest);

    try {
        if (wp_attachment_is_image($id)) {
            $meta = get_metadata('post', $id, '_wp_attachment_metadata');

            if (!empty($meta) && isset($meta[0]) && isset($meta[0]['sizes'])) {
                foreach ($meta[0]['sizes'] as $image) {
                    BacktoryStorage::get(dirname($path) . '/' . $image['file'], $dest);
                }
            }
        }
    } catch (Exception $exception) {
        $exception->getTrace();
    }
}

function backtory_files_transfer(array $ids = []) {
    foreach ($ids as $id) {
        backtory_file_transfer($id);
    }
}

function backtory_files_remove(array $ids) {
    foreach ($ids as $id) {
        backtory_file_remove($id);
    }
}

function backtory_files_download(array $ids) {
    foreach ($ids as $id) {
        backtory_file_remove($id);
    }
}

