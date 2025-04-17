<?php
  include_once("utils/storage.php");

  class CarStorage extends Storage
  {
    public function __construct()
    {
      parent::__construct(new JsonIO("data/cars.json")); 
    }
  }