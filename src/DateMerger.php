<?php


namespace Penance316\Merger;

class DateMerger {

    /**
     * Merge overlapping date ranges.
     *
     * @param array([\DateTime,\DateTime]) $ranges
     *   Array of pairs of DateTime objects indicating start and end of a date range.
     *  [[new DateTime('2019-04-01'), new DateTime('2019-05-01')], [new DateTime('2020-04-01'), new DateTime('2020-05-01')]].
     *
     * @return \DateTime[][]
     */
    public static function mergeRanges(array $ranges): array
    {
        $stack = [];

        if (empty($ranges)) {
          return $stack;
        }

        // Sort by start dates.
        usort($ranges, function($a, $b) {
            return $a[0] <=> $b[0];
        });

        // Add earliest range.
        array_push($stack, $ranges[0]);

        foreach (array_slice($ranges, 1) as $range) {
            $top = &$stack[count($stack) - 1];

            //check if more than 1 day away otherwise can just be merged.
            $interval = date_diff($top[1], $range[0]);

            if ($interval->days === 1) {
              // We assume the date ranges are always formatted [earlier, later]
              $top[1] = $range[1];
            } elseif ($top[1] < $range[0]) {
                // Its a new one so push to stack
                array_push($stack, $range);
            } elseif
            ($top[1] < $range[1]) {
                $top[1] = $range[1];
            }
        }

        return $stack;
    }
}
