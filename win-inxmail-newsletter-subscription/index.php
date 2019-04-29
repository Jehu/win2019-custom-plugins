<?php
/*
Plugin Name: WIN: Inxmail-Anmeldung
Description: Mit diesem Plugin kann ein Newsletter-Anmeldeformular an eine einstellbare Inxmail-Liste erstellt und das Formular als Widget oder per Shortcode in die Website integriert werden.
Author: <a href="http://www.cvh-design.de/">CvH Design GmbH &amp; Co. KG.</a>
Version: 1.2
*/

add_action('admin_menu', 'inxmail_register');
function inxmail_register()
{
    add_menu_page('newsletter', 'Inxmail', 'edit_posts', 'newsletter', 'inxmail_ausgabe', 'dashicons-email-alt', 37);
    add_submenu_page('newsletter', 'Dashboard', 'Dashboard', 'edit_posts', 'newsletter', 'inxmail_ausgabe');
    add_submenu_page('newsletter', 'Einstellungen', 'Einstellungen', 'edit_posts', 'einstellungen', 'einstellungen');
}


function inxmail_ausgabe()
{ ?>
    <div class="wrap">
        <?php //Inxmail-Logo

        echo "<img src='" . plugins_url('img/inxmail.png', __FILE__) . "' alt='Inxmail'/>";
        ?>
        <h1>Newsletter-Anmeldung an Inxmail</h1>
        <p>Mit diesem Plugin ist es m&ouml;glich, ein Formular f&uuml;r eine Newsletter-Anmeldung an Inxmail zu
            erstellen und dieses per Shortcode in die Website zu integrieren. Au&szlig;erdem steht ein
            Schnell-Anmeldeformular (nur E-Mail-Adresse) als Widget zur Verf&uuml;gung.</p>
        <p>F&uuml;r ein umfangreicheres Formular (mit mehreren Feldern) sind folgende Schritte erforderlich:</p>
        <h3><strong>1. Verbindung zu Inxmail herstellen</strong></h3>
        <p>Unter dem Men&uuml;punkt Einstellungen muss hinterlegt werden, an welche Liste auf welchem Server die
            Anmeldung erfolgen soll, sowie das verwendete Charset und die Seiten zur Anmeldebestauml;tigung und
            Fehlermeldung.</p>
        <h3><strong>2. Erstellung eines Formulares</strong></h3>
        <p>Unter dem Punkt Formular kann das Formular mit den jeweiligen Feldern angelegt werden. Aktuell ist nur ein
            Formular m&ouml;glich.</p>
        <h3><strong>3. Einbindung des Formulares in die Website</strong></h3>
        <p>Zuletzt kann das Formular per Shortcode in die Website eingebunden werden:<br/>
            [newsletter] & [newsletter_complete_form] </p>
        <p>Der Shortcode kann sowohl in Seiten / Beitr&auml;ge oder anderen Inhaltstypen verwendet werden, als auch in
            Textwidgets.</p>
        <br/>
    </div>
    <?php
}

