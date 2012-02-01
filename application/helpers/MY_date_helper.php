<?

function friendly_to_unix($date)
{
	$dateParts = explode('/', $date);
	if(count($dateParts) != 3)
		return $date;
	$humanDate = $dateParts[2].'-'.$dateParts[0].'-'.$dateParts[1].' 00:00:00 AM';
	$timestamp = human_to_unix($humanDate);
	return $timestamp;
}

function unix_to_friendly($date)
{
	if($date == 0)
		return $date;
		
	$humanDate = unix_to_human($date);
	$dateHalves = explode(' ', $humanDate);
	$dateParts = explode('-', $dateHalves[0]);
	$friendlyDate = $dateParts[1].'/'.$dateParts[2].'/'.$dateParts[0];
	
	return $friendlyDate;
}