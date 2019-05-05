<?php
/*
Plugin Name: WIN: Config
Description: Adds configurations optins to a wordpress backend
Version: 1.0
*/

add_action('admin_menu', 'win_config_register');

function win_config_register()
{
    add_menu_page(
        'win-config',
        'WIN Config',
        'edit_posts',
        'win-config',
        'win_config',
        'dashicons-admin-settings',
        37);


}

function win_config()
{
    //var_dump(get_option('win_config_options')['white_paper_formular_id']);
    ?>
    <div class="wrap">
        <style>
            fieldset {
                border:2px solid #FFF;
                padding:5px;
                margin-bottom: 15px;
            }
            fieldset legend {
                font-weight: bold;
            }
            input[type=text] {
                width: 300px;
            }
            label {
                display: block;
            }
        </style>
        <h1>Einstellungen</h1>
        <form method="post" action="options.php">
            <fieldset>
                <?php
                settings_fields('einstellungen_gruppe');
                $config = get_option('win_config_options');
                ?>

                <label>Whitepaper Lead-Formular-ID: </label>
                <input type="text" name="win_config_options[white_paper_formular_id]"
                       value="<?php echo (isset($config['white_paper_formular_id'])) ? $config['white_paper_formular_id'] : ""; ?>" />
                <br/>

                <label>JobWare Url: </label>
                <input type="text" name="win_config_options[jobware_url]"
                       value="<?php echo (isset($config['jobware_url'])) ? $config['jobware_url'] : ""; ?>" />
                <br/>


            </fieldset>
            <fieldset>
                <legend><?php echo __('Inxmail Settings') ?></legend>

                <label><?php echo __('Login URL') ?></label>
                <input type="text" name="win_config_options[inxmail_login_url]"
                value="<?php echo (isset($config['inxmail_login_url'])) ? $config['inxmail_login_url'] : '' ?>" />

                <label><?php echo __('Submit URL') ?></label>
                <input type="text" name="win_config_options[inxmail_submit_url]"
                       value="<?php echo (isset($config['inxmail_submit_url'])) ? $config['inxmail_submit_url'] : '' ?>" />

            </fieldset>
            <p><input type="submit" class="button-primary" value="<?php _e('Save') ?>"/></p>
        </form>
    </div>
<?php
}

function win_config_init()
{
    register_setting('einstellungen_gruppe', 'win_config_options', 'win_config_validate');
}

function win_config_validate($input)
{

    return $input;
}

add_action('admin_init', 'win_config_init');


// change action url of contact form

add_filter('wpcf7_form_action_url', 'wpcf7_custom_form_action_url');

function wpcf7_custom_form_action_url($url)
{
    global $post;

    if ($post->post_name === 'redaktionsbrief') {

        return get_option('win_config_options')['inxmail_submit_url'];

    } else {

        return $url;
    }
}

add_action('wp_enqueue_scripts', 'dc_wpcf7_addon');

function dc_wpcf7_addon($hook) {
    $my_js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/form.js' ));
    wp_enqueue_script( 'form_js', plugins_url( 'js/form.js', __FILE__ ), array("jquery","contact-form-7"), $my_js_ver );
}