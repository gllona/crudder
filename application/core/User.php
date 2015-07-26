<?php

Class User
{

    static private $ci;



    // METODOS DE CLASE

    static function init ()
    {
        self::$ci = Mainapp::get_instance();
    }



    static function verify ($user, $password, $check_password = TRUE)
    {
        $encoded_password = md5($password);
        $query_password = ($check_password ? "AND password = '$encoded_password'" : "");
        $query = <<< EOL
            SELECT role
            FROM user
            WHERE user_name = '$user' $query_password;
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        if ($rs->num_rows() != 1) {
            Log::register("user verification error ($user); a number of records different than one was found");
            return -1;
        } else {
            Log::register("succesful user verification ($user)");
            return $rows[0]['role'];
        }
    }        


    
    static function retrieve_all ()
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;
        
        $query = <<< EOL
            SELECT user_name, role
            FROM user;
EOL;
        $rs = self::$ci->db->query($query);
        $users = $rs->result_array();
        Log::register("all users retrieved, unknown records count");
        return $users;
    }        


    
    static function retrieve ($user)
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;
        
        $query = <<< EOL
            SELECT user_name, role
            FROM user
            WHERE user_name = '$user';
EOL;
        $rs = self::$ci->db->query($query);
        $users = $rs->result_array();
        if ($rs->num_rows() != 1) {
            Log::register("user retrieve attempt ($user); record count is not one");
            return -1;
        } else {
            Log::register("succesful user retrieve attempt ($user)");
            return $users[0];
        }
    }        


    
    static private function count_by_role ($role)
    {
        $query = <<< EOL
            SELECT COUNT(*) AS num_rows
            FROM user
            WHERE role = '$role';
EOL;
        $rs = self::$ci->db->query($query);
        $rows = $rs->result_array();
        Log::register("users count by role ($role)");
        return $rows[0]['num_rows'];
    }
    
    
    
    static function insert ($user_name, $role, $password)
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;
        
        $user = self::retrieve($user_name);
        if ($user !== -1) {
            Log::register("attempt to insert an user with an existing name ($user_name, $role)");
            return -1;
        }

        $user_name = self::$ci->db->escape_str($user_name);
        $role      = self::$ci->db->escape_str($role);
        $encoded_password = md5(self::$ci->db->escape_str($password));
        $query = <<< EOL
            INSERT INTO user
            (user_name, role, password)
            VALUES ('$user_name', '$role', '$encoded_password');
EOL;
        self::$ci->db->query($query);
        if (self::$ci->db->affected_rows() != 1) {
            Log::register("database error when inserting an user ($user_name, $role)");
            return -1;
        }
        else {
            Log::register("succesful insert into user ($user_name, $role)");
            return 1;
        }
    }        


    
    static function generate ()
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;
        
        $user = array();
        $user['user_name'] = '';
        $user['role']      = 'regular';
        $user['password']  = '';
        return $user;
    }        

    
    
    static function update ($user_old, $user, $role, $password)
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;
        
        if ($user_old != $user) {
            $user_record = self::retrieve($user);
            if (is_array($user_record)) {
                Log::register("trying to update an user by changing its name to one used by another user");
                return -3;
            }
        }

        $user_name = self::$ci->db->escape_str($user);
        $role      = self::$ci->db->escape_str($role);
        $encoded_password = md5(self::$ci->db->escape_str($password));
        $query = <<< EOL
            UPDATE user
            SET user_name = '$user',
                role      = '$role',
                password  = '$encoded_password'
            WHERE user_name = '$user_old';
EOL;
        self::$ci->db->query($query);
        if (self::$ci->db->affected_rows() != 1) {
            Log::register("database update affected a number of records distinct to one when updating an user");
            return -1;
        } else {
            Log::register("succesful update to user (old-name :: $user_old, new-name :: $user, $role)");
            return 1;
        }
    }        


    
    static function delete ($user_name)
    {
        if (! self::verify(self::$ci->session->userdata('user'), self::$ci->session->userdata('password')))
            return -2;

        $user = self::retrieve($user_name);
        $num_superadmins = self::count_by_role('superadmin');
        if ($user['role'] == 'superadmin' && $num_superadmins == 1) {
            Log::register("trying to delete the last superadmin user ($user_name)");
            return -3;
        }
        
        $query = <<< EOL
            DELETE FROM user
            WHERE user_name = '$user_name';
EOL;
        self::$ci->db->query($query);
        Log::register("update delete attempt ($user_name)");
        if (self::$ci->db->affected_rows() != 1) {
            Log::register("user deletion affected a number of records different than one ($user_name)");
            return -1;
        } else {
            Log::register("succesful deletion from user ($user_name)");
            return 1;
        }
    }        

}

?>