function anmelde_formular()
{ ?>
    <div class="wrap">
        <?php //Inxmail-Logo
        echo "<img src='" . plugins_url('img/inxmail.png', __FILE__) . "' alt='Inxmail'/>";
        ?>
        <h1>Newsletter-Anmelde-Formular bearbeiten</h1>
        <p>Erstellen Sie Ihr Formular per Klick auf die Buttons f&uuml;r Standard-Felder. Bitte beachten Sie, dass der
            Name des Feldes in Ihrer Inxmail-Liste mit dem Wert in name="..." &uuml;bereinstimmen muss, damit der Wert
            in die Inxmail-Datenbank geschrieben werden kann.</p>
        <p>Eine manuelle Erweiterung um eigene Felder kann direkt in dem Eingabefeld f&uuml;r den HTML-Code
            erfolgen.</p>
        <p>Die Formatierung kann direkt &uuml;ber CSS in Ihrer eigenen CSS-Datei erfolgen.
        </p>
        <br/>
        <form method="post" action="options.php">
            <?php
            settings_fields('newsletter_gruppe');
            $options = get_option('newsletter_optionen');
            $einstellungen = get_option('einstellungen_optionen');
            ?>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"email\">E-Mail:*</label>\n<input id=\"email\" type=\"text\" name=\"email\" /></p>\n"'>E-Mail</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"titel\">Titel:</label>\n<input id=\"titel\" type=\"text\" name=\"titel\" /></p>\n"'>Titel</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"anrede\">Anrede:</label>\n<input id=\"anrede\" type=\"text\" name=\"anrede\" /></p>\n"'>Anrede</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"vorname\">Vorname:</label>\n<input id=\"vorname\" type=\"text\" name=\"vorname\" /></p>\n"'>Vorname</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"nachname\">Nachname:</label>\n<input id=\"nachname\" type=\"text\" name=\"nachname\" /></p>\n"'>Nachname</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"strasse\">Stra&szlig;e:</label>\n<input id=\"strasse\" type=\"text\" name=\"strasse\" /></p>\n"'>Stra&szlig;e</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"plz\">PLZ:</label>\n<input id=\"plz\" type=\"text\" name=\"plz\" /></p>\n"'>PLZ</a>
            <a class="button form-element"
               onClick='document.getElementById("formularfeld").value += "\n<p><label for=\"ort\">Ort:</label>\n<input id=\"ort\" type=\"text\" name=\"ort\" /></p>\n"'>Ort</a><br/>
            <textarea name="newsletter_optionen[inhalt]" id="formularfeld"
                      style="width:80%; height:250px"><?php echo esc_textarea($options['inhalt']); ?></textarea>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save') ?>"/>
            </p>
        </form>

        <h3>Vorschau (ohne CSS):</h3>
        <div id="vorschau" style="width:80%; height:auto; border:1px solid #ccc; padding:15px;"></div>
        <script>
            updatePreview();
            jQuery('.form-element').click(function () {
                updatePreview();
            });
            jQuery('#formularfeld').keyup(function () {
                updatePreview();
            });
            jQuery('#formularfeld').change(function () {
                updatePreview();
            });

            function updatePreview() {
                jQuery('#vorschau').html(jQuery('#formularfeld').val());
            }
        </script>
    </div>
    <?php
}

function newsletter_init()
{
    register_setting('newsletter_gruppe', 'newsletter_optionen', 'newsletter_validate');
}

function newsletter_validate($input)
{
    return $input;
}

add_action('admin_init', 'newsletter_init');

