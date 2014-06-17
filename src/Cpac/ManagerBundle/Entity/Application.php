<?php
/**
 * This file is part of the CPAC website.
 * Copyright 2014 Tyler Anthony Romeo
 *
 * The CPAC website is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Foobar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @license AGPL-3.0
 * @copyright 2014 Tyler Anthony Romeo
 * @author Tyler Anthony Romeo <tylerromeo@gmail.com
 */

namespace Cpac\ManagerBundle\Entity;

/**
 * Entity that represents an individual application
 *
 * @package Cpac\ManagerBundle\Entity
 */
class Application
{
	/**
	 * @var int Identifier for the application
	 */
	protected $id;

	/**
	 * @var ApplicationType type of the application
	 */
	protected $type;

	/**
	 * @var User that filed the application
	 */
	protected $user;

	/**
	 * @var string Application state
	 */
	public $state = 'draft';

	/**
	 * @var mixed Application data
	 */
	public $data;

	/**
	 * Make a new application
	 *
	 * @param ApplicationType $type
	 * @param User $user
	 */
	public function __construct( ApplicationType $type, User $user ) {
		$this->type = $type;
		$this->user = $user;
	}

	/**
	 * Get the type of the application
	 *
	 * @return ApplicationType
	 */
	public function getApplicationType() {
		return $this->type;
	}

	/**
	 * Get the user that submitted the application
	 *
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}
}
