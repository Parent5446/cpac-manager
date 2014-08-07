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

use Cpac\ManagerBundle\Entity\Convention;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Controller for providing information about conventions (either specific or
 * the current convention)
 *
 * @package CpacManager\Controller
 */
class ConventionController extends FOSRestController implements ClassResourceInterface
{
	/**
	 * Get info about a convention
	 *
	 * @param Convention $convention
	 *
	 * @return View
	 */
	public function getAction( Convention $convention ) {
		return $this->view( $convention );
	}

	/**
	 * List all conventions
	 *
	 * @return View
	 */
	public function cgetAction() {
		return $this->view(
			$this->getDoctrine()->getRepository( 'CpacManagerBundle:Convention' )->findAll() );
	}

	/**
	 * Put a convention into the database
	 *
	 * If a convention with the given year (or current) exists already, then
	 * update it with new information. Otherwise insert a new one into the
	 * database.
	 *
	 * @param Request $request Request with PUT data
	 * @param Convention $convention
	 *
	 * @return View
	 * @throws HttpException
	 */
	public function putAction( Request $request, Convention $convention ) {
		$convention->start_date = new \DateTime( $request->get( 'start_date' ) );
		$convention->end_date = new \DateTime( $request->get( 'end-date' ) );
		$convention->active = $request->get( 'active' );

		/** @var \Symfony\Component\Validator\Validator $validator */
		$validator = $this->get( 'validator' );
		$errors = $validator->validate( $convention );
		if ( $errors ) {
			return new Response( (string)$errors, Response::HTTP_BAD_REQUEST );
		}

		return $this->getAction( $convention );
	}

	/**
	 * Make a new convention
	 *
	 * @param Request $request
	 *
	 * @return View|Response
	 */
	public function postAction( Request $request ) {
		$convention = new Convention( new \DateTime( $request->get( 'start_date' ) ) );
		$convention->end_date = new \DateTime( $request->get( 'end_date' ) );
		$convention->active = (bool)$request->get( 'active' );

		/** @var \Symfony\Component\Validator\Validator $validator */
		$validator = $this->get( 'validator' );
		$errors = $validator->validate( $convention );
		if ( $errors ) {
			return new Response( (string)$errors, Response::HTTP_BAD_REQUEST );
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist( $convention );
		$em->flush();

		return $this->getAction( $convention );
	}
}