function einstellungen()
{ ?>
    <div class="wrap">
        <?php //Inxmail-Logo
        echo "<img src='" . plugins_url('img/inxmail.png', __FILE__) . "' alt='Inxmail'/>";
        ?>

        <!-- Login -->
        <h1>Einstellungen</h1>
        <h2>Optional: Inxmail-Verbindung per API</h2>
        <div style="border:2px solid #FFF; padding:5px;">
            <div style="margin-top:20px;" id="loginmaske">
                <p>Wenn Sie einen API-Benutzer bei Inxmail haben, k&ouml;nnen Sie hier Ihre Zugangsdaten hinterlegen.
                    Damit ist es m&ouml;glich, bei den Listeneinstellungen den Namen der Liste auszuw&auml;hlen, statt
                    ihn einzugeben.<br/>
                    Damit Sie diese Funktion nutzen k&ouml;nnen, müssen Sie die API(Schnittstelle) in das Plugin
                    integrieren (inxmail-anmeldung\inxmail\inxmail_api\). Sie können die API direkt bei Inxmail
                    anfragen.</p>
                <form method="post" action="">
                    <table>
                        <tr>
                            <td><label>Server: </label></td>
                            <td><input style="width:400px;" type="text" name="server"
                                       placeholder="http://login.inxmail.de/mandant"/><br/></td>
                        </tr>
                        <tr>
                            <td><label for="benutzer">Benutzer:</label></td>
                            <td><input style="width:400px;" type="text" name="benutzer"
                                       placeholder="[API-Benutzer]"/><br/></td>
                        </tr>
                        <tr>
                            <td><label for="passwort">Passwort:</label></td>
                            <td><input style="width:400px;" type="password" name="passwort"
                                       placeholder="[Passwort]"/><br/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="button-primary" name="Login" value="Listen abrufen"/></td>
                        <tr>
                    </table>
                </form>
            </div>
            <!-- Login Ende-->
        </div>

        <h2>Inxmail-Liste</h2>
        <div style="border:2px solid #FFF; padding:5px;" id="einstellungen">
            <p>W&auml;hlen Sie die Liste aus, wenn Sie oben Ihre API-Verbindung aufgebaut haben, oder tragen Sie den
                Listennamen von Hand ein.<br/>
                Au&szlig;erdem muss jeweils eine vollst&auml;ndige URL angegeben werden, welche Seite nach erfolgreicher
                Anmeldung bzw. nach fehlerhafter Anmeldung aufgerufen werden soll.</p>
            <script type="text/javascript">
                function hinzufuegen() {
                    liste = document.getElementById("liste").value;
                    document.getElementById("listenname").value = liste;
                }
            </script>

            <?php
            if (isset($_POST['Login']) && $_POST['Login'] == 'Listen abrufen') {

                require_once 'inxmail/inxmail_api/Apiimpl/Loader.php';
                Inx_Apiimpl_Loader::registerAutoload();

                $server = $_POST['server'];
                $benutzer = $_POST['benutzer'];
                $passwort = $_POST['passwort'];

                $inx_server = $server;
                $inx_user = $benutzer;
                $inx_pass = $passwort;
                $error = false;

                try {
                    $oSession = Inx_Api_Session::createRemoteSession(
                        $inx_server, $inx_user, $inx_pass);
                } catch (Inx_Api_LoginException $x) {
                    echo '<div style="width:auto; height:auto; padding:5px; border:1px solid #000000;" ><p>Liste konnte nicht abgerufen werden, der Benutzername oder das Passwort ist falsch.</p></div><br />';
                    $error = true;
                } catch (Exception $x) {
                    echo '<div style="width:auto; height:auto; padding:5px; border:1px solid #000000;" ><p>Liste konnte nicht abgerufen werden, bitte korrigieren Sie die Eingabe.</p></div><br />';
                    $error = true;
                }

                if ($error == false) {
                    $session = Inx_Api_Session::createRemoteSession(
                        $inx_server, $inx_user,
                        $inx_pass, true);
                }
                if ($session == true && $error == false) {

                    $listContextManager = $oSession->getListContextManager();
                    $oBOResultSet = $listContextManager->selectAll();
                    echo 'Liste ausw&auml;hlen: ';
                    echo '<form> 
			<select onChange="hinzufuegen()" name="liste" id="liste" style="font-size:13px;">';
                    echo '<option selected="selected" disabled="disabled">Liste ausw&auml;hlen*</option>';
                    for ($i = 0; $i < $oBOResultSet->size(); ++$i) {
                        $l = $oBOResultSet->get($i);
                        echo '<option value="' . ($l->getName()) . '">' . $l->getName() . '</option>';
                    }
                    echo '</select>		
			</form> <br />';
                    $oBOResultSet->close();

                    $oSession->close();
                }


            }
            ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('einstellungen_gruppe');

                $einstellungen = get_option('einstellungen_optionen');
                if (is_string($einstellungen ) && empty($einstellungen))
                    $einstellungen = [];

                if (empty($einstellungen['charset'])) {
                    $einstellungen['charset'] = "UTF-8";
                }

                if (isset($_POST['Login']) && $_POST['Login'] == 'Listen abrufen') {
                    $einstellungen['server'] = sanitize_text_field($server);
                }
                ?>
                <style type="text/css">
                    input.disabled, input:disabled, select.disabled, select:disabled, textarea.disabled, textarea:disabled {
                        color: rgba(0, 0, 0, 1);
                    }
                </style>

                <label>Server: </label><br/>
                <input style="width:400px;" type="text" name="einstellungen_optionen[server]"
                       value="<?php echo (isset($einstellungen['server'])) ? esc_url($einstellungen['server']) : ""; ?>"
                       placeholder="http://login.inxmail.de/mandant"/><br/>

                <label>Listenname:</label><br/>
                <input style="width:400px;" type="text" id="listenname" name="einstellungen_optionen[listennamen]"
                       value="<?php echo (isset($einstellungen['listennamen'])) ? $einstellungen['listennamen'] : ""; ?>" placeholder="Listenname"/><br/>

                <label>Vollständiges Formular (URL):</label><br/>
                <input style="width:400px;" type="text" name="einstellungen_optionen[complete_form_url]"
                       value="<?php echo (isset($einstellungen['complete_form_url'])) ? esc_url($einstellungen['complete_form_url']) : ""; ?>"
                       placeholder="http://.../formular.html"/><br/>

                <label>Anmeldung erfolgreich (URL):</label><br/>
                <input style="width:400px;" type="text" name="einstellungen_optionen[success]"
                       value="<?php echo (isset($einstellungen['success'])) ? esc_url($einstellungen['success']) : ""; ?>"
                       placeholder="http://.../erfolgreich.html"/><br/>

                <label>Anmeldung fehlerhaft (URL):</label><br/>
                <input style="width:400px;" type="text" name="einstellungen_optionen[error]"
                       value="<?php echo (isset($einstellungen['error'])) ? esc_url($einstellungen['error']) : ""; ?>"
                       placeholder="http://.../error.html"/><br/>

                <label>Charset:</label><br/>
                <input type="text" name="einstellungen_optionen[charset]"
                       value="<?php echo $einstellungen['charset']; ?>" placeholder="UTF-8"/><br/>

                <p><input type="submit" class="button-primary" value="<?php _e('Save') ?>"/></p>

            </form>
        </div>

    </div>
    <?php
}

