<?php

use Penance316\Merger\DateMerger;

require 'vendor/autoload.php';


$dates = [
    [new DateTime('2019-04-01'), new DateTime('2019-05-01')],
    [new DateTime('2019-05-01'), new DateTime('2019-06-01')],
    [new DateTime('2019-06-01'), new DateTime('2019-07-01')],
    [new DateTime('2019-07-01'), new DateTime('2019-08-01')],
    [new DateTime('2019-08-01'), new DateTime('2019-09-01')],
];

echo DateMerger::test();

print "<pre>";
print_r(DateMerger::mergeRanges($dates));
print "</pre>";