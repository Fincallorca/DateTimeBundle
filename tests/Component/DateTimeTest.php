<?php

namespace Fincallorca\DateTimeBundle\Test\Component;

use DateTimeZone;
use Exception;
use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeKernel;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeTest
 *
 * @package Fincallorca\DateTimeBundle
 */
class DateTimeTest extends TestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        // server timezone is UTC
        date_default_timezone_set('UTC');
        // database timezone is UTC
        DateTimeKernel::setTimeZoneDatabase(new DateTimeZone('UTC'));
        // client timezone is 'Europe/London'
        DateTimeKernel::setTimeZoneClient(new DateTimeZone('Europe/London'));
    }

    /**
     * @throws Exception
     *
     * @todo remove in v2.0
     */
    public function testToday()
    {
        $today = new \DateTime('now');
        $today->setTimezone(new DateTimeZone('UTC'));

        self::assertEquals($today->format('Y-m-d'), DateTime::today()->format('Y-m-d'));
    }

    /**
     * @throws Exception
     *
     * @todo remove in v2.0
     */
    public static function testCurrentDateTime()
    {
        $dateTime1 = DateTime::currentDateTime();
        $dateTime2 = DateTime::currentDateTime();
        self::assertNotEquals($dateTime1, $dateTime2);

        $today = new \DateTime('now');
        self::assertLessThan(1000000, abs((int) $today->diff($dateTime1)->format('%f')));
    }

    /**
     * @throws Exception
     */
    public function testToServerDateTime()
    {
        $dateTimeOrigin = DateTime::create('2019-07-19 17:54:03', new DateTimeZone('Europe/Berlin'));
        $dateTimeServer = $dateTimeOrigin->toServerDateTime();

        // check for "same" object
        self::assertSame($dateTimeOrigin, $dateTimeServer);
        self::assertInstanceOf(DateTime::class, $dateTimeOrigin);
        self::assertInstanceOf(DateTime::class, $dateTimeServer);

        // Berlin has +2 hours difference (in summer) towards UTC
        self::assertEquals('2019-07-19 15:54:03', $dateTimeServer->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToDatabaseDateTime()
    {
        $dateTimeOrigin   = DateTime::create('2019-12-07 04:19:22', new DateTimeZone('Asia/Bangkok'));
        $dateTimeDatabase = $dateTimeOrigin->toDatabaseDateTime();

        // check for "same" object
        self::assertSame($dateTimeOrigin, $dateTimeDatabase);
        self::assertInstanceOf(DateTime::class, $dateTimeOrigin);
        self::assertInstanceOf(DateTime::class, $dateTimeDatabase);

        // Bangkok has +7 hours difference (in winter) towards UTC
        self::assertEquals('2019-12-06 21:19:22', $dateTimeDatabase->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToClientDateTime()
    {
        // some inserted time is in timezone 'America/New_York'
        $dateTimeOrigin = DateTime::create('2019-11-19 16:17:35', new DateTimeZone('America/New_York'));
        $dateTimeClient = $dateTimeOrigin->toClientDateTime();

        // check for "same" object
        self::assertSame($dateTimeOrigin, $dateTimeClient);
        self::assertInstanceOf(DateTime::class, $dateTimeOrigin);
        self::assertInstanceOf(DateTime::class, $dateTimeClient);

        // London has -5 hours difference towards New York
        self::assertEquals('2019-11-19 21:17:35', $dateTimeClient->format('Y-m-d H:i:s'));
    }

}
