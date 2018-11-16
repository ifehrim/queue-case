# Quer of PHP


## What is it
The Quer class provides the main functionalities of a prioritized queue, implemented using a max heap.


## Installation
     use alim:
     php alim install Queue
     use git:
     git clone https://github.com/ifehrim/queue-case.git


### example files:

[work](./work.php)




### how to use ?

-  step:1# insert queue:
   
        Quer::insert('insert after sleep second after run the func', function () {
            print date('Ymd H:i:s')."--per 1 second--\n";
        });
        
-  allow actions:

        Command [tick,loop]
    
-  step:2# register child process:        
        
        Quer::tick(); its once
        Quer::loop(); ever loop
       
-  step:3# example: 
        php work.php
       
test result:

    :) adem processer-case $ php work.php
     2018-11-16 07:07:46--per 1 second--
     2018-11-16 07:07:47--per 1 second--
     2018-11-16 07:07:48--per 1 second--
     2018-11-16 07:07:49--per 1 second--
     2018-11-16 07:07:50--per 1 second--
     2018-11-16 07:07:50--per 5 second--
     2018-11-16 07:07:51--per 1 second--
     2018-11-16 07:07:52--per 1 second--
     2018-11-16 07:07:53--per 1 second--
     2018-11-16 07:07:54--per 1 second--
     2018-11-16 07:07:55--per 1 second--
     2018-11-16 07:07:55--per 5 second--
     2018-11-16 07:07:56--per 1 second--
     2018-11-16 07:07:57--per 1 second--
     2018-11-16 07:07:58--per 1 second--
     2018-11-16 07:07:59--per 1 second--
     2018-11-16 07:08:00--per 1 second--
     2018-11-16 07:08:00 --at 15:07:00 --
     2018-11-16 07:08:00--per 5 second--
     2018-11-16 07:08:01--per 1 second--
     2018-11-16 07:08:02--per 1 second--
     2018-11-16 07:08:03--per 1 second--
     2018-11-16 07:08:05--per 1 second--
     2018-11-16 07:08:05--per 5 second--
     2018-11-16 07:08:06--per 1 second--
     2018-11-16 07:08:07--per 1 second--
     2018-11-16 07:08:08--per 1 second--

    

