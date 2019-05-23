<?php

use Penance316\Merger\DateMerger;
use PHPUnit\Framework\TestCase;

class DateMergerTest extends TestCase {

    const DATE_FORMAT = "Y-m-d";

    public function testTest()
    {
        $results = DateMerger::test();
        $this->assertEquals('hello world', $results);
    }

    /**
     * Should merge down into 1 range.
     */
    public function testAllOverlapRanges()
    {

        $dates = [
            [new DateTime('2019-04-01'), new DateTime('2019-05-01')],
            [new DateTime('2019-05-01'), new DateTime('2019-06-01')],
            [new DateTime('2019-06-01'), new DateTime('2019-07-01')],
            [new DateTime('2019-07-01'), new DateTime('2019-08-01')],
            [new DateTime('2019-08-01'), new DateTime('2019-09-01')],
        ];

        $results = DateMerger::mergeRanges($dates);
        $this->assertEquals(1, count($results));
    }

    /**
     * Should merge the inner ranges into the surrounding range.
     */
    public function testMergeInsideRanges()
    {
        $dates = [
            [new DateTime('2019-04-01'), new DateTime('2019-09-01')],
            [new DateTime('2019-05-01'), new DateTime('2019-06-01')],
            [new DateTime('2019-06-01'), new DateTime('2019-07-01')],
            [new DateTime('2019-07-01'), new DateTime('2019-08-01')],
        ];

        $results = DateMerger::mergeRanges($dates);
        $this->assertEquals(1, count($results));
    }

    public function testMultipleRanges()
    {
        $dates = [
            [new DateTime('2019-04-01'), new DateTime('2019-09-01')],
            [new DateTime('2019-05-01'), new DateTime('2019-10-01')],
            [new DateTime('2019-06-01'), new DateTime('2019-10-01')],
            // Should be new range as no overlap.
            [new DateTime('2020-01-01'), new DateTime('2020-05-01')],
            [new DateTime('2020-04-01'), new DateTime('2020-07-01')],
            [new DateTime('2020-05-01'), new DateTime('2020-07-01')],
        ];

        $results = DateMerger::mergeRanges($dates);

        $expectedRange1 = ['2019-04-01', '2019-10-01'];
        $expectedRange2 = ['2020-01-01', '2020-07-01'];

        $this->assertEquals(2, count($results));
        $this->assertEquals($expectedRange1[0], $results[0][0]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange1[1], $results[0][1]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange2[0], $results[1][0]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange2[1], $results[1][1]->format(self::DATE_FORMAT));
    }
}
