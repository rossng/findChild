<?php
/**
 * findChild
 *
 * Find a child of the any page with a particular property/value pair
 * and return one of its other properties.
 *
 * @author Ross Gardiner
 * @copyright MIT License Ross Gardiner 2010
 * @version 1.0 - August 11, 2012
 *
 * OPTIONS
 *
 * $id - ID of the parent page you want to use. Default: current page
 * $property, $value - Property/value pair to find child page with.
 * $return - Property of child page to return. Can be any resource property or 'url'.
 */
// Get error page alias
  $errorId = $modx->getOption('error_page');
  $errorUrl = $modx->makeUrl($errorId);
  // Create query
  $c = $modx->newQuery('modResource');  
  // Get ID of specified page, or current page by default
  $id = $modx->getOption('id',$scriptProperties,$modx->resource->get('id'));
  // Find pages with correct property:value and parent
  $c->where(array(  
   'parent' => $id,    
   $property => $value,  
  ));  
  // Get rid of all but one
  $c->limit(1);    
  // Count how many remain
  $count = $modx->getCount('modResource',$c);
  // If there is a result
  if($count){
    // Get that page
    $resource = $modx->getObject('modResource',$c);  
    // Return URL if requested
    $childId = $resource->get('id');
    if($return == 'url'){
      $childUrl = $modx->makeUrl($childId);
      return $childUrl;
    }
    // Else get requested property of child and return if found
    $childReturn = $resource->get($return);
    if($childReturn) {
      return $childReturn;
    }
    else {
      return 'Property not found';
    }
  }
  // Otherwise return error
  else {
    // If snippet asked for ID, return blank
    if($return == 'id') return;
    else return $errorUrl;
  }