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

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait that provides pagination support to controller actions
 *
 * @package Cpac\ManagerBundle\Controller
 */
trait CommonControllerTrait
{
	/**
	 * Given a collection, use continue criteria and a limit to narrow the selection
	 *
	 * @param ArrayCollection $collection
	 * @param Request $request
	 *
	 * @return ArrayCollection
	 */
	protected function applyContinueLimit( ArrayCollection $collection, Request $request ) {
		$limit = $request->query->get( 'limit' );
		$continue = $request->query->get( 'continue' );
		$criteria = Criteria::create();

		if ( $continue !== null ) {
			foreach ( $continue as $key => $value ) {
				$criteria->andWhere( Criteria::expr()->gt( $key, $value ) );
			}
		}

		return $collection->matching( $criteria )->slice( 0, $limit );
	}
}
