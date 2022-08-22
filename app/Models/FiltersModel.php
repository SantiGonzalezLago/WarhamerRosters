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

class FiltersModel extends Model {

	public function getBattleSizes() {
		$builder = $this->db->table('battle_size bs');
		$builder->select('bs.id, '.$this->_lang('bs.name').' AS name, COUNT(r.id) AS total');
		$builder->join('roster r', 'r.battle_size_id = bs.id', 'left');
		$builder->groupBy('bs.id');
		return $builder->get()->getResult();
	}

	public function getGameTypes() {
		$builder = $this->db->table('game_type gt');
		$builder->select('gt.id, '.$this->_lang('gt.name').' AS name, COUNT(r.id) AS total');
		$builder->join('roster r', 'r.game_type_id = gt.id', 'left');
		$builder->groupBy('gt.id');
		return $builder->get()->getResult();
	}

	public function getArmies() {
		$builder = $this->db->table('army a');
		$builder->select('a.id, '.$this->_lang('a.name').' AS name, COUNT(ra.roster_id) AS total');
		$builder->join('roster_army ra', 'ra.army_id = a.id', 'left');
		$builder->groupBy('a.id');
		return $builder->get()->getResult();
	}

	public function getUsers() {
		$builder = $this->db->table('user u');
		$builder->select('u.id, u.display_name AS name, COUNT(r.id) AS total');
		$builder->join('roster r', 'r.user_id = u.id', 'left');
		$builder->groupBy('u.id');
		return $builder->get()->getResult();
	}

	protected function _lang($field) {
		$locale = service('request')->getLocale();
		$allowedLocales = ['es'];
		if (in_array($locale, $allowedLocales)) {
			return 'COALESCE('.$field.'_'.$locale.', '.$field.'_en)';
		} else {
			return $field.'_en';
		}
	}

}