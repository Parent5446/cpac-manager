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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Main controller for serving the application to the browser
 *
 * @package Cpac\ManagerBundle\Controller
 */
class FrontendController extends Controller {
	/**
	 * Render the main application frontend with the proper caching headers
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction() {
		return $this->render( 'CpacManagerBundle:Frontend:app.html.twig' );
	}
}
