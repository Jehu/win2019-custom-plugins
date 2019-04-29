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
        <h1>Einstellungen</h1>
        <div style="border:2px solid #FFF; padding:5px;" >

            <form method="post" action="options.php">
                <?php
                settings_fields('einstellungen_gruppe');
                $config = get_option('win_config_options');
                ?>

                <label>Whitepaper Lead-Formular-ID: </label><br/>
                <input style="width:400px;" type="text" name="win_config_options[white_paper_formular_id]"
                       value="<?php echo (isset($config['white_paper_formular_id'])) ? $config['white_paper_formular_id'] : ""; ?>" />
                <br/>

                <label>JobWare Url: </label><br/>
                <input style="width:400px;" type="text" name="win_config_options[jobware_url]"
                       value="<?php echo (isset($config['jobware_url'])) ? $config['jobware_url'] : ""; ?>" />
                <br/>

                <p><input type="submit" class="button-primary" value="<?php _e('Save') ?>"/></p>

            </form>
        </div>
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

