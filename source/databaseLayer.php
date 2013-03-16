<?php
include_once 'user.php';
class DatabaseLayer {
	const HOSTNAME = 'localhost';
	const USERNAME = 'hcngo';
	const PASSWORD = '63yNKopU';
	const DATABASE = 'hcngo';

	public static function updateQuestionsTable($questionObj) {
		$mysqli = self::connectDatabase();

		$query = "SELECT questionId FROM questions WHERE questionId=?";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("i", $questionObj['id']);

		$stmt -> execute();

		// Need to call store_result() before calling fetch();
		$stmt -> store_result();

		/*
		 * $resultSet = $stmt->get_result();
		 * cannot be used because the lack of some driver on the web server
		 *
		 */
		$status;
		if ($stmt -> num_rows > 0) {
			// question exists already in the table. Update question.

			if ($questionObj['answerStatus']) {
				$query = "update questions 
			set totalAttempted = totalAttempted + 1, correctAns = correctAns + 1,
			totalTime = totalTime + ?, totalUsedHints = totalUsedHints + ?
			where questionId = ?";
			} else {
				$query = "update questions 
			set totalAttempted = totalAttempted + 1,
			totalTime = totalTime + ?, totalUsedHints = totalUsedHints + ?
			where questionId = ?";
			}

			$stmt -> prepare($query);

			$stmt -> bind_param("iii", $questionObj['timer'], $questionObj['hintsUsed'], $questionObj['id']);

			$status = $stmt -> execute();

		} else {
			// question doesn't exist in the table. Insert the question.
			$query = "insert into questions values(?,?,?,?,?,?)";
			$stmt -> prepare($query);
			if ($questionObj['answerStatus']) {
				$one = 1;
				$stmt -> bind_param("iiiiii", $questionObj['id'], $one, $one, $questionObj['timer'], $questionObj['numHints'], $questionObj['hintsUsed']);
			} else {
				$one = 1;
				$zero = 0;
				$stmt -> bind_param("iiiiii", $questionObj['id'], $one, $zero, $questionObj['timer'], $questionObj['numHints'], $questionObj['hintsUsed']);
			}
			$status = $stmt -> execute();
		}
		$mysqli -> commit();
		$stmt -> close();
		$mysqli -> close();
		return $status;
	}

	/*
	 * PASS
	 */
	public static function testUpdateQuestionsTable() {
		// $questionObj = array('id'=>1,'timer'=>10,'userAnswer'=>1,'hintsUsed'=>1,'answerStatus'=>true,'numHints'=>2);
		$questionObj['id'] = 2;
		$questionObj['timer'] = 10;
		$questionObj['userAnswer'] = 1;
		$questionObj['hintsUsed'] = 0;
		$questionObj['answerStatus'] = true;
		$questionObj['numHints'] = 2;

		self::updateQuestionsTable($questionObj);

		$questionObj['id'] = 1;
		self::updateQuestionsTable($questionObj);

		// $questionObj['answerStatus'] = true;
		// self::processQuestion($questionObj);
		//
		// $questionObj['answerStatus'] = true;
		// self::processQuestion($questionObj);
		//
	}

	public static function updateSkill($skillId, $answerStatus) {
		// check if skillId is in the table
		$mysqli = self::connectDatabase();

		$query = "SELECT skillId FROM skills WHERE skillId=?";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("i", $skillId);

		$stmt -> execute();

		// Need to call store_result() before calling fetch();
		$stmt -> store_result();

		/*
		 * $resultSet = $stmt->get_result();
		 * cannot be used because the lack of some driver on the web server
		 *
		 */
		$status;
		if ($stmt -> num_rows > 0) {
			// skill exists already. Need to update now
			if ($answerStatus) {
				$query = "update skills 
			set totalAttempted = totalAttempted + 1, correctAns = correctAns + 1
			where skillId = ?";
			} else {
				$query = "update skills set totalAttempted = totalAttempted + 1
					where skillId = ?";
			}
			$stmt -> prepare($query);
			$stmt -> bind_param("i", $skillId);

			$status = $stmt -> execute();

		} else {
			// skill doesn't exist. Insert
			$query = "insert into skills values(?,?,?)";
			$stmt -> prepare($query);
			if ($answerStatus) {
				$one = 1;
				$stmt -> bind_param("iii", $skillId, $one, $one);
			} else {
				$one = 1;
				$zero = 0;
				$stmt -> bind_param("iii", $skillId, $one, $zero);
			}
			$status = $stmt -> execute();

		}
		$mysqli -> commit();
		$stmt -> close();
		$mysqli -> close();
		return $status;
	}

