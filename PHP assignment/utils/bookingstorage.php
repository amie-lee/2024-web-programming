<?php
  include_once("utils/storage.php");

  class BookingStorage extends Storage
  {
    public function __construct()
    {
      parent::__construct(new JsonIO("data/bookings.json")); 
    }
  }