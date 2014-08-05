<div>
    
    <div>
        <h1>This is the set of views from the RAW Mainapp subdirectory</h1>
        <h4>When entering the Crudder you will see either the raw views or the Bootstrapped views, according to the Crudderconfig DEFAULT_PAGES_SET constant.</h4>
        <h4>This means that your application (including the Crudder) could be a mix of GUI styles. For example, you could create a new subdirectory for views, and the Mainpp views will be loaded from there, without interfering with the style of the Crudder (provided that the PAGES_SET constant in the Mainapp controller is properly set).</h4>
        <h4>Remember that the Mainapp application is not localized. However, when entering the Crudder, you will see the language localized pages.</h4>
        <hr>
        <p><b>Bienvenido al m&oacute;dulo de administraci&oacute;n de localidades de Venezuela</b></p>
        <hr>
    </div>
    
    <div>
        <?php
        if (isset($result))
            echo '<i>' . urldecode($result) . '</i>';
        ?>
    </div>
    
    <div>
        <p><b>Introduzca sus credenciales de acceso:</b></p>
    </div>
    
    <?php
    echo form_open('mainapp/login_verify');
    ?>

    <table border="1">
        <tr><td>Usuario</td><td><?= form_input('user', $user, "size='40'"); ?><br>
                <small>( SuperAdminVzla / AdminVzla / RegularVzla ) ( RegularVzla has no privileges to enter the system )</small></td></tr>
        <tr><td>Contrase&ntilde;a</td><td><?= form_password('password', ''); ?><br>
                <small>( pass )</small></td></tr>
    </table>
    <br>

    <?php
    echo form_submit('submit', 'Entrar');
    echo form_close();
    ?>
    
</div>
