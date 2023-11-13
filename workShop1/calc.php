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
if(isset($calc)) { // $calc exists as a variable
   $prod = $x * $y;
}
else { // set defaults
   $x=0;
   $y=0;
   $prod=0;
}
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
          y =  <input type="text" name="y" size="5" value="<?php  print $y; ?>"/>


          <input type="submit" name="calc" value="Calculate"/>
          <input type="reset" name="clear" value="Clear"/>
       </form>

      <!-- print the result -->
      <?php 
      if(isset($calc)) {
          print "<p>x * y = $prod</p>";
      } 
      ?>

   </body>
</html>