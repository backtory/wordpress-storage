<?php

class Backtory_Storage_Template {

    public function attachment_modal_template() {
        if (is_admin()){
            require_once "views/backtory-storage-attachment-modal-view.php";
        }
    }

    public function attachment_submitbox_metadata() {
        if (is_admin()) {
            require_once "views/backtory-storage-attachment-metabox-view.php";
        }
    }

}
