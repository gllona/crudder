<div>
    
    <div>
        <p><b>M&oacute;dulo de administraci&oacute;n de localidades de Venezuela</b><br>
           Lista de usuarios</p>
    </div>
    
    <div>
        <table width="100%" border="1"><tr><td>
        <p><b><?= Mainapp::my_anchor('goto_crudder', 'Activar el Crudder para editar Localidades y Usuarios') ?></b></p>
        <p>Las opciones que aparecen debajo de esta línea no forman parte del Crudder.<br>
           Son opciones provistas por la aplicación principal (mainapp), que tiene a su cargo la función de editar usuarios, pero esto también se puede realizar por medio del Crudder.
        </p>
        </td></tr></table>
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
        <p><?= Mainapp::my_anchor('user_generate', 'Crear un nuevo usuario') ?></p>
    </div>
    
    <table border="1">
    <tr>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Acción</th>
    </tr>
    
    <?php
    foreach ($users as $user)
    {
        ?>
        <tr>
        <td><?= Mainapp::my_anchor('user_show/' . $user['user_name'], $user['user_name']) ?>
        <td><?= $user['role']; ?></td>
        <td><?= Mainapp::my_anchor('user_delete/' . $user['user_name'], 'Eliminar') ?>
        </tr>
        
        <?php
    }
    ?>
    </table>
    
</div>

