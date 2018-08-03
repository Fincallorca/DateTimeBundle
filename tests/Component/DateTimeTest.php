<?php
/**
 * Created by PhpStorm.
 * User: falko
 * Date: 7/27/18
 * Time: 11:46 AM
 */

namespace Test\Fincallorca\DateTimeBundle\Component;

use Fincallorca\DateTimeBundle\Component\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		date_default_timezone_set('UTC');
	}

	public function testToday()
	{
		$today = new \DateTime('now');
		$today->setTimezone(new \DateTimeZone('UTC'));

		self::assertEquals($today->format('Y-m-d'), DateTime::today()->format('Y-m-d'));
	}

	public static function testCurrentDateTime()
	{
		$dateTime1 = DateTime::currentDateTime();
		$dateTime2 = DateTime::currentDateTime();
		self::assertNotEquals($dateTime1, $dateTime2);

		$today = new \DateTime('now');
		self::assertLessThan(1000000, abs((int) $today->diff($dateTime1)->format('%f')));
	}

	/**
	 * @covers DateTime::createFromObject
	 * @covers DateTime::createFromFormat
	 */
	public static function testCreateFromObject()
	{
		$dateTime1 = DateTime::createFromObject(new \DateTime('2016-07-13T19:25:47+07:00'));
		$dateTime2 = DateTime::createFromFormat('Y-m-d H:i:s', '2016-07-13 19:25:47', new \DateTimeZone('+07:00'));

		self::assertEquals($dateTime1, $dateTime2);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Failed to parse time string (abc) at position 0 (a): The timezone could not be found in the database
	 */
	public static function testCreateFromObjectException()
	{
		DateTime::createFromObject('abc');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid arguments for createFromFormat().
	 */
	public static function testCreateFromFormatException()
	{
		DateTime::createFromFormat('Y-m-d', 'I do not want to submit valid parameters!');
	}
}
