<?php

if (preg_match ("/[^\w\-\.\/\\\]+/i", "PHP_\./-8")) {
    print "A match was found.";
} else {
    print "A match was not found.";
}

