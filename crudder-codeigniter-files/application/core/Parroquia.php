<?php

Class Parroquia
{

    static private $ci;



    // METODOS DE CLASE

    static function init ()
    {
        self::$ci = Mainapp::get_instance();
    }



    static function consultar_todas ()
    {
        $query = <<<EOL
            SELECT p.id, p.id_estado, p.id_municipio, CONCAT(e.nombre, ' - ', m.nombre, ' - ', p.nombre) AS nombre_completo
            FROM cat_parroquias p
                JOIN cat_municipios m ON p.id_municipio = m.id
                JOIN cat_estados e ON p.id_estado = e.id
            ORDER BY nombre_completo;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre_completo'];
        return $dict;
    }


    
    static function consultar_todas_por_estado ($id_estado)
    {
        $query = <<<EOL
            SELECT p.id, p.id_estado, p.id_municipio, CONCAT(m.nombre, ' - ', p.nombre) AS nombre_completo
            FROM cat_parroquias p
                JOIN cat_municipios m ON p.id_municipio = m.id
            WHERE m.id_estado = '$id_estado'
            ORDER BY nombre_completo;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre_completo'];
        return $dict;
    }


    
    static function consultar_todas_por_municipio ($id_municipio)
    {
        $query = <<<EOL
            SELECT p.id, p.id_estado, p.id_municipio, p.nombre
            FROM cat_parroquias p
            WHERE m.id_municipio = '$id_municipio'
            ORDER BY p.nombre;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        foreach ($rows as $row)
            $dict[$row['id']] = $row['nombre'];
        return $dict;
    }


    }

?>