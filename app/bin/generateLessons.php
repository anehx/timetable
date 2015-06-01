<?php

require __DIR__ . '/../../vendor/autoload.php';

use datamapper\LessonTimeMapper;
use datamapper\CourseMapper;
use model\Lesson;

$lessons = array(
	'Englisch',
	'Französisch',
	'Deutsch',
	'Chemie',
	'Math',
	'Biologie',
	'Physik',
	'Sport',
	'Musik',
	'Wirtschaft'
);

$courses = CourseMapper::getInstance()->getCourses();
$lts     = LessonTimeMapper::getInstance()->getLessonTimes();

print("Deleting all lessons...\n");
util\DbManager::getConnection()->query("TRUNCATE TABLE `lesson`");

foreach ($courses as $course) {
	print("Generating lessons for course $course->name...\n");
	foreach (Lesson::WEEKDAY_MAP as $key => $val) {
		if ($key > 5) {
			continue;
		}

		foreach ($lts as $lt) {
			$lesson = new Lesson();

			$lesson->name = $lessons[array_rand($lessons)];
			$lesson->weekday = $key;
			$lesson->lessonTimeID = $lt->id;
			$lesson->courseID = $course->id;

			$lesson->save();
		}
	}
}

print("Done!");