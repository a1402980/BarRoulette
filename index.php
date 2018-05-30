<?php
include("header.php");
 ?>
 <div class="logo-container">
   <img src="assets/img/logo-lit.png" alt="logo" id="logo">
 </div>
 <div class="search-container">
   <div id="search">
     <form class="" action="results.php" method="get">
       <div id="gps">
         <input type="text" name="location" placeholder="City/address"value="">
         <button type="button" name="button" id="searchButton" onclick="getLocation()">GPS</button>
       </div>
       <input type="text" hidden id="Longt" name="Longt" value=""><input hidden id="Lat" type="text" name="Lat" value=""><br>
       <input class="input-range" type="range" step="100" value="4000" min="100" max="40000" name="radius">
       <span class="range-value">4.0</span> <span>km</span> <br>
       <button type="submit" name="button">Search for bars</button>
     </form>
   </div>
 </div>


<?php
include("footer.php");
 ?>
