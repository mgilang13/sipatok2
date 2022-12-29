<?php
 
	class Model_user extends CI_Model
	{

		public $table = "users";
		public $table_user_role = 'user_role';
		
		// mengambil data $username & $password dari hasil parsing controller Auth function check_login() dan mencocokanya dengan data yang ada di database
		function loginAdmin($username, $password)
		{
			$decrypted_password = md5($password);
			// $this->db->where('username', $username);
			// $this->db->where('password', md5($password));
			// $this->db->join('user_role', 'user_role.id_role = users.id');
			// $user = $this->db->get('users')->row_array();
			$sql = "SELECT 
						* FROM users AS u 
					JOIN user_role AS ur 
					ON u.id = ur.id_user 
					WHERE 
						username = '$username' AND password = '$decrypted_password' AND ur.id_role = '1'";
			$query = $this->db->query($sql);
			$user = $query->row_array();
			
			return $user;
		}

		function loginOperator($username, $password)
		{
			$decrypted_password = md5($password);
			
			// $sql = "SELECT * FROM users AS u JOIN user_role AS ur ON u.id = ur.id_user JOIN m_roles AS mr ON ur.id_role = mr.id WHERE username = '$username' AND password = '$decrypted_password' AND ur.id_role != '1'";
			$sql = "SELECT * 
					FROM users AS u 
					JOIN user_role AS ur 
					ON u.id = ur.id_user 
					LEFT OUTER JOIN m_pulau mp 
					ON mp.KODE_PULAU = ur.id_pulau 
					JOIN m_roles AS mr 
					ON ur.id_role = mr.id 
					WHERE username = '$username' AND password = '$decrypted_password' AND ur.id_role != '1'";

			$query = $this->db->query($sql);
			$user = $query->row_array();
			
			return $user;
		}

		function save($foto)
		{
			$id = uniqid();

			$data = array(
				//tabel di database => name di form
				'id'				=> $id,
				'nama'            	=> $this->input->post('nama', TRUE),
				'username'          => $this->input->post('username', TRUE),
				'password'         	=> md5( $this->input->post('password', TRUE) )
			);
			
			$data_user_role = array(
				'id_user'			=> $id,
				'id_role'			=> $this->input->post('level_user', TRUE),
				'id_pulau'			=>  $this->input->post('id_pulau', TRUE),
				'id_dinas'			=>  $this->input->post('id_dinas', TRUE),
				'id_balai'			=> $this->input->post('id_balai', TRUE),
				'id_pbph'			=>	$this->input->post('id_pbph', TRUE)
			);

			$this->db->insert($this->table, $data);
			$this->db->insert($this->table_user_role, $data_user_role);

		}

		function update($foto)
		{

			if (empty($this->input->post('username', TRUE))) {
				$data = array(
					//tabel di database => name di form
					'nama'            => $this->input->post('nama_lengkap', TRUE),
					'username'        => $this->input->post('username', TRUE)
				);

				$data_user_role = array(
					'id_role'		=>	$this->input->post('level_user')
				);
			} else {
				$data = array(
					//tabel di database => name di form
					'nama'            => $this->input->post('nama_lengkap', TRUE),
					'username'        => $this->input->post('username', TRUE)
				);

				if ($this->input->post('password') != NULL) {
					$data = array(
						'password'	=> md5( $this->input->post('password', TRUE) )
					);
				}

				$data_user_role = array(
					'id_role'		=>	$this->input->post('level_user'),
					'id_dinas'		=> $this->input->post('id_provinsi'),
					'id_pulau'		=>  $this->input->post('id_pulau'),
					'id_balai'		=>  $this->input->post('id_balai'),
					'id_pbph'		=>	$this->input->post('id_pbph')
				);
			}		
			$id_user 	= $this->input->post('id_user', TRUE);
			$this->db->where('id', $id_user);
			$this->db->update($this->table, $data);

			$this->db->where('id_user', $id_user);
			$this->db->update('user_role', $data_user_role);
		}

		function getAll()
		{
			$sql = "select 
						u.id as id_user,
						u.nama as nama_lengkap,
						u.username,
						u.password,
						ur.id_role as id_level_user,
						mr.nama_role as nama_level
					from
						users as u
					join
						user_role ur 
					on
						ur.id_user =u.id 
					join 
						m_roles mr 
					on
						mr.id  = ur.id_role";

			$query = $this->db->query($sql);
			return $query->result();
		}
		
		
	}

?>