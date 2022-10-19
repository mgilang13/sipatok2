<?php
 
	class Model_user extends CI_Model
	{

		public $table = "users";
		
		// mengambil data $username & $password dari hasil parsing controller Auth function check_login() dan mencocokanya dengan data yang ada di database
		function login($username, $password)
		{
			$decrypted_password = md5($password);
			// $this->db->where('username', $username);
			// $this->db->where('password', md5($password));
			// $this-	>db->join('user_role', 'user_role.id_role = users.id');
			// $user = $this->db->get('users')->row_array();
			$sql = "SELECT * FROM users AS u JOIN user_role AS ur ON u.id = ur.id_user WHERE username = '$username' AND password = '$decrypted_password'";
			$query = $this->db->query($sql);
			$user = $query->row_array();
			
			return $user;
		}

		function save($foto)
		{
			$data = array(
				//tabel di database => name di form
				'nama'            => $this->input->post('nama', TRUE),
				'username'          	  => $this->input->post('username', TRUE),
				'password'          	  => md5( $this->input->post('password', TRUE) ),
				'id_level_user'           => $this->input->post('level_user', TRUE),
				'foto'					  => $foto
			);
			$this->db->insert($this->table, $data);
		}

		function update($foto)
		{
			if (empty($foto)) {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5( $this->input->post('password', TRUE) ),
					'id_level_user'           => $this->input->post('level_user', TRUE),
				);
			} else {
				$data = array(
					//tabel di database => name di form
					'nama_lengkap'            => $this->input->post('nama_lengkap', TRUE),
					'username'          	  => $this->input->post('username', TRUE),
					'password'          	  => md5( $this->input->post('password', TRUE) ),
					'id_level_user'           => $this->input->post('level_user', TRUE),
					'foto'					  => $foto
				);
			}		
			$id_user 	= $this->input->post('id_user', TRUE);
			$this->db->where('id_user', $id_user);
			$this->db->update($this->table, $data);
		}

	}

?>