<?php

$ctaTourDetailsBtnText = TOURS_DETAILS_BTN;
$ctaTourEnquireBtnText = TOURS_INQUIRE_BTN;
$ctaTourBookingBtnText = TOURS_BOOKING_BTN;

$currencyIconView='<i class="'.$currencyIcon.'" aria-hidden="true"></i>';

if($page_url == $page_tours->url)
{
	
	if($option1)
	{
		require_once 'inc/single.php';
	}
	
	else{
		
		require_once 'inc/list.php';
	}
}

?>