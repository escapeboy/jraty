<?php namespace Escapeboy\Jraty\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class Jraty extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'jraty'; }
 
}