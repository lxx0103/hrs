<?php

class Login_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function do_login($username, $password)
    {
        $sql = "SELECT * FROM u_user WHERE username = ?";
        $query = $this->db->query($sql, array($username)); 
        $user = $query->row_array();
        if($user)
        {
            $hashed = $user['password'];
            $verified = password_verify($password, $hashed);
            if($verified === true)
            {
                $role_sql = "SELECT * FROM u_role WHERE id = ? AND is_enable = 1";
                $role_query = $this->db->query($role_sql, array($user['role_id']));
                $role = $role_query->row_array();
                if($role)
                {
                    $user['role_name'] = $role['role_name'];
                    return array('status' => 1, 'msg' => '成功', 'data' => $user);
                }else
                {
                    return array('status' => 2, 'msg' => '角色不存在', 'data' => array());
                }
            }else
            {
                return array('status' => 2, 'msg' => '密码错误', 'data' => array());
            }
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }
}