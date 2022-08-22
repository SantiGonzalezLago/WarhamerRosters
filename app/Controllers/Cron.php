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

// Como acceder mediante curl:
// curl -d "key=<key>" -X POST http://localhost:8080/cron
class Cron extends BaseController {

	public function __construct() {
		$this->db = db_connect();

		$request = \Config\Services::request();
		$key = $request->getPost('key');
		$hash = model('SettingsModel')->getSetting('cron_key');

		if (!($key && password_verify($key, $hash))) {
			header("HTTP/1.1 403 Forbidden");
			exit;
		}
	}

	public function index() {
		$this->verify_files();
		$this->delete_old_logs();
	}

	public function verify_files() {
		try {
			$filesDb = array_column($this->db->table('roster')->select('file')->get()->getResult(), 'file');
			$filesReal = array_slice(scandir(FCPATH.'rosters'), 2);

			$filesDbNotReal = array_values(array_diff($filesDb, $filesReal));
			$filesRealNotDb = array_values(array_diff($filesReal, $filesDb));

			if ($filesDbNotReal) {
				$this->db->table('roster')->whereIn('file', $filesDbNotReal)->delete();
			}
			
			foreach($filesRealNotDb as $fileDel) {
				unlink(FCPATH.'rosters/'.$fileDel);
			} 

			$error = false;
			$log = array(
				'total_deleted_files' => count($filesRealNotDb),
				'total_deleted_entries' => count($filesDbNotReal),
				'deleted_files' => $filesRealNotDb,
				'deleted_entries' => $filesDbNotReal,
			);
		} catch (Exception $e) {
			$error = true;
			$log = 'Error: ' . $e-getMessage();
		}

		$this->_insert_log('verify_files', $log, $error);
	}

	public function delete_old_logs() {
		try {
			$date = strtotime("- 6 months");

			$this->db->table('cron_log')->where('datetime <', date("c", $date))->delete();
			$cronRowsDeleted = $this->db->affectedRows();

			$this->db->table('login_log')->where('datetime <', date("c", $date))->delete();
			$loginRowsDeleted = $this->db->affectedRows();

			$error = false;
			$log = array(
				'cron_rows_deleted' => $cronRowsDeleted,
				'login_rows_deleted' => $loginRowsDeleted,
				'before_date' => date("Y-m-d h:i:s", $date),
			);
		} catch (Exception $e) {
			$error = true;
			$log = 'Error: ' . $e-getMessage();
		}

		$this->_insert_log('delete_old_logs', $log, $error);
	}

	private function _insert_log($job, $log, $error) {
		$this->db->table('cron_log')->insert(array(
			'job' 	=> $job,
			'log' 	=> json_encode($log),
			'error'	=> $error,
		));
	}
}