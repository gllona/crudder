<?php

Class Municipio
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
            SELECT m.id, m.id_estado, CONCAT(e.nombre, ' - ', m.nombre) AS nombre_completo
            FROM cat_municipios m
                JOIN cat_estados e ON m.id_estado = e.id
            ORDER BY nombre_completo;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre_completo'];
        return $dict;
    }


    
    static function consultar_todos_por_estado ($id_estado)
    {
        $query = <<<EOL
            SELECT m.id, m.id_estado, m.nombre
            FROM cat_municipios m
            WHERE m.id_estado = '$id_estado'
            ORDER BY m.nombre;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre'];
        return $dict;
    }

}

?>