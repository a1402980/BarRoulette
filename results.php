<?php
require("yelp.php");

// Start the session
session_start();
if ($_GET["location"] == $_SESSION["location"] && $_GET["Lat"] == $_SESSION["Lat"] && $_GET["Longt"] == $_SESSION["Longt"] && $_GET["radius"] == $_SESSION["radius"]) {
	$searchResult = $_SESSION["Result"];
	echo "Using session";
}else{
	echo "Not using session";
	$location = $_GET["location"];
	$latitude = $_GET["Lat"];
	$longitude = $_GET["Longt"];
	$radius = $_GET["radius"];

	//if no location data is set, redirect
	if (!$location) {
		if (!$latitude && !$longitude) {
			$link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
			header("Location: ".$link); /* Redirect browser */
			exit();
		}
	}

	$searchResult = search($bearer_token, $term, $location, $longitude,$latitude,$radius);
	$_SESSION["Result"] = $searchResult;

	$_SESSION["location"] = $_GET["location"];
	$_SESSION["Lat"] = $_GET["Lat"];
	$_SESSION["Longt"] = $_GET["Longt"];
	$_SESSION["radius"] = $_GET["radius"];

}


include("header.php");

$resultSize = count($searchResult->businesses)-1;
$r = rand(0,$resultSize);
?>

	<div id="result">
		<?php
		if ($resultSize > 0) {?>

		<?php $bgImage = $searchResult->businesses[$r]->image_url;
			if (!$bgImage) {
				$bgImage = "assets/img/bar-bingo-medium.jpg";
			}
		?>
		<div class="info" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.65) 69%, rgba(0, 0, 0, 0.75) 100%), url('<?php echo $bgImage; ?>');">


			<h1><?php echo $searchResult->businesses[$r]->name; ?></h1>

			<?php
			//print the stars from the number
				$starNumber = $searchResult->businesses[$r]->rating;
				for($x=1;$x<=$starNumber;$x++) {?>
					<i class="fa fa-star" aria-hidden="true"></i>
				<?php
				}
				if (strpos($starNumber,'.')) {?>
					<i class="fa fa-star-half-o" aria-hidden="true"></i>
					<?php
						$x++;
				}
				while ($x<=5) {?>
					<i class="fa fa-star-o" aria-hidden="true"></i>
						<?php
						$x++;
				}
		?>


			<?php $distance = $searchResult->businesses[$r]->distance/1000; ?>
			<p><?php echo round($distance, 2); ?> km</p>

			<?php
			// foreach ( $searchResult->businesses[$r]->location->display_address as $locinfo) {
			// 	$fullAddress = $fullAddress + " " + $locinfo ;
			// }
			$fullAddress = implode(", ",$searchResult->businesses[$r]->location->display_address)

			?>
			<a target="_blank" href="https://maps.google.com/?q=<?php echo $fullAddress ?>"><?php echo $fullAddress ?></a>
		<?php
		// foreach ( $searchResult->businesses[$r]->location->display_address as $locinfo) {
		// 	echo $locinfo. " ";
		// }

		?>
		<br>
		<button id="reRoll" type="button" name="button" onclick="location.reload();"><i class="fa fa-random" aria-hidden="true"></i> Re-roll</button>
		</div>
		
		<?php
		}else{
			echo "<h2>Sorry, no Bars were found :(</h2>";
		}
		?>
	</div>



	<?php
//var_dump($searchResult);

include("footer.php");
 ?>
