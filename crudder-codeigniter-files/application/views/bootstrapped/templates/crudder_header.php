<!-- desde aqui el CRUDDER_header -->

<div>

    <div>
        <?= anchor('crudder/goaway', Crudderconfig::get_string('go_back_main_system_link')) ?>
    </div>

    <h2><?= Crudderconfig::get_string('tables_administrator_title') ?></h2>

    <?php
    $message = $this->session->flashdata('crudder_message');
    if ($message != false) {
        echo '<div class="alert alert-success">';
        echo '<b>' . $message . '</b>';
        echo "</div>\n";
    }
    ?>
    
    <!-- hasta aqui el CRUDDER_header -->

