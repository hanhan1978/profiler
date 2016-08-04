<?php

require('./pro.php');

$p = new Profiler();
$p->probe();
usleep(40000);
$p->probe();
usleep(5000);
$p->probe();
usleep(90000);
$p->probe_end();