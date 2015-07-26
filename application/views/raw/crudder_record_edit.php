    <div>
        <p><?= anchor("crudder/tables_show", 'Volver al listado de tablas'); ?></p>
        <p><?= anchor("crudder/table_show/$id_first_table", 'Volver al contenido de la tabla'); ?></p>
        <?= ! $secondary_insert ? '' : ( $id_first_record == -1 ? '<p>' .
            anchor("crudder/record_insert/$id_first_table"                 , 'Regresar a insertar el registro') :
            anchor("crudder/record_update/$id_first_table/$id_first_record", 'Regresar a actualizar el registro') . '</p>');
        ?>
    </div>

    <!-- TITLE -->
    <div>
        <?php
        $prefix = substr($form_action, 0, 6) == 'insert' ? "Insertar" : "Actualizar";
        echo "<h3>$prefix registro en tabla: $table_display_name</h3>\n";
        ?>
    </div>

    <div>

    <!-- VALIDATION INFO -->
    <div>
        <?php
        Crudder::get_instance()->validation_set_error_delimiters('<li>', '</li>');
        $errors = Crudder::get_instance()->validation_errors_build_snippet();
        if ($errors != '') {
            echo '<p>';
            echo '' . $errors . '';
            echo "</p>\n";
        }
        ?>
    </div>

    <!-- FIELDS -->
    <table border="1">
    <?php
    $uri = "crudder/record_edit_$form_action";
    echo form_open($uri);
    echo form_hidden('crudder_id_table'  , $id_table);
    echo form_hidden('crudder_table_name', $table_name);
    echo form_hidden('crudder_id_record' , $id_record);
    echo form_hidden('crudder_action'    , $form_action);

    foreach ($headers as $id => $tuple) {
        list ($name, $label, $hidden, $help) = $tuple;
        list ($html, $extra_html) = $record_htmls[$name];
        if ($hidden || $name == 'id' && substr($form_action, 0, 6) == 'insert') {
            echo $html;
            continue;
        }
        echo "<tr>\n";
        echo "<th>$label</th>\n";
        echo "<td>$html$extra_html</td>\n";
        echo "</tr>\n";
    }
    ?>
    </table>
    
    <!-- BUTTONS -->
    <div>
        <p>
        <?php
        $label = $form_action == 'update' ? 'Actualizar' : 'Insertar';
        echo form_submit($form_action, $label);
        ?>
        </p>
    </div>

    <?= form_close() ?>
    </div>
