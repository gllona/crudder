    <div>
        
    <div>
        <?= anchor('crudder/index', 'Volver al listado de tablas'); ?>
    </div>

    <!-- TITLE -->
    <div>
        <h3>Tabla: <?= $table_display_name ?></h3>
    </div>
    <div>
        <p><?= anchor("crudder/record_insert/$id_table", 'Insertar nuevo registro'); ?></p>
    </div>
    
    <table border="1">

    <!-- HEADERS -->
    <?php
    echo form_open('crudder/table_show_post');
    echo form_hidden('crudder_id_table', $id_table);
    echo form_hidden('crudder_sort_field_name', '');
    echo form_hidden('crudder_sort_order', '');
    echo form_hidden('crudder_pager_action', '0');

    echo "<tr>\n";
    foreach ($headers as $id => $pair) {
        list ($name, $label) = $pair;
        echo "<th>$label | ";
        $asc_action = "onClick=\"document.forms[0].crudder_sort_field_name.value='$name'; document.forms[0].crudder_sort_order.value='ASC' ; document.forms[0].submit();\"";
        $des_action = "onClick=\"document.forms[0].crudder_sort_field_name.value='$name'; document.forms[0].crudder_sort_order.value='DESC'; document.forms[0].submit();\"";
        echo ($sort_field_name == $name && $sort_order == 'ASC'  ? "v" : "<a href=\"#\" $asc_action >v</a>") . " | ";
        echo ($sort_field_name == $name && $sort_order == 'DESC' ? "^" : "<a href=\"#\" $des_action >^</a>");
        echo "</th>\n";
        
    }
    echo "<th>Operaciones</th>\n";
    echo "</tr>\n";
    ?>
        
    <!-- FILTERS -->
    <?php
    echo "<tr>\n";
    foreach ($filters as $name => $pattern) {
        echo "<td>";
        echo form_input("crudder_filter_$name", $pattern);
        echo "</td>\n";
        //echo "<td><input type=\"text\" name=\"filter_$name\" value=\"$pattern\" /></td>\n";
    }
    echo "<td>" . form_submit('crudder_do_filter', 'Filtrar');
    echo          form_submit('crudder_do_filter_reset', 'Borrar') . "</td>\n";
    echo "</tr>\n";

    echo form_close();
    ?>
        
    <!-- RECORDS -->
    <?php
    foreach ($records_htmls as $pair) {
        list ($id_record, $record_htmls) = $pair;
        echo "<tr>\n";
        foreach ($record_htmls as $html) {
            echo "<td>$html</td>\n";
        }
        echo '<td>' . anchor("crudder/record_update/$id_table/$id_record", 'Actualizar' ) . ' | ';
        echo          anchor("crudder/record_delete/$id_table/$id_record", 'Eliminar' ) . "</td>\n";
        echo "</tr>\n";
    }
    ?>
    </table>
    
    <!-- PAGINATOR -->
    <?php
        $pager_prev_action = $pager_is_first_page ? '' : 'onClick="document.forms[0].crudder_pager_action.value=\'-1\'; document.forms[0].submit();"';
        $pager_next_action = $pager_is_last_page  ? '' : 'onClick="document.forms[0].crudder_pager_action.value=\'+1\'; document.forms[0].submit();"';
    ?>
    <div>
    <ul class="pager">
        <li><a href="#" <?= $pager_prev_action ?> <?= $pager_is_first_page ? 'class="disabled"' : '' ?> >&Lt;</a></li>
        <li><a href="#" <?= $pager_next_action ?> <?= $pager_is_last_page  ? 'class="disabled"' : '' ?> >&Gt;</a></li>
    </ul>
    <p>Mostrando página <?= $pager_page_number ?> de <?= $pager_total_pages ?></p>
    </div>

    <?= form_close() ?>
    </div>
