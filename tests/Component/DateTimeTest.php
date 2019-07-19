<?php

namespace Fincallorca\DateTimeBundle\Test\Component;

use DateTimeZone;
use Exception;
use Fincallorca\DateTimeBundle\Component\DateTime;
use Fincallorca\DateTimeBundle\Component\DateTimeKernel;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{

    public function setUp(): void
    {
        // server timezone is UTC
        date_default_timezone_set('UTC');
    }

    public function testToday()
    {
        $today = new \DateTime('now');
        $today->setTimezone(new DateTimeZone('UTC'));

        self::assertEquals($today->format('Y-m-d'), DateTime::today()->format('Y-m-d'));
    }

    /**
     * @throws Exception
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
     * @covers \Fincallorca\DateTimeBundle\Component\DateTime::createFromObject()
     * @covers \Fincallorca\DateTimeBundle\Component\DateTime::createFromFormat()
     *
     * @throws Exception
     */
    public static function testCreateFromObject()
    {
        $dateTime1 = DateTime::createFromObject(new \DateTime('2016-07-13T19:25:47+07:00'));
        $dateTime2 = DateTime::createFromFormat('Y-m-d H:i:s', '2016-07-13 19:25:47', new DateTimeZone('+07:00'));

        self::assertEquals($dateTime1, $dateTime2);
    }

    /**
     * @throws Exception
     */
    public function testCreateFromFormatException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot create an object by DateTime::createFromFormat().');

        DateTime::createFromFormat('Y-m-d', 'I do not want to submit valid parameters!');
    }

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        self::assertEquals(get_class(DateTime::create()), DateTime::class);
    }

    /**
     * @throws Exception
     */
    public function testDuplicate()
    {
        $dateTime1 = DateTime::create();
        $dateTime2 = $dateTime1->duplicate();

        // content of date time equals
        self::assertEquals($dateTime1->format('U.u'), $dateTime2->format('U.u'));
        // but objects are not the same
        self::assertNotSame($dateTime1, $dateTime2);
    }

    /**
     * @throws Exception
     */
    public function testToServerDateTime()
    {
        $dateTime1 = DateTime::create('2019-07-19 17:54:03', new DateTimeZone('Europe/Berlin'));
        $dateTime1->toServerDateTime();

        // Berlin has +2 hours difference (in summer) towards UTC
        self::assertEquals('2019-07-19 15:54:03', $dateTime1->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToDatabaseDateTime()
    {
        // database timezone is UTC
        DateTimeKernel::setTimeZoneDatabase(new DateTimeZone('UTC'));

        $dateTime1 = DateTime::create('2019-12-07 04:19:22', new DateTimeZone('Asia/Bangkok'));
        $dateTime1->toDatabaseDateTime();

        // Bangkok has +7 hours difference (in winter) towards UTC
        self::assertEquals('2019-12-06 21:19:22', $dateTime1->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToClientDateTime()
    {
        // cline timezone is 'Europe/London'
        DateTimeKernel::setTimeZoneClient(new DateTimeZone('Europe/London'));

        // some inserted time is in timezone 'America/New_York'
        $dateTime1 = DateTime::create('2019-11-19 16:17:35', new DateTimeZone('America/New_York'));
        $dateTime1->toClientDateTime();

        // London has -5 hours difference towards New York
        self::assertEquals('2019-11-19 21:17:35', $dateTime1->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testAddHours()
    {
        $dateTime = DateTime::create('2019-12-31 16:17:35');

        self::assertEquals('2020-01-01 00:17:35', $dateTime->addHours(8)->format('Y-m-d H:i:s'));
        self::assertEquals('2019-12-30 02:17:35', $dateTime->addHours(-46)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testSubHours()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-08-16 03:14:57', $dateTime->subHours(100)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testAddDays()
    {
        $dateTime = DateTime::create('2019-12-31 16:17:35');

        self::assertEquals('2020-01-08 16:17:35', $dateTime->addDays(8)->format('Y-m-d H:i:s'));
        self::assertEquals('2019-11-23 16:17:35', $dateTime->addDays(-46)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testSubDays()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-05-12 07:14:57', $dateTime->subDays(100)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testAddMonth()
    {
        $dateTime = DateTime::create('2019-12-31 16:17:35');

        self::assertEquals('2020-08-31 16:17:35', $dateTime->addMonth(8)->format('Y-m-d H:i:s'));
        self::assertEquals('2016-10-31 16:17:35', $dateTime->addMonth(-46)->format('Y-m-d H:i:s'));

        // special case: add one month to the 31th of October = not November, 31st but November, 30th!
        self::assertEquals('2016-11-30 16:17:35', $dateTime->addMonth(1)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testSubMonth()
    {
        $dateTime = DateTime::create('2019-12-31 16:17:35');

        self::assertEquals('2011-08-31 16:17:35', $dateTime->subMonth(100)->format('Y-m-d H:i:s'));

        // special case: sub two month from the 31th of August = not June, 31st but June, 30th!
        self::assertEquals('2011-06-30 16:17:35', $dateTime->subMonth(2)->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToEndOfDay()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-08-20 23:59:59', $dateTime->toEndOfDay()->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToStartOfDay()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-08-20 00:00:00', $dateTime->toStartOfDay()->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToStartOfMonth()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-08-01 00:00:00', $dateTime->toStartOfMonth()->format('Y-m-d H:i:s'));
        self::assertEquals('1978-08-01 00:00:00', $dateTime->toStartOfMonth()->format('Y-m-d H:i:s'));
    }

    /**
     * @throws Exception
     */
    public function testToEndOfMonth()
    {
        $dateTime = DateTime::create('1978-08-20 07:14:57');

        self::assertEquals('1978-08-31 23:59:59', $dateTime->toEndOfMonth()->format('Y-m-d H:i:s'));
        self::assertEquals('1978-08-31 23:59:59', $dateTime->toEndOfMonth()->format('Y-m-d H:i:s'));
    }

}