	/*
	 * PASS
	 */
	public static function testUpdateSkill() {
		$status = self::updateSkill(1, TRUE);
		$status = self::updateSkill(1, FALSE);

		$status = self::updateSkill(2, TRUE);
		$status = self::updateSkill(2, FALSE);

		$status = self::updateSkill(3, TRUE);
		$status = self::updateSkill(3, TRUE);

	}

	public static function connectDatabase() {
		$mysqli = new mysqli(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);
		/*
		 * This is the "official" OO way to do it,
		 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
		 */
		if ($mysqli -> connect_error) {
			die('Connect Error (' . $mysqli -> connect_errno . ') ' . $mysqli -> connect_error);
		}

		/*
		 * Use this instead of $connect_error if you need to ensure
		 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
		 */
		if (mysqli_connect_error()) {
			die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}

		return $mysqli;
	}

	/*
	 * Insert a new user into the database. Return the status of the insertion.
	 */
	public static function registerUser(User $user) {
		$mysqli = self::connectDatabase();

		$query = "INSERT INTO users values(?,?,?,?,?,?,?)";

		$stmt = $mysqli -> prepare($query);

		$stmt -> bind_param('issssss', $user -> getAccess(), $user -> getName(), $user -> getAddress(), $user -> getCity(), $user -> getPostalCode(), $user -> getEmail(), $user -> getBirthdate());

		// insert one row
		$result = $stmt -> execute();

		$mysqli -> commit();
		$stmt -> close();
		$mysqli -> close();

		return $result;
	}

	public static function authenticateUser($name) {
		$mysqli = self::connectDatabase();

		$query = "SELECT access FROM users WHERE name=?";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("s", $name);

		$stmt -> execute();

		// Need to call store_result() before calling fetch();
		$stmt -> store_result();

		/*
		 * $resultSet = $stmt->get_result();
		 * cannot be used because the lack of some driver on the web server
		 */
		$access;
		$stmt -> bind_result($access);

		$status;
		if ($stmt -> num_rows > 0) {
			if ($stmt -> fetch()) {
				if($access == 0){
					$status = 1; // normal user.
				} else {
					$status = 2; // admin 
				}
			}
		} else {
			$status = 0;
		}
		$stmt -> close();
		$mysqli -> close();
		return $status;
	}

	/*
	 * PASS
	 */
	public static function testRegisterUser() {
		$user1 = new User(1, 'hcngo', '15731', 'Edmonton', 'T5Z0G1', 'hcngo@ualberta.ca', '1991-12-09');
		echo self::registerUser($user1);
		// False doesn't show anything.
	}

	/*
	 * PASS
	 */
	public static function testAuthenticateUser($name) {
		echo self::authenticateUser($name);
	}

	public static function updateQuestionOptionsTable($questionId, $optionId) {
		$mysqli = self::connectDatabase();

		$query = "SELECT questionId, optionId FROM questionOptions WHERE questionId=? AND optionId=?";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("ii", $questionId, $optionId);

		$stmt -> execute();

		// Need to call store_result() before calling fetch();
		$stmt -> store_result();

		/*
		 * $resultSet = $stmt->get_result();
		 * cannot be used because the lack of some driver on the web server
		 *
		 */
		$status;
		if ($stmt -> num_rows > 0) {
			// question exists already in the table. Update question.

			$query = "UPDATE questionOptions 
			SET totalAttempted = totalAttempted + 1 
			WHERE questionId=? AND optionId=?";

			$stmt -> prepare($query);

			$stmt -> bind_param("ii", $questionId, $optionId);

			$status = $stmt -> execute();

		} else {
			// question doesn't exist in the table. Insert the question.
			$query = "INSERT INTO questionOptions values(?,?,?)";
			$stmt -> prepare($query);
			$one = 1;
			$stmt -> bind_param("iii", $questionId, $optionId, $one);
			$status = $stmt -> execute();
		}
		$mysqli -> commit();
		$stmt -> close();
		$mysqli -> close();
		return $status;

	}

	/*
	 * PASS
	 */
	public static function testUpdateQuestionOptionsTable() {
		$questionId = 2;
		for ($i = 1; $i < 4; $i++) {
			self::updateQuestionOptionsTable($questionId, $i);
		}

		$questionId = 1;
		for ($i = 1; $i < 4; $i++) {
			self::updateQuestionOptionsTable($questionId, $i);
		}
		// self::updateQuestionOptionsTable($questionId, $optionId);
	}

