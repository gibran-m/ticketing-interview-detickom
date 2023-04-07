# ticketing-interview-detickom

Installation

1. setting Konfigurasi Database (server, username, password, database name) pada file db/config.php

2. jalankan migration database, dengan memanggil file migration menggunakan php-cli
    ex: php db/migration.php
    
3. generate ticket, dengan memanggil file generateTicket.php menggunakan php-cli
    ex : php generate-ticket.php {event_id} {total_ticket}
         php generate-ticket.php 3 1000
         
4. jalankan api pada folder root project
    ex :  php -S localhost:8000 

5. untuk memanggil api cekStatus : {{url}}/api/cekStatus.php 
  type request body : json
  ex :
  {
    "event_id" : "3",
    "ticket_code" : "DTK1r178QV"
  }
  
 5. untuk memanggil api updateStatus : {{url}}/api/updateStatus.php 
  type request body : json
  ex :
  {
      "event_id" : "3",
      "ticket_code" : "DTK1r178QV",
      "status" : "claimed"
  }