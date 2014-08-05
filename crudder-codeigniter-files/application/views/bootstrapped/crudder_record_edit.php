    <div>
        <?= anchor("crudder/tables_show"               , Crudderconfig::get_string('go_back_tables_list_link'  )); ?> <br/>
        <?= anchor("crudder/table_show/$id_first_table", Crudderconfig::get_string('go_back_table_content_link')); ?>
        <?= ! $secondary_insert ? '' : '<br/>' . ( $id_first_record == -1 ? 
            anchor("crudder/record_insert/$id_first_table"                 , Crudderconfig::get_string('go_back_register_insert_link')) :
            anchor("crudder/record_update/$id_first_table/$id_first_record", Crudderconfig::get_string('go_back_register_update_link')) );
        ?>
    </div>

    <!-- TITLE -->
    <div>
        <?php
        $prefix = substr($form_action, 0, 6) == 'insert' ? Crudderconfig::get_string('insert_label') : Crudderconfig::get_string('update_label');
        echo "<h3>$prefix " . Crudderconfig::get_string('edit_register_title_part') . " $table_display_name <small>" . Crudderconfig::get_string('edit_register_subtitle') . "</small></h3>\n";
        ?>
    </div>

    <div>

    <!-- VALIDATION INFO -->
    <div>
        <?php
        Crudder::get_instance()->validation_set_error_delimiters('<li>', '</li>');
        $errors = Crudder::get_instance()->validation_errors_build_snippet();
        if ($errors != '') {
            echo '<div class="alert alert-danger">';
            echo '' . $errors . '';
            echo "</div>\n";
        }
        ?>
    </div>

    <!-- FIELDS -->
    <!--table class="table table-striped"-->
    
    <?php
    $uri = "crudder/record_edit_$form_action";
    echo form_open($uri, 'class="form-horizontal" role="form"');
    echo form_hidden('crudder_id_table'  , $id_table);
    echo form_hidden('crudder_table_name', $table_name);
    echo form_hidden('crudder_id_record' , $id_record);
    echo form_hidden('crudder_action'    , $form_action);

    foreach ($headers as $id => $tuple) {
        list ($name, $label, $hidden, $help) = $tuple;
        list ($html, $extra_html) = $record_htmls[$name];
        if ($hidden || $name == 'id' && substr($form_action, 0, 6) == 'insert') {
            echo $html;
        } else {
        ?>
        
        <div class="form-group">
          <label for="<?= $name ?>" class="col-sm-4 control-label">
              <?php
                echo $label;
                echo $help == '' ? '' : '&nbsp;&nbsp;<a href="#" id="crudder_header_' . $name . '" data-toggle="tooltip" title="' . $help . '"><span class="glyphicon glyphicon-question-sign"></span></a>';
                echo "<script>$('#crudder_header_$name').tooltip();</script>";
              ?>
          </label>
          <div class="col-sm-8">
            <?= $html ?><?= $extra_html ?>
          </div>
        </div>
        
        <?php
        }
    }
    ?>
    
    <!--/table-->
    
    <!-- BUTTONS -->
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-primary"><?= $form_action == 'update' ? Crudderconfig::get_string('update_label') : Crudderconfig::get_string('insert_label') ?></button>
      </div>
    </div>

    <?= form_close() ?>
    </div>
