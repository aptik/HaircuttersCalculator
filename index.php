<?php

  /**
   * This is the main web entry point for the HaircuttersCalculator.
   * 
   * In this file I will load main working class, which will make
   * all calculations. Also will be loaded all support files to show 
   * user interface and get user input data.
   * 
   * PHP version 5.3+ (I'm using namespaces)
   *
   * @package HaircuttersCalculator
   * @author Arthur Halma <arthur.halma@gmail.com>
   * @version 1.0.0 Very unstable.
   * @license This work is licensed under the Creative Commons 
   * Attribution-NonCommercial-NoDerivatives 4.0 International License
   * To view a copy of this license, visit
   * http://creativecommons.org/licenses/by-nc-nd/4.0
   */
  
  /**
   * I used include there instead of include_once or require because 
   * Im sure I will include this file only once so no need to use more
   * slowly function.
   * Also I'm not used any autoloder algorithm since I have no need it
   * for only two files
   * @see http://php.net/manual/en/function.include.php
   * @see http://php.net/manual/en/function.include-once.php
   * @see http://php.net/manual/en/function.require.php
   */
  include 'classes/HaircuttersCalculator/Calculator.php';

  $HC = new HaircuttersCalculator\Calculator();

  // Have an AJAX request there:
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $HC->setParameter($_REQUEST);
    die(json_encode($HC->calculate()));
  }

  $results = $HC->calculate();
  $params = $HC->getParameter();

  // Im not wrote any parser since it is hust an example
  include 'webUI/template.html';