	public static function updateUserQuestionsTable($questionObj, $name) {
		$mysqli = self::connectDatabase();

		$query = "SELECT questionId,name FROM userQuestions WHERE questionId=? AND name=?";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("is", $questionObj['id'], $name);

		$stmt -> execute();

		// Need to call store_result() before calling fetch();
		$stmt -> store_result();

		/*
		 * $resultSet = $stmt->get_result();
		 * cannot be used because the lack of some driver on the web server
		 *
		 */
		$status;
		if ($stmt -> num_rows > 0) {
			// question - user exists already in the table. Update question for user.

			if ($questionObj['answerStatus']) {
				$query = "UPDATE userQuestions 
			SET totalAttempted = totalAttempted + 1, correctAns = correctAns + 1,
			totalTime = totalTime + ?, totalUsedHints = totalUsedHints + ?
			WHERE questionId=? AND name=?";
			} else {
				$query = "UPDATE userQuestions 
			SET totalAttempted = totalAttempted + 1,
			totalTime = totalTime + ?, totalUsedHints = totalUsedHints + ?
			WHERE questionId =? AND name=?";
			}

			$stmt -> prepare($query);

			$stmt -> bind_param("iiis", $questionObj['timer'], $questionObj['hintsUsed'], $questionObj['id'], $name);

			$status = $stmt -> execute();

		} else {
			// question doesn't exist in the table. Insert the question.
			$query = "INSERT INTO userQuestions values(?,?,?,?,?,?)";
			$stmt -> prepare($query);
			if ($questionObj['answerStatus']) {
				$one = 1;
				$stmt -> bind_param("isiiii", $questionObj['id'], $name, $one, $one, $questionObj['timer'], $questionObj['hintsUsed']);
			} else {
				$one = 1;
				$zero = 0;
				$stmt -> bind_param("isiiii", $questionObj['id'], $name, $one, $zero, $questionObj['timer'], $questionObj['hintsUsed']);
			}
			$status = $stmt -> execute();
		}
		$mysqli -> commit();
		$stmt -> close();
		$mysqli -> close();
		return $status;

	}

	/*
	 * PASS
	 */
	public static function testUpdateUserQuestionsTable() {
		$questionObj['id'] = 2;
		$questionObj['timer'] = 10;
		$questionObj['userAnswer'] = 1;
		$questionObj['hintsUsed'] = 2;
		$questionObj['answerStatus'] = false;
		$questionObj['numHints'] = 2;

		$name = 'hieungo';
		self::updateUserQuestionsTable($questionObj, $name);

		self::updateUserQuestionsTable($questionObj, $name);

		$name = 'hcngo';
		$questionObj['id'] = 2;
		self::updateUserQuestionsTable($questionObj, $name);

		self::updateUserQuestionsTable($questionObj, $name);

	}

	/*
	 * RETRIVING SECTION FOR ADMIN MODULE
	 */

	/*
	 * Return the associative array with key:"skill" and value:"accuracy percentage"
	 */
	public static function getSkillsStat() {
		// variables to be bound by database methods
		$skillId;
		$totalAttempted;
		$correctAns;

		// accuracy percentage.
		$percentage;

		// Associative array to be returned.
		$skillsArray = array();

		$mysqli = self::connectDatabase();

		$query = "SELECT * FROM skills";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> execute();

		/*
		 * Need to call store_result() before calling fetch() to buffer data.
		 * More memory -> greater performance.
		 */
		$stmt -> store_result();

		$stmt -> bind_result($skillId, $totalAttempted, $correctAns);

		while ($stmt -> fetch()) {
			$percentage = round(($correctAns * 100) / $totalAttempted);
			$skillsArray[$skillId] = $percentage;
		}

		$stmt -> close();
		$mysqli -> close();
		return $skillsArray;
	}

	/*
	 * PASS
	 */
	public static function testGetSkillsStat() {
		$skillsArray = self::getSkillsStat();
		var_dump($skillsArray);
	}

	public static function getQuestionsStat() {
		// variables to be bound the database methods.
		$questionId;
		$totalAttempted;
		$correctAns;
		$totalTime;
		$totalUsedHints;
		$numHints;

		$avgScore;
		$avgTime;
		$avgHints;

		// Array for containing all questions
		$questionsArray = array();

		$mysqli = self::connectDatabase();

		$query = "SELECT * FROM questions ORDER BY questionId";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> execute();

		/*
		 * Need to call store_result() before calling fetch() to buffer data.
		 * More memory -> greater performance.
		 */
		$stmt -> store_result();

		$stmt -> bind_result($questionId, $totalAttempted, $correctAns, $totalTime, $numHints, $totalUsedHints);

		while ($stmt -> fetch()) {
			$avgScore = round(($correctAns * 100) / $totalAttempted);
			$avgTime = round(($totalTime / $totalAttempted), 2);
			$avgHints = round(($totalUsedHints / $totalAttempted), 2);

			// can be viewed as an associative array for "question" object
			$question = array();

			$question['questionId'] = $questionId;
			$question['totalAttempted'] = $totalAttempted;
			$question['avgScore'] = $avgScore;
			$question['avgTime'] = $avgTime;
			$question['avgHints'] = $avgHints;

			$questionsArray[] = $question;
		}

		$stmt -> close();
		$mysqli -> close();
		return $questionsArray;
	}

