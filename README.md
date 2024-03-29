# DateMerger   [![Build Status](https://app.travis-ci.com/penance316/merger.svg?branch=master)](https://app.travis-ci.com/penance316/merger)

A PHP based date merger that combines ~~overlapping~~ continuous date ranges.

Available via composer

`composer require penance316/merger`

## Usage
```PHP

// Each date pair should consist of [earlierDate, laterDate].

$dates = [
    [new DateTime('2019-04-01'), new DateTime('2019-05-01')],
    [new DateTime('2019-05-01'), new DateTime('2019-06-01')],
    [new DateTime('2019-06-01'), new DateTime('2019-07-01')],
    [new DateTime('2019-07-01'), new DateTime('2019-08-01')],
    [new DateTime('2019-08-01'), new DateTime('2019-09-01')],
];

print_r(DateMerger::mergeRanges($dates));

// Output
// Array
// (
//     [0] => Array
//         (
//             [0] => DateTime Object
//                 (
//                     [date] => 2019-04-01 00:00:00.000000
//                     [timezone_type] => 3
//                     [timezone] => Europe/London
//                 )
// 
//             [1] => DateTime Object
//                 (
//                     [date] => 2019-09-01 00:00:00.000000
//                     [timezone_type] => 3
//                     [timezone] => Europe/London
//                 )
//
//         )
//
// )
```

## License

MIT
