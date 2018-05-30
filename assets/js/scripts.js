var longt = document.getElementById("Longt");
var lat = document.getElementById("Lat");

var checkStr = '<i class="fa fa-check" id="gpsdone"aria-hidden="true" style="color:green;"></i>'
var str = '<img src="assets/img/spinner.gif" alt="loading" id="spinner">',
    div = document.getElementById( 'gps' );



function getLocation() {
    div.insertAdjacentHTML( 'beforeend', str );
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    lat.value = position.coords.latitude
    longt.value = position.coords.longitude
    document.getElementById('spinner').remove();
    div.insertAdjacentHTML( 'beforeend', checkStr );
}

$('.input-range').on('input', function() {
  var kilometers = this.value/1000;
  $(this).next('.range-value').html(kilometers);
});

$( document ).ready(function() {


      setInterval(function(){
        var litlogo = "assets/img/logo-lit.png";
        var imgsrc = $("#logo").attr('src');
        if (imgsrc == litlogo) {
          $("#logo").attr("src","assets/img/logo-not-lit.png");
        }else {
          $("#logo").attr("src",litlogo);
        }
       }, 2000);


});
