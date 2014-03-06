#!/usr/bin/env php
<?php

  /**
   * This is the sample of using HaircuttersCalculator as CLI.
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
include 'classes/HaircuttersCalculator/Calculator.php';

$HC = new HaircuttersCalculator\Calculator();

/**
 * Help output
 */
function showHelp($cli_cmd, $params)
{
  echo 'Usage:'.PHP_EOL;
  echo $cli_cmd.' [--paramater1=value1 [--parameter2=value2 ... [--parameterN=valueN]]]'.PHP_EOL;
  echo 'Allowed paramaters:'.PHP_EOL;
  foreach($params as $name=>$value){
    echo "    --".str_pad($name.'='.gettype($value),35)."\tDefault\t$value\n";
  }
}

if(1 < sizeof($argv)){
  if($argv[ 1 ] == '--help'){
    $params = $HC->getParameter();
    die(showHelp($argv[ 0 ], $params));
  }
  foreach( $argv as $argument ) {
    if( $argument == $argv[ 0 ] ) continue;

    $pair = explode( "=", $argument );
    $variableName = substr( $pair[ 0 ], 2 );
    $variableValue = isset($pair[ 1 ]) ? $pair[ 1 ] : null;
    try {
      $HC->setParameter($variableName, $variableValue);
    } catch (Exception $e) {
        echo 'Error: '.$e->getMessage().PHP_EOL;
        $params = $HC->getParameter();
        die(showHelp($argv[ 0 ], $params));
    }
  }
}

echo "Input data:".PHP_EOL;
print_r($HC->getParameter());
echo 'Result: '.$HC->calculate().' haircutters needed.';

echo PHP_EOL;