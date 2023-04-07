# ticketing-interview-detickom

Installation

1. setting konfigurasi (servername, username, password, database name, token) pada file db/config.php

2. jalankan migration database, dengan memanggil file migration menggunakan php-cli
    ex: php db/migration.php
    
3. generate ticket, dengan memanggil file generateTicket.php menggunakan php-cli
    ex : php generateTicket.php {event_id} {total_ticket}
         php generateTicket.php 3 1000
         
4. jalankan api pada folder root project
    ex :  php -S localhost:8000 

5. untuk memanggil api cekStatus : {{url}}/api/cekStatus.php 
    -type request body : json
        ex :
        {
            "event_id" : "3",
            "ticket_code" : "DTK1r178QV"
        }
    
    -authorization : bearer token
   
  
 5. untuk memanggil api updateStatus : {{url}}/api/updateStatus.php 
    -type request body : json
        ex :
        {
            "event_id" : "3",
            "ticket_code" : "DTK1r178QV",
            "status" : "claimed"
        }

    -authorization : bearer token
