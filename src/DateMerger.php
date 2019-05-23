<?php


namespace Penance316\Merger;

class DateMerger {

    public static function test()
    {
        return 'hello world';
    }

    /**
     * Merge ranges into continuous ranges for overlapping ranges.
     *
     * @param \DateTime[] $ranges
     *   Array of PHP DateTime objects.
     *
     * @return \DateTime[][]
     */
    public static function mergeRanges(array $ranges): array
    {
        // Sort by start dates.
        usort($ranges, function($a, $b) {
            return $a[0] <=> $b[0];
        });

        $stack = [];

        // Add earliest range.
        array_push($stack, $ranges[0]);

        foreach (array_slice($ranges, 1) as $range) {
            $top = &$stack[count($stack) - 1];

            if ($top[1] < $range[0]) {
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