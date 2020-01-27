<?php

$members=[
	[
		'name'=>'Joe Average Hotel',
		'bio'=>'This is Hotel room 1',
		'picture'=>'https://www3.hilton.com/resources/media/hi/BUEHIHH/en_US/img/shared/full_page_image_gallery/main/HH_exec1n_4_1270x560_FitToBoxSmallDimension_Center.jpg'
	],
	[
		'name'=>'Exceptionally Overpriced Hotel',
		'bio'=>'This is Hotel room 2',
		'picture'=>'https://resources.stuff.co.nz/content/dam/images/1/3/t/x/5/v/image.related.StuffLandscapeSixteenByNine.1240x700.1a6stp.png/1457204991167.jpg'
	],
	[
		'name'=>'Reasonably Priced Ralph\'s Hotel',
		'bio'=>'This is Hotel room 3',
		'picture'=>'https://g.foolcdn.com/image/?url=https%3A%2F%2Fg.foolcdn.com%2Feditorial%2Fimages%2F480528%2Fa-modern-high-end-hotel-room-with-a-view-over-the-water.jpg&w=700&op=resize'
	],
	[
		'name'=>'Ripoff Rick\'s Hotel',
		'bio'=>'This is Hotel room 4',
		'picture'=>'https://i.dmarge.com/2018/11/villa-teresa-960x580.jpg'
	]
];

if(!isset($_GET['id'])){
	echo 'Please enter the id of a member or visit the <a href="index.php">index page</a>.';
	die();
}
if($_GET['id']<0 || $_GET['id']>count($members)-1){
	echo 'Please enter the id of a member or visit the <a href="index.php">index page</a>.';
	die();
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?= $members[$_GET['id']]['name']?></title>
  </head>
  <body>
	  <div class="container">
		<h1><?= $members[$_GET['id']]['name']?></h1>
		<img src="<?= $members[$_GET['id']]['picture'] ?>" width="500" />
		<p><?= $members[$_GET['id']]['bio'] ?></p>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>