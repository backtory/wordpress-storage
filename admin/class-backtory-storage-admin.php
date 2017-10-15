<?php
use Backtory\Storage\Core\Facade\BacktoryStorage;

/**
 * Class Backtory_Storage_Admin
 */
class Backtory_Storage_Admin {

    /**
     * @var
     */
    private $plugin_name;

    /**
     * @var
     */
    private $version;

    /**
     * Backtory_Storage_Admin constructor.
     * @param $plugin_name
     * @param $version
     */
    public function __construct($plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     *
     */
    public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/backtory-storage-admin.css', array(), $this->version, 'all' );
	}

    /**
     *
     */
    public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/backtory-storage-admin.js', array( 'jquery' ), $this->version, false );
	}

    /**
     *
     */
    public function add_plugin_menu() {
        add_menu_page(__( 'Backtory Storage', 'textdomain' ), 'Backtory', 'manage_options', 'backtory-storage',
            function () {
                require_once __DIR__ . '/partials/views/backtory-storage-options-view.php';
            },
            plugins_url( 'backtory-storage/admin/img/backtory.png' )
        );
    }

    /**
     *
     */
    public function register_option_fields() {
        add_option( X_BACKTORY_AUTHENTICATION_ID );
        add_option( X_BACKTORY_AUTHENTICATION_KEY );
        add_option( X_BACKTORY_STORAGE_ID );
        add_option( BACKTORY_BUCKET);
        add_option( BACKTORY_DOMAIN , BACKTORY_STORAGE_URL );
        add_option( BACKTORY_UPLOAD_PATH, BACKTORY_DEFAULT_PATH );
        add_option( BACKTORY_REMOVE_AFTER_TRANSFER, false );
        add_option( BACKTORY_ENABLED, true );
        add_option( BACKTORY_WHITE_LIST_EXTENSIONS );

        register_setting( 'backtory_storage', X_BACKTORY_AUTHENTICATION_ID );
        register_setting( 'backtory_storage', X_BACKTORY_STORAGE_ID );
        register_setting( 'backtory_storage', X_BACKTORY_AUTHENTICATION_KEY );
        register_setting( 'backtory_storage', BACKTORY_DOMAIN );
        register_setting( 'backtory_storage', BACKTORY_UPLOAD_PATH );
        register_setting( 'backtory_storage', BACKTORY_BUCKET );
        register_setting( 'backtory_storage', BACKTORY_REMOVE_AFTER_TRANSFER );
        register_setting( 'backtory_storage', BACKTORY_ENABLED );
        register_setting( 'backtory_storage', BACKTORY_WHITE_LIST_EXTENSIONS );
    }

    /**
     * @param $actions
     * @return mixed
     */
    public function test_filter($actions) {
        $actions[BACKTORY_BULK_ACTION_MOVE] = __( 'Move To Backtory');
        $actions[BACKTORY_BULK_ACTION_REMOVE] = __( 'Remove from Backtory');
        $actions[BACKTORY_BULK_ACTION_COPY] = __( 'Copy from Backtory to local');

        return $actions;
    }

    /**
     * @param $actions
     * @param null $post
     * @return mixed
     */
    public function row_filter($actions, $post = null) {
        $meta = get_metadata('post', $post->ID, BACKTORY_META);
        if (empty($meta)) {
            $actions[BACKTORY_BULK_ACTION_MOVE] = "<a href='" . admin_url("?backtory_action=move&id={$post->ID}") . "'>" . __("move to backtory") . '</a>';
        } else {
            $actions[BACKTORY_BULK_ACTION_REMOVE] = "<a href='" . admin_url("?backtory_action=remove&id={$post->ID}") . "'>" . __("remove from backtory") . '</a>';
            $actions[BACKTORY_BULK_ACTION_COPY] = "<a href='" . admin_url("?backtory_action=copy&id={$post->ID}") . "'>" . __("copy to server") . '</a>';
        }

        return $actions;
    }

    /**
     * @param $id
     */
    public function attachment($id) {
        if (get_option(BACKTORY_ENABLED)) {
            $extensions = get_option(BACKTORY_WHITE_LIST_EXTENSIONS);

            if (empty($extensions)) {
                backtory_file_transfer($id);
                return;
            }

            $post = get_post($id);
            if (in_array(end(explode(".", $post->guid)), explode(',', $extensions . ','))) {
                backtory_file_transfer($id);
            }
        }
    }

    /**
     * @param $redirect_to
     * @param $action_name
     * @param $post_ids
     * @return mixed
     */
    public function bulk_handler($redirect_to, $action_name, $post_ids) {
        switch ($action_name) {
            case BACKTORY_BULK_ACTION_MOVE:
                backtory_files_transfer($post_ids);
                break;
            case BACKTORY_BULK_ACTION_REMOVE:
                backtory_files_remove($post_ids);
                break;
            case BACKTORY_BULK_ACTION_COPY:
                backtory_files_download($post_ids);
                break;
        }

        return $redirect_to;
    }

    /**
     * @param $id
     */
    public function delete_attachment($id) {
        backtory_file_remove($id);
    }


    /**
     * @param $path
     * @param $id
     * @return bool|string
     */
    public function attachment_url($path, $id) {
        $address = get_metadata('post', $id, BACKTORY_META);
        if (empty($address) || !isset($address[0])) {
            return $path;
        }

        if (empty(get_option(BACKTORY_BUCKET))) {
            initBacktory();

            return BacktoryStorage::url($address[0]);
        }

        return get_option(BACKTORY_DOMAIN) . str_replace(
                '//',
                '/',
                '/' . get_option(BACKTORY_BUCKET) . '/' . $address[0]
            );
    }

    /**
     * @return bool
     */
    public function srcset_image_status() {
        return false;
    }
}
