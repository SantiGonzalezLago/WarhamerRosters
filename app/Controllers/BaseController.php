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

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var CLIRequest|IncomingRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	private $data;
	private $userdata;

	/**
	 * Constructor.
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		$this->data = array();
		$this->data['data'] = array();

		// Preload any models, libraries, etc, here.
		$this->authModel = model('AuthModel');
		$this->settingsModel = model('SettingsModel');
	}

	protected function loadView(string $view) {
		$this->data['userdata'] = $this->getUserData();
		$this->data['view'] = $view;
		return view('template', $this->data);
	}

	protected function setTitle(string $title) {
		$this->data['title'] = lang($title);
	}

	protected function setData(string $key, $value) {
		$this->data['data'][$key] = $value;
	}

	protected function getUserData() {
		if (isset($this->userdata)) {
			return $this->userdata;
		}

		try {
			if (session('id')) {
				$data = $this->authModel->getUser(session('id'), true);
				$this->userdata = [
					'id'			=> session('id'),
					'display_name'	=> $data->display_name,
				];
			} else {
				session()->destroy();
				$this->userdata = NULL;
			}
		} catch (\Exception $e) {
			log_message('error', 'Error fetching user ' . session('id') . ': ' . $e->getMessage());
			session()->destroy();
			$this->userdata = NULL;
		}

		return $this->userdata;
	}

}
