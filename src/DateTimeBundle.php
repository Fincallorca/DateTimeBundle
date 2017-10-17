<?php

namespace Fincallorca\DateTimeBundle;

use Fincallorca\DateTimeBundle\DependencyInjection\DateTimeBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DateTimeBundle
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeBundle extends Bundle
{

	public function getContainerExtension()
	{
		return new DateTimeBundleExtension();
	}
}