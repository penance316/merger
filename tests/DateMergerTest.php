<?php

namespace Penance316\Tests;

use DateTime;
use Penance316\Merger\DateMerger;
use PHPUnit\Framework\TestCase;

class DateMergerTest extends TestCase {

    const DATE_FORMAT = "Y-m-d";

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
            [new DateTime('2019-09-02'), new DateTime('2018-09-05')],
        ];

        $results = DateMerger::mergeRanges($dates);
        $this->assertCount(1, $results);
    }

  /**
   * Test when supplying empty data set.
   */
    public function testEmptyResults() {
      $dates = [];

      $results = DateMerger::mergeRanges($dates);
      $this->assertIsArray($results);
      $this->assertCount(0, $results);
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
        $this->assertCount(1, $results);
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

        $this->assertCount(2, $results);
        $this->assertEquals($expectedRange1[0], $results[0][0]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange1[1], $results[0][1]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange2[0], $results[1][0]->format(self::DATE_FORMAT));
        $this->assertEquals($expectedRange2[1], $results[1][1]->format(self::DATE_FORMAT));
    }
}