	/*
	 * PASS
	 */
	public static function testGetQuestionsStat() {
		$questionsArray = self::getQuestionsStat();
		var_dump($questionsArray);
	}

	public static function getUsersStat() {
		// variables to be bound the database methods.
		$questionId;
		$totalAttempted;
		$correctAns;
		$totalTime;
		$totalUsedHints;
		$name;

		$avgScore;
		$avgTime;
		$avgHints;

		// Array for containing all user-question pairs
		$userQuestionsArray = array();

		$mysqli = self::connectDatabase();

		$query = "SELECT * FROM userQuestions ORDER BY name,questionId";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> execute();

		/*
		 * Need to call store_result() before calling fetch() to buffer data.
		 * More memory -> greater performance.
		 */
		$stmt -> store_result();

		$stmt -> bind_result($questionId, $name, $totalAttempted, $correctAns, $totalTime, $totalUsedHints);

		while ($stmt -> fetch()) {
			$avgScore = round(($correctAns * 100) / $totalAttempted);
			$avgTime = round(($totalTime / $totalAttempted), 2);
			$avgHints = round(($totalUsedHints / $totalAttempted), 2);

			// can be viewed as an associative array for "question" object
			$userQuestion = array();

			$userQuestion['name'] = $name;
			$userQuestion['questionId'] = $questionId;
			$userQuestion['totalAttempted'] = $totalAttempted;
			$userQuestion['avgScore'] = $avgScore;
			$userQuestion['avgTime'] = $avgTime;
			$userQuestion['avgHints'] = $avgHints;

			$userQuestionsArray[] = $userQuestion;
		}

		$stmt -> close();
		$mysqli -> close();
		return $userQuestionsArray;
	}

	/*
	 * PASS
	 */
	public static function testGetUsersStat() {
		$userQuestionsArray = self::getUsersStat();
		var_dump($userQuestionsArray);
	}

	public static function getGraphQuestion($questionId) {
		$optionId;
		$totalAttempted;

		// Array for containing optionId - attempts for options
		$questionOptsArray = array();

		$mysqli = self::connectDatabase();

		$query = "SELECT optionId,totalAttempted FROM questionOptions WHERE questionId=? ORDER BY optionId";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("i", $questionId);

		$stmt -> execute();

		/*
		 * Need to call store_result() before calling fetch() to buffer data.
		 * More memory -> greater performance.
		 */
		$stmt -> store_result();

		$stmt -> bind_result($optionId, $totalAttempted);

		while ($stmt -> fetch()) {
			$questionOptsArray[strval($optionId)] = $totalAttempted;
		}

		$stmt -> close();
		$mysqli -> close();
		return $questionOptsArray;
	}

	/*
	 * PASS
	 */
	public static function testGetGraphQuestion($questionId) {
		$questionOptsArray = self::getGraphQuestion($questionId);
		var_dump($questionOptsArray);
	}

	public static function getGraphUser($name) {
		// variables to be bound by database methods
		$questionId;
		$totalAttempted;
		$totalTime;

		$userQuestionsArray = array();

		$mysqli = self::connectDatabase();

		$query = "SELECT questionId,totalAttempted,totalTime FROM userQuestions WHERE name=? ORDER BY questionId";

		$stmt = $mysqli -> stmt_init();
		$stmt -> prepare($query);

		$stmt -> bind_param("s", $name);

		$stmt -> execute();

		/*
		 * Need to call store_result() before calling fetch() to buffer data.
		 * More memory -> greater performance.
		 */
		$stmt -> store_result();

		$stmt -> bind_result($questionId, $totalAttempted, $totalTime);

		while ($stmt -> fetch()) {
			$userQuestionsArray[$questionId] = round(($totalTime / $totalAttempted), 2);
		}

		$stmt -> close();
		$mysqli -> close();
		return $userQuestionsArray;
	}

	/*
	 * PASS
	 */
	public static function testGetGraphUser($name) {
		$userQuestionsArray = self::getGraphUser($name);
		var_dump($userQuestionsArray);
	}

}

// DatabaseLayer::testRegisterUser();
// DatabaseLayer::testUpdateQuestionsTable();
// DatabaseLayer::testUpdateQuestionOptionsTable();
// DatabaseLayer::testUpdateUserQuestionsTable();
// DatabaseLayer::testUpdateSkill();
// DatabaseLayer::testGetSkillsStat();
// DatabaseLayer::testGetQuestionsStat();
// DatabaseLayer::testGetUsersStat();
// DatabaseLayer::testGetGraphQuestion(1);
// DatabaseLayer::testGetGraphUser('hcngo');
?>