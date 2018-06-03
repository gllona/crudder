    <div>
        
    <div>
        <?= anchor('crudder/index', Crudderconfig::get_string('go_back_tables_list_link')); ?>
    </div>

    <!-- TITLE -->
    <div>
        <h3><?= Crudderconfig::get_string('table_text_title_part', false)?> <?= $table_display_name ?> <small>
            <?= $read_only == 1 ? 
            Crudderconfig::get_string('read_only_table_subtitle', false) : 
            Crudderconfig::get_string('editable_table_subtitle', false) ; 
            ?>
        </small></h3>
    </div>
    
    <!-- MODAL BOX FOR RECORD DELETE ALERT -->
    <div class="modal fade" id="delete_alert" tabindex="-1" role="dialog" aria-labelledby="Alerta" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= Crudderconfig::get_string('security_alert', false) ?></h4>
          </div>
          <div class="modal-body">
            <p><?= Crudderconfig::get_string('delete_record_question') ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><?= Crudderconfig::get_string('no_label') ?></button>
            <button type="button" onClick="location.href='/crudder/record_delete/<?= $id_table ?>/'+id_record" name="2n" id="2" class="btn btn-danger"><?= Crudderconfig::get_string('yes_label') ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <table class="table table-striped">

    <!-- HEADERS -->
    <tr>
        
    <?php
    echo form_open('crudder/table_show_post', 'role="form"');
    echo form_hidden('crudder_id_table', $id_table);
    echo form_hidden('crudder_sort_field_name', '');
    echo form_hidden('crudder_sort_order', '');
    echo form_hidden('crudder_pager_action', '0');

    echo "<tr>\n";
    foreach ($headers as $id => $tuple) {
        list ($name, $label, $hidden, $help) = $tuple;
        $label_length_px = 130 + 9 * strlen($label);
        echo "<th valign=\"bottom\"><table width=\"" . $label_length_px . "\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>\n";
        echo ( $help == '' ? '' : '<a href="#" id="crudder_header_' . $name . '" data-toggle="tooltip" title="' . $help . '"><span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;' . "\n" );
        echo $label . '&nbsp;&nbsp;<span class="glyphicon glyphicon-arrow-right"></span>&nbsp;&nbsp;' . "\n";
        $asc_action = "onClick=\"document.forms[0].crudder_sort_field_name.value='$name'; document.forms[0].crudder_sort_order.value='ASC' ; document.forms[0].submit();\"";
        $des_action = "onClick=\"document.forms[0].crudder_sort_field_name.value='$name'; document.forms[0].crudder_sort_order.value='DESC'; document.forms[0].submit();\"";
        echo ($sort_field_name == $name && $sort_order == 'ASC'  ? '<span class="glyphicon glyphicon-sort-by-alphabet"></span>'     : "<a href=\"#\" $asc_action >" . '<span class="glyphicon glyphicon-sort-by-alphabet"></span>'     . "</a>\n") . 
                                                          '&nbsp;<span class="glyphicon glyphicon-transfer"></span>&nbsp;' . "\n";
        echo ($sort_field_name == $name && $sort_order == 'DESC' ? '<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>' : "<a href=\"#\" $des_action >" . '<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>' . "</a>\n") ;
        echo "</td></tr></table></th>\n";
        echo "<script>$('#crudder_header_$name').tooltip();</script>\n\n";
    }
    ?>
        
    <th>
    <table width="140" border="0" cellpadding="0" cellspacing="0"><tr>
      <td>
        <a href="#" id="crudder_header_operations_help" data-toggle="tooltip" title="<?= Crudderconfig::get_string('operations_label_help') ?>"><span class="glyphicon glyphicon-question-sign"></a></span
            >&nbsp;&nbsp;<span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;&nbsp;
      <!--/td><td-->
        <div class="btn-group btn-group-xs">
          <button type="button" onclick="location.href='/crudder/record_insert/<?= $id_table ?>'" class="btn btn-primary" <?= $read_only == 1 ? 'disabled="disabled"' : '' ?> ><?= Crudderconfig::get_string('new_label') ?></button>
        </div>
      </td>
    </tr></table>
    <?= "<script>$('#crudder_header_operations_help').tooltip();</script>\n\n" ?>
    </th>

    </tr>
    
    <!-- FILTERS -->
    <?php
    echo "<tr>\n";
    foreach ($filters as $name => $pattern) {
        echo "<td>";
        ?>
        <div class="form-group">
          <label class="sr-only" for="crudder_filter_<?= $name ?>" ><?= Crudderconfig::get_string('filters_label') ?></label>
          <input type="text" class="form-control input-sm" name="crudder_filter_<?= $name ?>" value="<?= $pattern ?>" id="crudder_filter_<?= $name ?>" >
        </div>
        <?php
        echo "</td>\n";
    }
    ?>

    <td>
    <div class="form-group" style="padding-top: 4px">
      <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-xs">
          <button type="submit" name='crudder_do_filter'       class="btn btn-info"><?= Crudderconfig::get_string('filter_label') ?></button>
          <button type="submit" name='crudder_do_filter_reset' class="btn btn-warning"><?= Crudderconfig::get_string('erase_label') ?></button>
        </div>
      </div>
    </div>
    </td>

    </tr>
    
    <?php    
    echo form_close();
    ?>
        
    <!-- RECORDS -->
    <?php
    foreach ($records_htmls as $pair) {
        list ($id_record, $record_htmls) = $pair;
        echo "<tr>\n";
        foreach ($record_htmls as $html) {
            echo "<td>" . Crudderconfig::texter($html) . "</td>\n";
        }
        ?>
    
        <td>
        <div class="btn-toolbar" role="toolbar">
          <div class="btn-group btn-group-xs">
            <button type="button" onclick="location.href='/crudder/record_update/<?= $id_table ?>/<?= $id_record ?>'" class="btn btn-info" <?= $read_only == 1 ? 'disabled="disabled"' : '' ?> ><?= Crudderconfig::get_string('update_label') ?></button>
            <button type="button" onclick="id_record=<?= $id_record ?>; $('#delete_alert').modal('show');" class="btn btn-danger" <?= $read_only == 1 ? 'disabled="disabled"' : '' ?> ><?= Crudderconfig::get_string('delete_label') ?></button>
          </div>
        </div>
        </td>
        </tr>
            
        <?php
    }
    ?>
    </table>
    
    <!-- PAGINATOR -->
    <?php
        $pager_prev_action = $pager_is_first_page ? '' : 'onClick="document.forms[0].crudder_pager_action.value=\'-1\'; document.forms[0].submit();"';
        $pager_next_action = $pager_is_last_page  ? '' : 'onClick="document.forms[0].crudder_pager_action.value=\'+1\'; document.forms[0].submit();"';
    ?>
    <div>
    <ul class="pagination">
        <li><a href="#" <?= $pager_prev_action ?> <?= $pager_is_first_page ? 'class="disabled"' : '' ?> >&laquo;</a></li>
        <li class="disabled"><a href="#" ><?= Crudderconfig::get_string('pager_page_label') ?> <?= $pager_page_number ?> <?= Crudderconfig::get_string('pager_of_label') ?> <?= $pager_total_pages ?></a></li>
        <li><a href="#" <?= $pager_next_action ?> <?= $pager_is_last_page  ? 'class="disabled"' : '' ?> >&raquo;</a></li>
    </ul>        
    </div>

    <?= form_close() ?>
    </div>
