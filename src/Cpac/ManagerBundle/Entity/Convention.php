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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entity representing a convention for a given year
 *
 * @package Cpac\ManagerBundle\Entity
 */
class Convention
{
	/**
	 * @var \DateTime Date the convention started
	 */
	public $start_date;

	/**
	 * @var \DateTime Date the convention ended
	 */
	public $end_date;

	/**
	 * @var bool Whether the convention is active or not
	 */
	public $active = false;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection List of application types
	 */
	public $application_types;

	/**
	 * Make a new convention with an empty set of application types
	 */
	public function __construct() {
		$this->application_types = new ArrayCollection();
	}
}
