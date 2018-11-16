<?php
/**
 * Created by IntelliJ IDEA.
 * User: pc
 * Date: 11/16/2018
 * Time: 13:58
 */


use Frame\Queue\Quer;

include 'Frame/Queue/Quer.php';


Quer::insert(1, function () {
    print date('Y-m-d H:i:s')."--per 1 second--\n";
});

Quer::insert(5, function () {
    print date('Y-m-d H:i:s')."--per 5 second--\n";
});

Quer::insert('07:08:00', function () {
    print date('Y-m-d H:i:s')." --at 15:07:00 --\n";
},Quer::EXPECT | Quer::DAILY);

Quer::loop();