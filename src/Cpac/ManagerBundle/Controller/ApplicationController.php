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
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Controller for handling individual applications or for listing applications
 *
 * @package CpacManager\Controller
 */
class ApplicationController extends Controller
{
	/**
	 * List all applications under a given type
	 *
	 * @param Request $request
	 * @param ApplicationType $appType
	 *
	 * @return JsonResponse
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 */
	public function listAction( Request $request, ApplicationType $appType ) {
		if ( !$this->get( 'security.context' )->isGranted( 'ROLE_ADMIN' ) ) {
			throw $this->createAccessDeniedException();
		}

		$limit = $request->query->get( 'limit' );
		$continue = $request->query->get( 'continue' );
		$criteria = Criteria::create();
		if ( $continue !== null ) {
			foreach ( $continue as $key => $value ) {
				$criteria->andWhere( Criteria::expr()->gt( $key, $value ) );
			}
		}

		/** @var Application[]|\Doctrine\Common\Collections\ArrayCollection $applications */
		$applications = $appType->applications->matching( $criteria )->slice( 0, $limit );

		// Use initial row to populate the result structure
		/** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator */
		$urlGenerator = $this->get( 'router' );
		$retval = [
			'con_year' => $appType->getConvention()->start_date->format( 'Y' ),
			'type_name' => $appType,
			'type_info' => $urlGenerator->generate(
					'apptype_info',
					[ 'conYear' => $appType->getConvention()->start_date, 'appType' => $appType->getTypeName() ]
				),
			'applications' => [ ],
		];

		// Add remaining applications to the data structure
		foreach ( $applications as $application ) {
			$retval[ 'applications' ][ $application->getId() ] = $urlGenerator->generate(
				'app_info',
				[
					'conYear' => $appType->getConvention()->start_date,
					'appType' => $appType,
					'appId' => $application->getId(),
				]
			);
		}

		return new JsonResponse( $retval );
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

		$limit = $request->query->get( 'limit' );
		$continue = $request->query->get( 'continue' );
		$criteria = Criteria::create();
		if ( $continue !== null ) {
			foreach ( $continue as $key => $value ) {
				$criteria->andWhere( Criteria::expr()->gt( $key, $value ) );
			}
		}

		/** @var Application[]|\Doctrine\Common\Collections\ArrayCollection $applications */
		$applications = $user->applications->matching( $criteria )->slice( 0, $limit );

		$retval = [ 'user_id' => $user->getId(), 'applications' => [ ] ];
		/** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator */
		$urlGenerator = $this->get( 'router' );
		foreach ( $applications as $application ) {
			$retval[ 'applications' ][ $application->getId() ] = $urlGenerator->generate(
				'app_info',
				[
					'conYear' => $application->getApplicationType()->getConvention()->start_date,
					'appType' => $application->getApplicationType()->getTypeName(),
					'appId' => $application->getId(),
				]
			);
		}

		return new JsonResponse( $retval );
	}

	/**
	 * Get information about a specific application given its con year, type, and ID.
	 *
	 * @param Application $application
	 *
	 * @return JsonResponse
	 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
	 */
	public function infoAction( Application $application ) {
		if ( (string)$this->getUser() !== (string)$application->getUser() ) {
			throw $this->createAccessDeniedException();
		}

		return new JsonResponse( [
			'application_id' => $application->getId(),
			'con_year' => $application->getApplicationType()->getConvention()->start_date,
			'type_name' => $application->getApplicationType()->getTypeName(),
			'user_id' => $application->getUser()->getId(),
			'application_state' => $application->state,
			'application_data' => $application->data,
		] );
	}

	/**
	 * Given data in the POST data, create a new application in the database and return it to the user.
	 *
	 * @param Request $request
	 * @param ApplicationType $appType
	 *
	 * @return JsonResponse|Response
	 */
	public function newAction( Request $request, ApplicationType $appType ) {
		$application = new Application( $appType, $this->getUser() );
		$application->state = $request->request->get( 'application_state' );
		$application->data = $request->request->get( 'application_data' );

		/** @var \Symfony\Component\Validator\Validator $validator */
		$validator = $this->get( 'validator' );
		$errors = $validator->validate( $application );
		if ( $errors ) {
			return new Response( (string)$errors );
		}

		$em = $this->getDoctrine()->getManager( 'CpacManagerBundle:Application' );
		$em->persist( $application );
		$em->flush();

		return $this->infoAction( $application );
	}
}
