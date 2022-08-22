<?php

// WarhammerRosters
// Copyright (C) 2022 Santiago González Lago

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <https://www.gnu.org/licenses/>.

namespace App\Models;  
use CodeIgniter\Model;

class AuthModel extends Model {

	protected $table = 'user';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'id',
		'email',
		'password',
		'display_name',
		'active',
	];

	public function getUsers() {
		return $this->db->table('user')->get()->getResult();
	}

    public function getUser($id, $active = false) {
        $builder = $this->db->table('user');
		if ($active) {
			$builder->where('active', 1);
		}
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function authenticate($email, $password) {
        $builder = $this->db->table('user');
		$builder->where('active', 1);
        $builder->where('email', $email);
        $user = $builder->get()->getRow();
        if ($user && password_verify($password, $user->password)) {
            $success = true;
        } else {
			$success = false;
		}

		$request = \Config\Services::request();
		$builder = $this->db->table('login_log');
		$builder->insert(array(
			'user_id' => $user ? $user->id : NULL,
			'ip'	  => $request->getIPAddress(),
			'success' => $success,
		));

		return $success ? $user : NULL;
    }
	
	public function checkEmailExists($email) {
		$user = $this->where('email', $email)->first();
		return isset($user);
	}

	public function checkDisplayNameExists($displayName) {
		$user = $this->where('display_name', $displayName)->first();
		return isset($user);
	}  

}