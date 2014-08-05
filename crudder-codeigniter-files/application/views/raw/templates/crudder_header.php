<!-- desde aqui el CRUDDER_header -->

<div>

    <div>
        <?= anchor('crudder/goaway', 'Regresar a las operaciones principales del sistema') ?>
    </div>

    <h2>Utilidad de administración de tablas</h2>
    
    <div>
        <?php
        $message = $this->session->flashdata('crudder_message');
        if ($message != false) {
            echo '<p><i><b>' . $message . '</b></i></p>';
        }
        ?>
    </div>
    
    <!-- hasta aqui el CRUDDER_header -->

