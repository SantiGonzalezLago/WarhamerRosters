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

class Upload extends BaseController {

	public function index() {
		$user = $this->getUserData();

		if (!$user) {
			return redirect()->to('/');
		}
		
        $this->filtersModel = model('FiltersModel');

		$this->setData('battleSizes',	$this->filtersModel->getBattleSizes());
		$this->setData('gameTypes',		$this->filtersModel->getGameTypes());
		$this->setData('armies',		$this->filtersModel->getArmies());
		$this->setData('users',			$this->filtersModel->getUsers());

		$this->setTitle('Upload.upload_roster');
		return $this->loadView('upload');
	}

	public function do_upload() {
		$valid = $this->validate([
            'name' 		=> ['label' => lang('Dashboard.title'), 'rules' => 'required'],
			'file' 		=> 'uploaded[file]|mime_in[file,text/html,application/pdf]',
        ]);

		if ($valid) {
			echo 'ok';
		} else {
			session()->setFlashdata('upload_error', $this->validator->getErrors());
			return redirect()->back()->withInput();
		}
	}

}