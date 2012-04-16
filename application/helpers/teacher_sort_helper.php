<?php

function teacher_sort($teachers) {
	$lastNames = array();
	$newTeachers = array();
	foreach($teachers as $teacher) {
		$name = explode(' ', $teacher->name);
		$lastNames[$teacher->id] = $name[count($name) - 1];
		$newTeachers[$teacher->id] = $teacher;
	}
	
	asort($lastNames);
	
	$result = array();
	foreach($lastNames as $key => $name) {
		$result[] = $newTeachers[$key];
	}
	
	return $result;
}