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

class Dashboard extends BaseController {

	public function index() {
        $this->filtersModel = model('FiltersModel');

		$this->setData('battleSizes',	$this->filtersModel->getBattleSizes());
		$this->setData('gameTypes',		$this->filtersModel->getGameTypes());
		$this->setData('armies',		$this->filtersModel->getArmies());
		$this->setData('users',			$this->filtersModel->getUsers());

		return $this->loadView('dashboard');
	}

	public function test() {
		echo json_encode($this->request->getServer());
	}

	public function datatable() {
		if (!$this->request->isAJAX()) {
			return redirect()->to('/');
		}
		$this->rosterModel = model('RosterModel');
		return $this->rosterModel->getRosters();
	}
}
