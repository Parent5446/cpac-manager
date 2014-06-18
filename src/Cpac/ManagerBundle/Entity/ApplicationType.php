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
 * Entity representing a type of application that can be submitted
 * for the convention
 *
 * @package Cpac\ManagerBundle\Entity
 */
class ApplicationType
{
	/**
	 * @var Convention that the application type belongs to
	 */
	protected $convention;

	/**
	 * @var string Name of the application type
	 */
	protected $type_name;

	/**
	 * @var bool Whether the type is enabled or not
	 */
	public $enabled = false;

	/**
	 * @var string Role that can manage this type
	 */
	public $managing_role;

	/**
	 * @var bool Whether this application needs payments
	 */
	public $needs_payment;

	/**
	 * @var int Number of maximum entries
	 */
	public $max_entries;

	/**
	 * @var int Maximum size of waitlist
	 */
	public $max_waiting;

	/**
	 * @var Application[]|\Doctrine\Common\Collections\ArrayCollection List of applications
	 */
	public $applications;

	/**
	 * Make a new application type with an empty set of applications
	 *
	 * @param Convention $convention
	 * @param string $name Name of the type
	 */
	public function __construct( Convention $convention, $name ) {
		$this->convention = $convention;
		$this->type_name = $name;
		$this->applications = new ArrayCollection();
	}

	/**
	 * Get the associated convention
	 *
	 * @return Convention
	 */
	public function getConvention() {
		return $this->convention;
	}

	/**
	 * Get the name of the type
	 *
	 * @return string
	 */
	public function getTypeName() {
		return $this->type_name;
	}
}
