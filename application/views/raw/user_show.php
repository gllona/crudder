<div>
    
    <div>
        <p><b>M&oacute;dulo de administraci&oacute;n de localidades de Venezuela</b><br>
           <?= ($user_name === '' ? 'Crear' : 'Actualizar') ?> un usuario</p>
        <hr>
    </div>
    
    <div>
        <?php
        if (isset($result))
            echo '<i>' . urldecode($result) . '</i>';
        ?>
    </div>
    
    <div>
        <p><?= Mainapp::my_anchor('logout', 'Salir del sistema') ?></p>
    </div>

    <div>
        <p><?= Mainapp::my_anchor('users_list', 'Regresar a la lista de usuarios') ?></p>
    </div>

    <?php
    echo form_open('mainapp/user_' . ($user_name === '' ? 'insert' : 'update'));
    echo form_hidden('user_name_old', $user_name)
    ?>
    
    <table border="1">
    <tr><td>Nombre (login)</td><td><?= form_input('user_name_edit', $user_name); ?></td></tr>
    <tr><td>Rol</td><td><?= form_dropdown('role_edit', array('superadmin' => 'SuperAdministrador', 'admin' => 'Administrador', 'regular' => 'Regular'), $role); ?></td></tr>
    <tr><td>Contrase&ntilde;a</td><td><?= form_password('password_edit'); ?></td></tr>
    </table>
    <br>
    
    <?php
    echo form_submit('submit', 'Guardar');
    echo form_close();
    ?>
    
</div>

