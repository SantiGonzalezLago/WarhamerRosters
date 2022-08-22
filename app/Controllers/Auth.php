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

namespace App\Controllers;

class Auth extends BaseController {

	public function login() {
		if (!$this->request->isAJAX()) {
			return redirect()->to('/');
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		$user = $this->authModel->authenticate($email, $password);
		if ($user) {
			session()->set([
				'id' => $user->id,
			]);
			$response = array(
				'success' => true,
			);
		} else {
			$response = array(
				'success' => false,
				'error'	=> lang('Auth.login_error'),
			);
		}

		echo json_encode($response);
	}

    public function logout() {
        session()->destroy();
		return redirect()->back();
    }
}