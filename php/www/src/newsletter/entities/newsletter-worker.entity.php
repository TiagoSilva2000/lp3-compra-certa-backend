<?php

  class NewsletterWorker {

    public static function sendEmails(): int {
      $sentEmails = 0;
      $emails = [];
      /* 
        TODO: Retrieve emails from the database
      */

      foreach($emails as &$email) {
        if ($email->isAllowed()) {
          NewsletterWorker::sendTo($email->getEmail());
          $sentEmails += 1;
          /* 
            Send emails to each allowed email address
          */
        }
      }

      return $sentEmails;
    }

    private static function sendTo(string $email) {
      /*
        send email; 
      */
    }

  }


?>