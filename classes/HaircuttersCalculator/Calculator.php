<?php
namespace HaircuttersCalculator;

/**
 * HaircuttersCalculator doing all calculation logic.
 *
 * Depends on paramaters like population HaircuttersCalculator will
 * approximate number of haircutters in this country.
 * There are methods to change default parameters and get results.
 *
 * @package HaircuttersCalculator
 * @author Arthur Halma <arthur.halma@gmail.com>
 * @version 1.0.0 Very unstable.
 * @since Class available since Release 1.0.0
 * @license This work is licensed under the Creative Commons 
 * Attribution-NonCommercial-NoDerivatives 4.0 International License
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by-nc-nd/4.0 
 */
class Calculator{
  
  // {{{ properties

    /**
     * List of arguments that user allowed to change.
     *
     * @var array();
     * @access private
     */
    private $_arguments = array(
      'population',
      'man_rate',
      'shear_time_man',
      'shear_time_woman',
      'shears_per_year',
      'haircutters_working_days',
      'haircutters_working_minutes'
    );

    /**
     * The count of population at all.
     *
     * @var integer
     * @access private
     */
    private $_population = 50000000;

    /**
     * The mans rate.
     *
     * @var float
     * @access private
     */
    private $_man_rate = 54.0;

    /**
     * Approximate time needed to shear man (in minutes).
     *
     * @var integer
     * @access private
     */
    private $_shear_time_man = 30;

    /**
     * Approximate time needed to shear woman (in minutes).
     *
     * @var integer
     * @access private
     */
    private $_shear_time_woman = 60;

    /**
     * How often the person shorn during the year
     *
     * @var integer
     * @access private
     */
    private $_shears_per_year = 12;
    /**
     * Approximate working days per year haircutters have.
     * Defined as 365.25 days per year minus 20 vacancy days
     *
     * @var float
     * @access private
     */
    private $_haircutters_working_days = 345.25;

    /**
     * Approximate working minutes per day haircutters have.
     * Defined as 8hrs per day - 10% (coffee brakes)
     *
     * @var integer
     * @access private
     */
    private $_haircutters_working_minutes = 432;

  // }}}
   
  /**
   * Constructor.
   * 
   * Also can be used to set parameters in few ways.
   * With setting parameters as arguments of constructor:
   * <code>
   *   $var = new Calculator(
   *     integer $population,
   *     float $man_rate,
   *     integer shear_time_man,
   *     integer shear_time_woman,
   *     integer shears_per_year,
   *     float haircutters_working_days,
   *     integer haircutters_working_minutes
   *   );
   * </code>
   * 
   * <br/>Or pass it with associate array (only parameters that are present
   * in array will be changed):
   * 
   * <code>
   *   $var = new Calculator(array(
   *     'population'                 =>integer $population,
   *     'man_rate'                   =>float $man_rate,
   *     'shear_time_man'             =>integer $shear_time_man,
   *     'shear_time_woman'           =>integer $shear_time_woman,
   *     'shears_per_year'            =>integer $shears_per_year
   *     'haircutters_working_days'   =>float $haircutters_working_days,
   *     'haircutters_working_minutes'=>integer $haircutters_working_minutes
   *   ));
   * </code>
   * @param mixed $arg1                The count of population at all 
   *                                   or array of parameters.
   * @param float $m_rate (optional)   The mans rate.
   * @param integer $t_man (optional)  Approximate time needed to 
   *                                   shear man (in minutes).
   * @param integer $t_wom (optional)  Approximate time needed to 
   *                                   shear woman (in minutes).
   * @param integer $spy (optional)    How often the person shorn 
   *                                   during the year
   * @param float $hc_days (optional)  Approximate working days per 
   *                                   year haircutters have.
   * @param integer $hc_min (optional) Approximate working minutes per
   *                                   day haircutters have.
   * 
   * @access public
   * @throws Exception
   * @since Class available since Release 1.0.0
   */
  function __construct($arg1 = null)
  {
    if(is_array($arg1)){
      if(1 < func_num_args()){
        throw new \Exception("Population must be numeric.");
      }
      foreach($arg1 as $name=>$value){
        $this->paramSet($name,$value);
      }
    }else{
      $arguments      = func_get_args();
      $arguments_num  = sizeof($arguments);
      
      for($i = 0; $i < $arguments_num; $i++){
        if(isset($arguments[$i])){
          $this->paramSet($this->_arguments[$i],$arguments[$i]);  
        }
      }
    }
  }

