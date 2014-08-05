    <div>
        
    <!-- TITLE -->
    <div>
        <h3><?= Crudderconfig::get_string('system_tables_title') ?> <small><?= Crudderconfig::get_string('select_operation_tables_subtitle') ?></small></h3>
    </div>

    <!-- HEADER -->
    <table class="table table-striped">
    <tr>
        <th><a href="#" id="crudder_header_id" data-toggle="tooltip" title="<?= Crudderconfig::get_string('table_id_descriptor') ?>"><span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<?= Crudderconfig::get_string('id_label') ?></th>
        <th><a href="#" id="crudder_header_display_name" data-toggle="tooltip" title="<?= Crudderconfig::get_string('table_displayname_descriptor') ?>"><span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<?= Crudderconfig::get_string('displayname_label') ?></th>
        <th><a href="#" id="crudder_header_is_metatable" data-toggle="tooltip" title="<?= Crudderconfig::get_string('table_metatable_descriptor') ?>"><span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<?= Crudderconfig::get_string('metatable_label') ?></th>
        <th><a href="#" id="crudder_header_help_text" data-toggle="tooltip" title="<?= Crudderconfig::get_string('table_helptext_descriptor') ?>"><span class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<?= Crudderconfig::get_string('helptext_label') ?></th>
        <th><?= Crudderconfig::get_string('operations_label') ?> &nbsp;&nbsp;<span class="glyphicon glyphicon-cog"></span></th>
    </tr>

    <script>
        $('#crudder_header_id').tooltip();
        $('#crudder_header_display_name').tooltip();
        $('#crudder_header_is_metatable').tooltip();
        $('#crudder_header_help_text').tooltip();
    </script>

    <!-- TABLES LIST -->
    <?php
    foreach ($tables as $table)
    {
        ?>
        <tr>
        <td><?= $table['id'] ?></td>
        <td><?= $table['display_name'] ?></td>
        <td><?= $table['is_metatable'] == 1 ? Crudderconfig::get_string('yes_label') : Crudderconfig::get_string('no_label') ?></td>
        <td><?= $table['help_text'] ?></td>
        <td>
        <?php if ($table['with_edit'] == 1)
        { ?>
        <div class="btn-toolbar" role="toolbar">
          <div class="btn-group btn-group-xs">
            <button type="button" onclick="location.href='/crudder/table_show/<?= $table['id'] ?>'" class="btn btn-info"><?= Crudderconfig::get_string('show_label') ?></button>
          </div>
        </div>
        <?php
        }
    }
    ?>
    </table>

    </div>
