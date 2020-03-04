<?php
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body, html {
  height: 100%;
  margin: 0;
  font: 400 15px/1.8 "Lato",sans-serif;
  color:#777;
}

.bg {
  /* The image used */
  background-image: url("pic/concert.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  }

.bg .caption {
   position:absolute;
   left:0;
   top:50%;
   width:100%;
   text-align:center;
   color:#000;
   }
.bg .caption span.border {
	color:#111;
	padding:18px;
	font-size:35px;
	font-style: italic;
	letter-spacing: 10px;

 }
</style>
</head>
<body>
<?php include 'header.php';?>
 <div class="bg">
   <div class="caption">
     <span class ="border"> Mark your calendar!!</span></br>
	 <span class ="border"> Find upcoming events,concerts,festivals,movies... near you!!</span>
   </div>
 </div>

</body>
</html>
