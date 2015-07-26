<?php

Class Log
{


    
    static function register ($description, $user_from_login = "user-not-specified")
    {
        $CI = &get_instance();
        $user = $CI->session->userdata('user');
        $user = ($user === FALSE ? $user_from_login : $user);
        $query = <<< EOL
            INSERT INTO log
            (user_name, timestamp, description)
            VALUES ('$user', CURRENT_TIMESTAMP(), '$description');
EOL;
        $CI->db->query($query);
    }        

    
    
}

?>
