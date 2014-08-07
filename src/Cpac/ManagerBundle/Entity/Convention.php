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
	 * @var ApplicationType[]|\Doctrine\Common\Collections\ArrayCollection List of application types
	 */
	public $application_types;

	/**
	 * Make a new convention with an empty set of application types
	 *
	 * @param \DateTime $start_date Start date of the convention
	 */
	public function __construct( \DateTime $start_date ) {
		$this->start_date = $start_date;
		$this->application_types = new ArrayCollection();

		$this->application_types[] = new ApplicationType( $this, 'art' );
		$this->application_types[] = new ApplicationType( $this, 'dealer' );
		$this->application_types[] = new ApplicationType( $this, 'cosplay' );
		$this->application_types[] = new ApplicationType( $this, 'amv' );
		$this->application_types[] = new ApplicationType( $this, 'panel' );
	}

	/**
	 * Get a list of active application types
	 *
	 * @return \Doctrine\Common\Collections\Collection|static
	 */
	public function getActiveTypes() {
		return $this->application_types->filter( function ( ApplicationType $type ) {
			return $type->enabled === true;
		} );
	}

	/**
	 * Get a list of inactive application types
	 *
	 * @return \Doctrine\Common\Collections\Collection|static
	 */
	public function getInactiveTypes() {
		return $this->application_types->filter( function ( ApplicationType $type ) {
			return $type->enabled === false;
		} );
	}
}
