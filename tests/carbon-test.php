<?php
$dt = Carbon::create(2012, 1, 31, 12, 0, 0);
echo $dt->startOfDay();     // 2012-01-31 00:00:00
echo $dt->endOfDay();       // 2012-01-31 23:59:59
echo $dt->startOfMonth();   // 2012-01-01 00:00:00
echo $dt->endOfMonth();     // 2012-01-31 23:59:59
echo $dt->startOfYear();    // 2012-01-01 00:00:00
echo $dt->endOfYear();      // 2012-12-31 23:59:59
echo $dt->startOfDecade();  // 2010-01-01 00:00:00
echo $dt->endOfDecade();    // 2019-12-31 23:59:59
echo $dt->startOfCentury(); // 2000-01-01 00:00:00
echo $dt->endOfCentury();   // 2099-12-31 23:59:59
echo $dt->startOfWeek();    // 2012-01-30 00:00:00
echo $dt->endOfWeek();      // 2012-02-05 23:59:59

echo Carbon::now()->subDays(5)->diffForHumans();  // 5 days ago

echo Carbon::now()->addYear()->diffForHumans();    // in 1 Jahr

$knownDate = Carbon::create(2001, 5, 21, 12);  // create testing date
Carbon::setTestNow($knownDate);                     // set the mock 
echo Carbon::now();    
?>

<script>
    moment().startOf('year');
    moment().startOf('year').format('MM/DD/YYYY');
    
    moment().startOf('year');    // set to January 1st, 12:00 am this year
    moment().startOf('month');   // set to the first of this month, 12:00 am
    moment().startOf('quarter');  // set to the beginning of the current quarter, 1st day of months, 12:00 am
    moment().startOf('week');    // set to the first day of this week, 12:00 am
    moment().startOf('isoWeek'); // set to the first day of this week according to ISO 8601, 12:00 am
    moment().startOf('day');     // set to 12:00 am today
    moment().startOf('date');     // set to 12:00 am today
    moment().startOf('hour');    // set to now, but with 0 mins, 0 secs, and 0 ms
    moment().startOf('minute');  // set to now, but with 0 seconds and 0 milliseconds
    moment().startOf('second');  // same as moment().milliseconds(0);
    
    moment().startOf('year');
    moment().month(0).date(1).hours(0).minutes(0).seconds(0).milliseconds(0);
</script>