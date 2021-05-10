<?php

namespace JPustkuchen\TableClassBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JPustkuchenTableClassBundle extends Bundle {
  public function getPath(): string {
    return \dirname(__DIR__);
  }
}