  /**
   * Parameters setter
   *
   * You can set parameters in few ways - the same as __constructor().
   *
   * @param mixed $name  Name of the parameter that will be changed
   *                     Or an associate array (name -> value)
   * @param mixed $value (optional) Value that will be set to parameter
   * @see __construct
   * @uses paramSet
   * @since Class available since Release 1.0.0
   */
  public function setParameter($name, $value = null)
  {
    if(is_array($name)){
      if(1 < func_num_args()){
        throw new \Exception("Parameter name must be a string.");
      }
      foreach($name as $_name=>$value){
        $this->paramSet($_name,$value);
      }
    }else{
      $this->paramSet($name, $value);  
    }
  }

  /**
   * Parameters getter.
   *
   * You can get parameters in few ways:
   * List all parameters you want to get
   * <code>
   *   $obj->getParameter('paramName1','paramName2', ...'paramNameN');
   * </code>
   * 
   * <br/>Or get all parameters if no arguments passed:<br/>
   * 
   * <code>
   *   // List of all parameters
   *   $obj->getParameter();
   * </code>
   *
   * @return array Array of parameters.
   * @since Class available since Release 1.0.0
   */
  public function getParameter()
  {
    $parametersToReturn = array();

    // if set as TRUE than we will validate paramaters names passed
    $checkNames = true;
    if(func_num_args() == 0){
      $parametersToSelect = $this->_arguments;
      $chackNames = false;
    }else{
      $parametersToSelect = func_get_args();
    }

    // for(...){} loop faster than foreach(...){}
    $parametersToSelectCount = sizeof($parametersToSelect);
    for($i = 0; $i < $parametersToSelectCount; $i++){
      $name = $parametersToSelect[$i];
      if($checkNames){
        if(in_array($parametersToSelect[$i], $this->_arguments)){
          $parametersToReturn[$name] = $this->{"_$name"};
        }else{
          throw new \Exception("You not allowed to get $name.");
        }
      }else{
        $parametersToReturn[$name] = $this->{"_$name"};
      }
    }

    return $parametersToReturn;
  }

  /**
   * Calculate Haircutters depends on current arguments
   *
   * This is not exactly number, rather an demand for hairdressers in 
   * specified circumstances. Formula:
   * <code>
   *   mans        = population * ( man_rate / 100 );
   *   womans      = population - mans;
   *   time_needed = (mans*shear_time_man + womans*shear_time_woman);
   *   time_have   = haircutter_have_days * haircutter_have_minutes;
   *   result      = ceil( time_needed * shear_per_year / time_have ) ;
   * </code>
   * 
   * @return integer Approximate number of Haircutters
   * @since Class available since Release 1.0.0
   */
  public function calculate()
  {
    $mans = $this->_population * ( $this->_man_rate / 100);
    $womans = $this->_population - $mans;
    $timeToShearAllMans = $mans * $this->_shear_time_man;
    $timeToShearAllWomans = $womans * $this->_shear_time_woman;
    $haircutterHaveTime = 
      $this->_haircutters_working_days
      * $this->_haircutters_working_minutes;

    return ceil((($timeToShearAllMans + $timeToShearAllWomans) 
                * $this->_shears_per_year
                )/ $haircutterHaveTime);
  }

  /**
   * Parameters setter
   *
   * Sets parameter value depends on arguments passed.
   *
   * @param string $name  Name of the parameter that will be changed
   * @param mixed  $value Value that will be set to parameter
   * @return void
   * @throws Exception
   * @since Class available since Release 1.0.0
   */
  private function paramSet($name, $value)
  {
    //if user not allowd to change this parameter than throw exception
    if(!in_array($name,$this->_arguments)){
      throw new \Exception("You not allowed to change $name.");
    }

    $parameter = &$this->{"_$name"};

    // If type of $value is numeric than set it to class parameters
    if(is_numeric($value)){
      $parameter = $value;
    }else{
      throw new \Exception("$name must be numeric.");
    }
  }
}
