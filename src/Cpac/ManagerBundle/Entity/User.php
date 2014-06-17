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
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Security\Core\Util\StringUtils;

/**
 * Entity representing a user of the site
 *
 * @package Cpac\ManagerBundle\Entity
 */
class User extends BaseUser
{
	/**
	 * @var int Identifier for the user
	 */
	protected $id;

	/**
	 * @var string Token used for session authentication
	 */
	protected $token;

	/**
	 * @var \DateTime Date the user registered
	 */
	protected $registration;

	/**
	 * @var mixed Contact information for the user
	 */
	public $contact_info;

	/**
	 * @var \Doctrine\Common\Collections\ArrayCollection List of applications the user has
	 */
	public $applications;

	/**
	 * Make a new user with a default registration date/time
	 */
	public function __construct() {
		parent::__construct();
		$this->registration = new \DateTime();
		$this->applications = new ArrayCollection();
	}

	/**
	 * Set the user's email (also sets email to not-confirmed)
	 *
	 * @param string $email Email address
	 *
	 * @return $this
	 *
	 * @throws \InvalidArgumentException if the address is invalid
	 */
	public function setEmail( $email ) {
		if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			throw new \InvalidArgumentException( "Invalid email '$email' given.'" );
		}

		return parent::setEmail( $email );
	}

	/**
	 * Check a user's session token
	 *
	 * @param string $challenge The salt given to the user
	 * @param string $response The response in the user's cookie
	 *
	 * @return bool
	 */
	public function checkToken( $challenge, $response ) {
		$expected = hash_hmac( 'sha512', $challenge, $this->token );

		return StringUtils::equals( $expected, $response );
	}

	/**
	 * Get the date the user registered on the site
	 *
	 * @return \DateTime
	 */
	public function getRegistration() {
		return $this->registration;
	}
}
