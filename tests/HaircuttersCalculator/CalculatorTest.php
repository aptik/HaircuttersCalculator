<?php

use HaircuttersCalculator\Calculator as Calculator;
class CalculatorTest extends \PHPUnit_Framework_TestCase
{

  /**
   * Checking if initial parameters are set correct
   */
  public function testInitialParameters()
  {
    $var = new Calculator();
    $this->assertSame(50000000, \PHPUnit_Framework_Assert::readAttribute($var, '_population'));
    $this->assertSame(54.0, \PHPUnit_Framework_Assert::readAttribute($var, '_man_rate'));
    $this->assertSame(30, \PHPUnit_Framework_Assert::readAttribute($var, '_shear_time_man'));
    $this->assertSame(60, \PHPUnit_Framework_Assert::readAttribute($var, '_shear_time_woman'));
    $this->assertSame(12, \PHPUnit_Framework_Assert::readAttribute($var, '_shears_per_year'));
    $this->assertSame(345.25, \PHPUnit_Framework_Assert::readAttribute($var, '_haircutters_working_days'));
    $this->assertSame(432, \PHPUnit_Framework_Assert::readAttribute($var, '_haircutters_working_minutes'));
  }

  /**
   * Checking if pass arguments via constructor working well
   */
  public function testSetParametersViaConstructor()
  {
    $var = new Calculator(1,22.2,'3',4,2,null,'1');
    $this->assertEquals(1, \PHPUnit_Framework_Assert::readAttribute($var, '_population'));
    $this->assertEquals(22.2, \PHPUnit_Framework_Assert::readAttribute($var, '_man_rate'));
    $this->assertEquals(3, \PHPUnit_Framework_Assert::readAttribute($var, '_shear_time_man'));
    $this->assertEquals(4, \PHPUnit_Framework_Assert::readAttribute($var, '_shear_time_woman'));
    $this->assertEquals(2, \PHPUnit_Framework_Assert::readAttribute($var, '_shears_per_year'));
    $this->assertEquals(345.25, \PHPUnit_Framework_Assert::readAttribute($var, '_haircutters_working_days'));
    $this->assertEquals(1, \PHPUnit_Framework_Assert::readAttribute($var, '_haircutters_working_minutes'));
  }

  /**
   * Checking that exception on wrong user data input working well
   * @expectedException        Exception
   */
  public function testSetParametersViaConstructorException()
  {
    new Calculator(1,22.2,'3',4,1,'.5a','1');
  }

  /**
   * Checking if pass arguments via constructor as array working well
   */
  public function testSetParametersViaConstructorArray()
  {
    $var = new Calculator(array('population'=>2));
    $this->assertEquals(2, \PHPUnit_Framework_Assert::readAttribute($var, '_population'));
  }

  /**
   * Checking that exception on wrong user data input working well
   * @expectedException        Exception
   */
  public function testSetParametersViaConstructorArrayException()
  {
    new Calculator(array('population'=>2),3);
  }

  /**
   * Checking of passing arguments via setParameter() as arguments
   */
  public function testsetParameterFunctionArguments(){
    $var = new Calculator();
    $var->setParameter('population',50000001);
    $this->assertEquals(50000001, \PHPUnit_Framework_Assert::readAttribute($var, '_population'));
  }

  /**
   * Checking of passing arguments via setParameter() as array
   */
  public function testsetParameterFunctionArray(){
    $var = new Calculator();
    $var->setParameter(array(
      'man_rate'=>54,
      'haircutters_working_days'=>10
    ));
    $this->assertEquals(54, \PHPUnit_Framework_Assert::readAttribute($var, '_man_rate'));
    $this->assertEquals(10, \PHPUnit_Framework_Assert::readAttribute($var, '_haircutters_working_days'));
  }

  /**
   * Checking that exception on wrong user data input working well
   * @expectedException        Exception
   */
  public function testsetParameterFunctionArrayException()
  {
    $var = new Calculator();
    $var->setParameter(array('man_rate'=>54),2);
  }

  /**
   * Checking of getting arguments via getParameter() as arguments
   */
  public function testgetParameterFunctionArguments(){
    $var = new Calculator();
    $params = $var->getParameter('population','man_rate');
    $this->assertEquals($params,array(
      'population'=>\PHPUnit_Framework_Assert::readAttribute($var, '_population'),
      'man_rate'=>\PHPUnit_Framework_Assert::readAttribute($var, '_man_rate')
    ));
  }

  /**
   * Checking of getting all allowed arguments
   */
  public function testgetParameterFunctionArray(){
    $var = new Calculator();
    $allowed_arguments = \PHPUnit_Framework_Assert::readAttribute($var, '_arguments');
    $expected_array = array();
    foreach($allowed_arguments as $name){
      $expected_array[$name] = \PHPUnit_Framework_Assert::readAttribute($var, "_{$name}");
    }
    $params = $var->getParameter();
    $this->assertEquals($expected_array, $params);
  }

  /**
   * Checking that exception in case user want to get not allowd
   * parameter working well
   * @expectedException        Exception
   */
  public function testgetParameterFunctionArrayException()
  {
    $var = new Calculator();
    $var->getParameter('not_existing_paramater');
  }

  /**
   * Checking that all calculations doing well (by next formula):
   * mans = population * ( man_rate / 100 )
   * womans = population - mans
   * haircutter_time_have = haircutters_working_days * haircutters_working_minutes;
   * 
   * womans * shear_time_woman
   * result = (mans * shear_time_man + womans * shear_time_woman ) / haircutter_time_have
   */
  public function testCaclulate()
  {
    $var = new Calculator(10000,60,30,60,12,365,480);
    $result = $var->calculate();
    $this->assertEquals(29, $result);
  }

}
