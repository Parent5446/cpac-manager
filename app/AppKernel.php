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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
	public function registerBundles() {
		$bundles = [
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\SecurityBundle\SecurityBundle(),
			new Symfony\Bundle\TwigBundle\TwigBundle(),
			new Symfony\Bundle\MonologBundle\MonologBundle(),
			new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
			new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new FOS\UserBundle\FOSUserBundle(),
			new Cpac\ManagerBundle\CpacManagerBundle(),
			new Cpac\CommonBundle\CpacCommonBundle(),
		];

		if ( in_array( $this->getEnvironment(), [ 'dev', 'test' ] ) ) {
			$bundles[ ] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			$bundles[ ] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[ ] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
		}

		return $bundles;
	}

	public function registerContainerConfiguration( LoaderInterface $loader ) {
		$loader->load( __DIR__ . '/config/config_' . $this->getEnvironment() . '.yml' );
	}
}
