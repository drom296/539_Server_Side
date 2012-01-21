<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>prototype</title>
		<!-- CSS -->
		<link type="text/css" href="css/pedro.css" rel="stylesheet"/>
		<link type="text/css" href="css/nav.css" rel="stylesheet"/>
		<!-- JavaScript -->
	</head>
	<body> 
		<div id="page">
			<div id="banner">
				<img src="img/logo.png" alt="logo" />
			</div>
			<div id="nav">
				<ul id="nav">
					<li id="navHome"><a href="">Home</a></li>
					<li id="navNews"><a href="">News</a></li>
					<li id="navAdmin"><a href="">Admin</a></li>
					<li id="navAbout"><a href="">About</a></li>
				</ul>
			</div>
			<div id="content" class="noFloat">
				<div id="editorial" class="navHome">
					<h1>Editorial</h1>
					<img src="img/editor2.jpg" alt="editor" height="100px" width="100px"/>
					<p>
						Editorial
						<br/>
						Editorial
						<br/>
						Editorial
						<br/>
						Editorial
						<br/>
						Editorial
						<br/>
						Editorial
						<br/>
					</p>
				</div>
				<div id="news">
					<h1>News</h1>
					<?php
					$times = 10;
					for ($i = 0; $i < $times; $i++) {
						$string = <<<END
<div class="newsItem">
						<p>
							<span class="newsSubject">Subject</span><span class="newsDate">1/12/2012</span>
						</p>
						<p>
							This is a story, of a lovely lady. Who had more kids than a grown man can count.
						</p>
					</div>\n\t\t\t\t\t
END;
						echo $string;
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
