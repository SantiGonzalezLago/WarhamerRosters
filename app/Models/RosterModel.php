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
use \Hermawan\DataTables\DataTable;

class RosterModel extends Model {

	protected $table = 'roster';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'id',
		'name',
		'file',
		'battle_size_id',
		'game_type_id',
		'user_id',
		'date_created',
		'date_updated',
	];

	public function getRosters() {
		$builder = $this->db->table('roster r');

		$builder->select('r.name, r.file, '.$this->_lang('bs.name').' AS battle_size, '.$this->_lang('gt.name').' AS game_type, a.armies, u.display_name, r.date_updated, r.date_created, '.$this->_lang('gtc.name').' AS game_type_category, r.id');

		$builder->join('battle_size        bs',  'r.battle_size_id = bs.id',          'left');
		$builder->join('game_type          gt',  'r.game_type_id = gt.id',            'left');
		$builder->join('game_type_category gtc', 'gt.game_type_category_id = gtc.id', 'left');
		$builder->join('user               u',   'r.user_id = u.id',                  'left');
		$builder->join($this->_armies_subquery(),'r.id = a.roster_id',                'left');

		return DataTable::of($builder)->filter(function ($builder, $request) {
			if (isset($request->title)) {
				$builder->like('r.name', $request->title);
			}
			if (isset($request->battleSize)) {
				$builder->whereIn('battle_size_id', $request->battleSize);
			}
			if (isset($request->gameType)) {
				$builder->whereIn('game_type_id', $request->gameType);
			}
			if (isset($request->armies)) {
				$subquery = $this->db->table('roster_army')->select('roster_id')->whereIn('army_id', $request->armies);
				$builder->whereIn('roster_id', $subquery);
			}
			if (isset($request->user)) {
				$builder->whereIn('user_id', $request->user);
			}
    	})->toJson();
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

	protected function _armies_subquery() {
		return "(SELECT roster_id, GROUP_CONCAT(".$this->_lang('name').") AS armies
				FROM roster_army ra
				LEFT JOIN army a ON ra.army_id = a.id
				GROUP BY roster_id) a";
	}
}