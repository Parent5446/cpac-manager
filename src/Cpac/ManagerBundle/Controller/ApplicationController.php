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

use Cpac\ManagerBundle\Entity\Application;
use Cpac\ManagerBundle\Entity\ApplicationType;
use Cpac\ManagerBundle\Entity\User;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Controller for handling individual applications or for listing applications
 *
 * @package CpacManager\Controller
 */
class ApplicationController extends FOSRestController implements ClassResourceInterface
{
	use CommonControllerTrait;

	/**
	 * List all applications under a given type
	 *
	 * @param Request $request
	 * @param ApplicationType $appType
	 *
	 * @return JsonResponse
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 */
	public function cgetAction( Request $request, ApplicationType $appType ) {
		if ( !$this->get( 'security.context' )->isGranted( 'ROLE_ADMIN' ) ) {
			throw $this->createAccessDeniedException();
		}

		return $this->view( $this->applyContinueLimit( $appType->applications, $request ) );
	}

	/**
	 * Get a list of applications that belong to a certain user
	 *
	 * @param Request $request
	 * @param User $user
	 *
	 * @return JsonResponse
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 */
	public function userListAction( Request $request, User $user ) {
		if ( (string)$this->getUser() !== (string)$user ) {
			throw $this->createAccessDeniedException();
		}

		return $this->view( $this->applyContinueLimit( $user->applications, $request ) );
	}

	/**
	 * Get information about a specific application given its con year, type, and ID.
	 *
	 * @param Application $application
	 *
	 * @return JsonResponse
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 */
	public function getAction( Application $application ) {
		if ( !$this->get( 'security.context' )->isGranted( 'ROLE_ADMIN' )
			&& (string)$this->getUser() !== (string)$application->getUser()
		) {
			throw $this->createAccessDeniedException();
		}

		return $this->view( $application );
	}

	/**
	 * Given data in the POST data, create a new application in the database and return it to the user.
	 *
	 * @param Request $request
	 * @param ApplicationType $appType
	 *
	 * @return JsonResponse|Response
	 */
	public function postAction( Request $request, ApplicationType $appType ) {
		$application = new Application( $appType, $this->getUser() );
		$application->state = $request->request->get( 'application_state' );
		$application->data = $request->request->get( 'application_data' );

		/** @var \Symfony\Component\Validator\Validator $validator */
		$validator = $this->get( 'validator' );
		$errors = $validator->validate( $application );
		if ( $errors ) {
			return new Response( (string)$errors, Response::HTTP_BAD_REQUEST );
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist( $application );
		$em->flush();

		return $this->getAction( $application );
	}
}
