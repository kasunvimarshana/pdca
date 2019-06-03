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