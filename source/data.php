<?php

class Data {

	private $questionList;

	const FILENAME = 'data.json';
	public static $NUMQUES;
	public static $CORRECT = 'correct';
	public static $MEDIA = 'media';
	public static $STEM = 'stem';
	public static $SOURCE = 'source';
	public static $OPTIONS = 'options';
	public static $SKILL = 'skill';
	public static $ANSTYPE = 'anstype';
	public static $ID = 'id';
	public static $HINTS = 'hints';

	public function __construct($fileName) {
		$this -> questionList = self::decodeData($fileName);
		self::$NUMQUES = round(count($this -> questionList) / 5);
	}

	public function getRandomSet($sizeSet) {
		$set = Array();
		$i = 0;
		$maxSize = count($this->questionList);
		while ($i < $sizeSet) {
			$number = rand(0, $maxSize - 1);
			if(!in_array($number, $set)){
				array_push($set, $number);
				$i++;
			}
		}
		return $set;
	}

	public function getSize() {
		return count($this -> questionList);
	}

	public function getQuestionList() {
		return $this -> questionList;
	}

	private static function decodeData($fileName) {
		$questionList = Array();

		$file = fopen($fileName, "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		while (!feof($file)) {
			$jsonQuestion = fgets($file);
			if (trim($jsonQuestion) != '') {
				$question = json_decode($jsonQuestion, TRUE);
				array_push($questionList, $question);
			}
		}
		fclose($file);
		return $questionList;
	}

	// <li onclick="getCheckedRadio()">
	// Question 1: Which of the following is <b><i>Incorrect</i></b>?
	// <br />
	// <img src="question1.gif" alt="image is loading..."/>
	// <br />
	// <input type="radio" name="question1" value="A" />
	// <label for="A"> A. A</label>
	// <br />
	// <input type="radio" name="question1" value="B" />
	// <label for="B"> B. B</label>
	// <br />
	// <input type="radio" name="question1" value="C" />
	// <label for="C"> C. C</label>
	// <br />
	// <input type="radio" name="question1" value="D" />
	// <label for="D"> D. D</label>
	// <br />
	// </li>
	//

	private static function getMediaType($media) {
		$pos = strrpos($media, '.');
		$type = substr($media, $pos + 1);

		if ($type == 'png' || $type == 'jpg' || $type == 'tif' || $type == 'gif') {
			return 0;
		} else {
			return 1;
		}
	}

	private static function printMedia($media) {
		if (self::getMediaType($media) == 0) {
			echo "<img height='300' src='" . $media . "' alt='image is loading...'/>";
			echo "<br />";
		} else {
			echo "<embed height='300' scale='tofit' src='" . $media . "' autostart='true' />";
			echo "<br />";
		}
	}

	private static function printOption($option, $type) {
		if ($type == "image") {
			echo "<img height='100' src='" . $option . "' alt='image is loading...'/>";
		} else {
			echo $option;
		}
	}

	private function printHintButtons($order) {
		$question = $this -> questionList[$order];
		$hints = $question[self::$HINTS];
		echo "<table>";
		for ($i = 0; $i < count($hints); $i++) {
			echo "<tr>";
			echo "<td id=button" . ($i + 1) . ">";
			echo "<input type='button' name='buttonHint" . ($i + 1);
			echo "' value='hint" . ($i + 1) . "' onclick='showHint(" . ($i + 1) . "," . $question[self::$ID] . ")' />";
			echo "</td>";

			echo "<td id=hint" . ($i + 1) . "question" . $question[self::$ID] . " style='display: none;'>";
			echo $hints[$i];
			echo "</td>";
		}
		echo "</table>";
	}

	public function outputQuestion($order) {
		$question = $this -> questionList[$order];
		echo "<li onclick='getCheckedRadio(this)'>";
		echo "source: " . $question[self::$SOURCE] . "<br />";

		$mediaArray = $question[self::$MEDIA];
		for ($i = 0; $i < count($mediaArray); $i++) {
			self::printMedia($mediaArray[$i]);
		}

		echo "Question " . $question[self::$ID] . ":	" . $question[self::$STEM] . "<br />";

		$optionsArray = $question[self::$OPTIONS];
		for ($i = 0; $i < count($optionsArray); $i++) {
			echo "<input type='radio' name='question" . $question[self::$ID] . "' value=" . ($i + 1) . " />";
			echo "<label for='" . ($i + 1) . "'> " . ($i + 1) . ".	";
			echo self::printOption($optionsArray[$i], $question[self::$ANSTYPE]) . " </label>";
			echo "<br />";
		}
		$this -> printHintButtons($order);
		echo "</li>";
	}

	// public static function printQuestion($question) {
	// foreach ($question as $x => $x_value) {
	// echo "Key=" . $x . ", Value=" . $x_value;
	// echo "<br>";
	// }
	// }
	public static function output() {

		$dataObject = new Data('data.json');
		$questions = '';
		$set = $dataObject->getRandomSet(self::$NUMQUES);
		// $dataObject -> getSize()
		for ($i = 0; $i < count($set); $i++) {
			$questions = $questions . ($dataObject -> outputQuestion($set[$i]));
		}
		echo $questions;
	}

	// Return the position in the $questionList array that contains question
	// corresponding to the id provided.
	public function findMatchId($idSearch) {
		for ($i = 0; $i < count($this -> questionList); $i++) {
			if ($this -> questionList[$i][self::$ID] == $idSearch) {
				return $i;
			}
		}
		return -1;
		// not found
	}

}
?>