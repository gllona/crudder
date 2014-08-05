    <div>
        
    <!-- TITLE -->
    <div>
        <h3>Tablas del sistema</h3>
    </div>
        
    <!-- HEADER -->
    <table border="1">
    <tr>
        <!--th>ID</th-->
        <th>Nombre</th>
        <th>¿Metatabla?</th>
        <th>Operaciones</th>
    </tr>

    <!-- TABLES LIST -->
    <?php
    foreach ($tables as $table)
    {
        ?>
        <tr>
        <!--td><?= $table['id'] ?></td-->
        <td><?= $table['display_name'] ?></td>
        <td><?= $table['is_metatable'] == 1 ? 'Sí' : 'No' ?></td>
        <td><?= $table['with_edit'] == 1 ? anchor('crudder/table_show/' . $table['id'], 'Mostrar' ) : '' ?></td>
        </tr>
        <?php
    }
    ?>
    </table>

    </div>
