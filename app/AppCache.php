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

require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

/**
 * Symfony reverse-proxy implementation, in case Varnish is not
 * available.
 */
class AppCache extends HttpCache
{
}
