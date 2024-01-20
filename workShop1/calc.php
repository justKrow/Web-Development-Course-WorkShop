<?php

/* ======================================================
   PHP Calculator example using "sticky" form (Version 1)
   ======================================================
   Author : P Chatterjee (adopted from an original example written by C J Wallace)
   Purpose : To multiply 2 numbers passed from a HTML form and display the result.
   input:
      x, y : numbers
      calc : Calculate button pressed
   Date: 15 Oct 2007
*/

// grab the form values from $_HTTP_GET_VARS hash
extract($_GET);
// first compute the output, but only if data has been input
    function calculate($x, $y, $operator) {
        if (!is_numeric($x) || !is_numeric($y)) {
            $result = "///script encounters a non-numeric value in the x or y parameters///";
        }
        else if ($y == 0 && $operator == "/") {
            $result = "&infin;";
        }
        else {
            $expression = $x . $operator . $y;
            eval("\$result = $expression;");    
        }
        return $result;
    }

    $x = isset($x) ? $x : 0;
    $y = isset($y) ? $y : 0;
    $operator = isset($operator) ? $operator : "+";
    $result = isset($result) ? $result : calculate($x, $y, $operator);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP Calculator Example</title>
    </head>

    <body>

       <h3>PHP Calculator (Version 1)</h3>
       <p>Multiply two numbers and output the result</p>

       <form method="get" action="<?php print $_SERVER['PHP_SELF']; ?>">

          x = <input type="text" name="x" size="5" value="<?php print $x; ?>"/>
          <select name="operator" id="operator">
            <option value="+" <?php if ($operator == "+") echo 'selected'; ?>> + </option>
            <option value="-" <?php if ($operator == "-") echo 'selected'; ?>> - </option>
            <option value="*" <?php if ($operator == "*") echo 'selected'; ?>> * </option>
            <option value="/" <?php if ($operator == "/") echo 'selected'; ?>> / </option>
          </select>
          y =  <input type="text" name="y" size="5" value="<?php  print $y; ?>"/>


          <input type="submit" name="calc" value="Calculate" action="calculate()" />
       </form>
    
      <!-- print the result -->
      <?php 
      if(isset($calc)) {
          print "<p>x $operator y = $result</p>";
      } 
      ?>

   </body>
</html>