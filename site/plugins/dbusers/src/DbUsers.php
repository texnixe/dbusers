<?php

use Kirby\Cms\Users;

class DbUsers extends Users
{

  public function create($data)
  {
    return DbUser::create($data);
  }

}