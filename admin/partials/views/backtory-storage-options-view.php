<form action="options.php" method="post">
    <?php settings_fields("backtory_storage"); ?>
    <div>
        <h2>Backtory Storage Plugin</h2>
        <p>please fill fields</p>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_ENABLED ?>"><?php echo __("Enable Service") ?></label>
                </th>
                <td>
                    <input type="checkbox" id="<?php echo BACKTORY_ENABLED ?>"
                           name="<?php echo BACKTORY_ENABLED ?>"
                           value="1" <?php echo (get_option(BACKTORY_ENABLED) == 1) ? 'checked' : ''; ?>/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_REMOVE_AFTER_TRANSFER ?>">Remove files after upload</label>
                </th>
                <td>
                    <input type="checkbox" id="<?php echo BACKTORY_REMOVE_AFTER_TRANSFER ?>"
                           name="<?php echo BACKTORY_REMOVE_AFTER_TRANSFER ?>"
                           value="1" <?php echo (get_option(BACKTORY_REMOVE_AFTER_TRANSFER) == 1) ? 'checked' : ''; ?>/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo X_BACKTORY_AUTHENTICATION_ID ?>">X-Backtory-Authentication-Id</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo X_BACKTORY_AUTHENTICATION_ID ?>"
                           name="<?php echo X_BACKTORY_AUTHENTICATION_ID ?>"
                           value="<?php echo get_option(X_BACKTORY_AUTHENTICATION_ID); ?>" dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo X_BACKTORY_AUTHENTICATION_KEY ?>">X-Backtory-Authentication-Key</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo X_BACKTORY_AUTHENTICATION_KEY ?>"
                           name="<?php echo X_BACKTORY_AUTHENTICATION_KEY ?>"
                           value="<?php echo get_option(X_BACKTORY_AUTHENTICATION_KEY); ?>" dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo X_BACKTORY_OBJECT_STORAGE_ID ?>">X-Backtory-Object-Storage-Id</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo X_BACKTORY_OBJECT_STORAGE_ID ?>"
                           name="<?php echo X_BACKTORY_OBJECT_STORAGE_ID ?>"
                           value="<?php echo get_option(X_BACKTORY_OBJECT_STORAGE_ID); ?>" dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_DOMAIN ?>">Upload URL (Domain)</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo BACKTORY_DOMAIN ?>"
                           name="<?php echo BACKTORY_DOMAIN ?>"
                           value="<?php echo get_option(BACKTORY_DOMAIN); ?>" dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_BUCKET ?>">Bucket Name</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo BACKTORY_BUCKET ?>"
                           name="<?php echo BACKTORY_BUCKET ?>"
                           value="<?php echo get_option(BACKTORY_BUCKET); ?>"
                           dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_UPLOAD_PATH ?>">Backtory Upload Path</label>
                </th>
                <td>
                    <input class="regular-text" type="text" id="<?php echo BACKTORY_UPLOAD_PATH ?>"
                           name="<?php echo BACKTORY_UPLOAD_PATH ?>"
                           value="<?php echo get_option(BACKTORY_UPLOAD_PATH); ?>" dir="ltr"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo BACKTORY_WHITE_LIST_EXTENSIONS ?>">Backtory white list extensions</label>
                </th>
                <td>
                    <input class="regular-text" id="<?php echo BACKTORY_WHITE_LIST_EXTENSIONS ?>"
                           name="<?php echo BACKTORY_WHITE_LIST_EXTENSIONS ?>"
                           value="<?php echo get_option(BACKTORY_WHITE_LIST_EXTENSIONS); ?>"
                           placeholder="example: mp3,mp4,avi" dir="ltr"/>
                </td>
            </tr>
            <tr>
                <td><a href="<?php echo admin_url("?backtory_action=moveAll") ?>" class="button button-hero">Copy files
                        to backtory</td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </div>
</form>