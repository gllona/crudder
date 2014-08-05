<?php

Class Estado
{

    static private $ci;



    // METODOS DE CLASE

    static function init ()
    {
        self::$ci = Mainapp::get_instance();
    }



    static function consultar_todos ()
    {
        $query = <<<EOL
            SELECT e.id, e.nombre
            FROM cat_estados e
            ORDER BY e.nombre;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre'];
        return $dict;
    }

}

?>