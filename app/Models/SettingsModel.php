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

class SettingsModel extends Model {

	protected $table = 'setting';
	protected $primaryKey = 'key';

	protected $allowedFields = [
		'key',
		'value',
		'description',
		'type',
	];

    public function getSettings() {
        return $this->db->table('setting')->get()->getResultArray();
    }

    public function getSetting($key) {
        $setting = $this->db->table('setting')->where('key', $key)->get()->getRow();

        if (isset($setting)) {
            return $setting->value;
        } else {
            return null;
        }
    }

    public function saveSetting($key, $value) {
        $this->db->table('setting')->set('value', $value)->where('key', $key)->update();

		return $this->db->affectedRows();
    }

}