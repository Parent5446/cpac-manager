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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Controller for providing information on an certain application type for a
 * given convention.
 *
 * @package CpacManager\Controller
 */
class ApplicationTypeController extends Controller
{
	/**
	 * Get information about a specific application type from a specific convention
	 *
	 * @param ApplicationType $appType
	 *
	 * @return JsonResponse
	 */
	public function infoAction( ApplicationType $appType ) {
		$conYear = $appType->getConvention()->start_date->format( 'Y' );

		return new JsonResponse( [
			'con_year' => $conYear,
			'type_name' => $appType->getTypeName(),
			'enabled' => $appType->enabled,
			'needs_payment' => $appType->needs_payment,
			'max_entries' => $appType->max_entries,
			'max_waiting' => $appType->max_waiting,
			'num_applications' => $appType->applications->count(),
			'applications' => $this->get( 'router' )->generate(
					'app_list',
					[ 'conYear' => $conYear, 'appType' => $appType->getTypeName() ]
				),
		] );
	}
}
