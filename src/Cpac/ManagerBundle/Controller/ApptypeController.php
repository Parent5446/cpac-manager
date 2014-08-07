<?php
/**
 * This file is part of CpacManager.
 *
 * Copyright (c) 2014 Tyler Romeo
 *
 * Foobar is free software: you can redistribute it and/or modify
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
 * @author Tyler Romeo <tylerromeo@gmail.com>
 * @copyright 2013 Tyler Romeo
 * @license https://www.gnu.org/licenses/agpl-3.0.html GNU Affero General Public License
 */

namespace Cpac\ManagerBundle\Controller;

use Cpac\ManagerBundle\Entity\ApplicationType;
use Cpac\ManagerBundle\Entity\Convention;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Controller for providing information on an certain application type for a
 * given convention.
 *
 * @package CpacManager\Controller
 */
class ApptypeController extends FOSRestController implements ClassResourceInterface
{
	/**
	 * Get information about a specific application type from a specific convention
	 *
	 * @param Convention $convention Unused, but needed for the REST auto-route generation to work
	 * @param ApplicationType $appType
	 *
	 * @return View
	 */
	public function getAction( Convention $convention, ApplicationType $appType ) {
		return $this->view( $appType );
	}
}
