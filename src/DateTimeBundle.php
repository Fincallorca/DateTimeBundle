<?php

declare( strict_types=1 );

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
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new DateTimeBundleExtension();
    }
}