function einstellungen_init()
{
    register_setting('einstellungen_gruppe', 'einstellungen_optionen', 'einstellungen_validate');
}

function einstellungen_validate($input)
{
    return $input;
}

add_action('admin_init', 'einstellungen_init');

function has_valid_settings($einstellungen) {

    if (empty($einstellungen['charset']) ||
        empty($einstellungen['listennamen']) ||
        empty($einstellungen['server']) ||
        empty($einstellungen['success']) ||
        empty($einstellungen['error'])
    ) {
        return false;
    }
    return true;
}

function newsletter_complete_form()
{

    $email_value =  !empty($_REQUEST['email']) ?  $_REQUEST['email'] : '';
    $einstellungen = get_option('einstellungen_optionen');

    if (!has_valid_settings($einstellungen )) {
        return '<b style="color:#844;">Please Configure the <a href="' . get_admin_url() . '/admin.php?page=einstellungen" target=”_blank">inxmail plugin settings!</a></b>';
    }

    return '<form action="' . esc_url($einstellungen['server']) . '/subscription/servlet" method="post" class="newsletter_complete_form"> 
    <style>
    .newsletter_complete_form > div {
        width:100%;
    } 
    
    .newsletter_complete_form p {
        width:45%;   
        display:inline-block;
    }
    
    .newsletter_complete_form p input, .newsletter_complete_form p select{
        width:100%;
        padding-right:15px;
    }

    .newsletter_complete_form p label {
        display: block;
         
    }
    </style>
    
    <div>
        <p>
            <label for="email">E-Mail:*</label>
            <input id="email" type="text" name="email" value="' . $email_value   . '"/>
        </p>

        <p>
            <label for="anrede">Anrede:</label>
            <select name="anrede">
                <option value="Herr">Herr</option>
                <option value="Frau">Frau</option>
            </select>
        </p>

        <p>
            <label for="nachname">Name:</label>
            <input id="nachname" type="text" name="nachname" />
        </p>
        <p>
            <label for="vorname">Vorname:</label>
            <input id="vorname" type="text" name="vorname" />
        </p>

        <p>
            <label for="firma">Firma:</label>
            <input id="firma" type="text" name="firma" />
        </p>

        <p>
            <label for="funktion">Funktion:</label>
            <input id="funktion" type="text" name="funktion" />
        </p>
        <p>
            <label for="branche">Branche:</label>
            <input id="branche" type="text" name="branche" />
        </p>

        <p>
            <label for="anrede">Mitarbeiteranzahl:</label>
            <select name="anrede">
                <option value="">--</option>
                <option value="1-49">1-49</option>
                <option value="50-249">50-249</option>
                <option value="250-999">250-999</option>
                <option value="1000-4999">1000-4999</option>
                <option value="5000+">5000 und mehr</option>
            </select>
        </p>
        
        <input type="submit" value="Anmelden" />

        <input type="hidden" name="INXMAIL_SUBSCRIPTION" value="' . $einstellungen['listennamen']. '"> 
        <input type="hidden" name="INXMAIL_HTTP_REDIRECT" value="' . esc_url($einstellungen['success']) . '">
		<input type="hidden" name="INXMAIL_HTTP_REDIRECT_ERROR" value="' . esc_url($einstellungen['error']) . '">
		<input type="hidden" name="INXMAIL_CHARSET" value="' . $einstellungen['charset']. '"></form>
    </div>
</form>';

}

add_shortcode('newsletter_complete_form','newsletter_complete_form');

function newsletter_function()
{

    $einstellungen = get_option('einstellungen_optionen');

    return '
        <form action="' . esc_url($einstellungen['complete_form_url']) . '" method="get">
            <input type="text" name="email">
            <input type="submit" value="Anmelden" />
        </form>
';
}

add_shortcode('newsletter', 'newsletter_function');

