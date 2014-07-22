<?php

namespace CrowdFlower;

/**
 * ClowdFlower specific exception.
 * TODO: may want to make sure we are passing 300, 400 and 500 level response
 *       codes as the second argument to the constructor
 */
class Exception extends \Exception
{
  public function __construct($message, $code = 0, Exception $previous = null) {
      // premade messages

      switch ($message) {
        case 'job_attributes':
          $message = "No Job Attributes specified. Use setAttributes() first.";
        break;
        case 'job_id':
          $message = "No Job Id specified. Use setId() first.";
        break;
        case 'unit_id':
          $message = "No Unit Id specified. Use setId() first.";
        break;
        case 'unit_attributes':
          $message = "No Unit Attributes specified. Use setAttributes() first.";
        break;
        case 'judgment_id':
          $message = "No Judgment Id specified. Use setId() first.";
        break;
        case 'judgment_attributes':
          $message = "No Judgment Attributes specified. Use setAttributes() first.";
        break;
        case 'order_attributes':
          $message = "No Order Attributes specified. Use setAttributes() first.";
        break;
        default:
          $message = $message;
        break;
      }

      // make sure everything is assigned properly
      parent::__construct($message, $code, $previous);
  }
}
