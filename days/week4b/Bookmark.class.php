<?php
echo "<h1>Day 8 class demo</h1>";
$link1 = new Bookmark('http://www.rit.edu','RIT','Go to RIT!!!');
echo $link1->info();
echo $link1->toLink();

class Bookmark{
	public $p_href, $p_text, $p_title, $p_date;
	
	public function __construct($href, $text, $title="", $date=""){
		$this->p_href = $href;
		$this->p_text = $text;
		$this->p_title = $title;
		$this->p_date = $date;
	
	}

	public function info(){
		return <<<END
		<p>href = $this->p_href</p>
		<p>text = $this->p_text</p>
		<p>title = $this->p_title</p>
		<p>date = $this->p_date</p>
END;
	}
	
	public function toLink(){
		return "<a href='$this->p_href' title='$this->p_title'>$this->p_title</a>";
	}
	public function sayHi(){
		return "hi!";
	}

}





?>