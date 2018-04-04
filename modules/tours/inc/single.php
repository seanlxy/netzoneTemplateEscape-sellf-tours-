<?php

//get booking_url
//

$sql_booking = "SELECT gs.`resbook_id`,`booking_engine_url`
        FROM `general_settings` gs
        WHERE gs.`id` = '1'
        LIMIT 1";
    $row_booking = fetch_row($sql_booking);

    @extract($row_booking);


//single accommodation
$tours_url = $option1;


$sql = "SELECT t.`id`, t.`page_meta_data_id`, t.`from_price`, t.`gallery_id`, t.`slideshow_id`,
	t.`beds`,t.`sqm`,t.`pax`,
    pmd.`heading`, pmd.`title`, pmd.`meta_description`, pmd.`introduction`, pmd.`full_url`,
    pmd.`og_title`, pmd.`og_image`, pmd.`og_meta_description`, pmd.`photo`
    FROM `tours` t
    LEFT JOIN `page_meta_data` pmd
    ON(pmd.`id` = t.`page_meta_data_id`)
    WHERE pmd.`url` = '$option1'
    LIMIT 1";


$row = fetch_row($sql);

$ss_id =$row['slideshow_id'];
$hero_photo_pmd = $row['photo'];

if(!empty($row))
{
	@extract($row);

	$tags_arr['title']          	= $title;
	$tags_arr['mdescr']         	= $meta_description;
	$tags_arr['og_url']         	= $htmlroot.'/'.$full_url;
	$tags_arr['og_meta_description']= $og_meta_description;
	$tags_arr['og_image']       	= $og_image;
	$tags_arr['og_title']       	= $og_title;
	$tags_arr['heading']        	= ($heading) ? $heading : '';
	//$tags_arr['sub-heading']        = ($price) ? $price : '';
	$tags_arr['introduction']      	= ($introduction) ? $introduction : '';
	//$tags_arr['slideshow_view']     = ($slideshow_id) ? ''..'' : '';
	$tags_arr['beds']          		= $beds;
	$tags_arr['pax']         		= $pax;
	$tags_arr['sqm']         		= $sqm;
	$tags_arr['from_price']         = $from_price;

    if($og_image){
			$tags_arr['og_image'] = $og_image;
	}else if($ss_id){
		$slideshow_sql = fetch_all("SELECT `full_path`, `width`, `height`, `caption`, `alt_text`
		    FROM `photo`
		    WHERE `photo_group_id` = '{$ss_id}'
		    AND `full_path` != ''
		    ORDER BY `rank`");
		$tags_arr['og_image'] = $slideshow_sql[0][full_path];
	}else if($hero_photo_pmd){
		$tags_arr['og_image'] = $hero_photo_pmd;
	}else{
		$tags_arr['og_image']='';
	}


	$tags_arr['content']        .= get_content($page_meta_data_id);


	$attached_ids  = fetch_value("SELECT GROUP_CONCAT(`feature_id`) FROM `tours_has_feature` WHERE `tours_id` = '$id'");

	$sql2 = "SELECT `name` FROM `tours_feature` WHERE `id` IN ($attached_ids) AND `status` = 'A' ORDER BY `rank`";
    $feat_arr = fetch_all($sql2);

    $feat_list = '';

    if(!empty($feat_arr))
    {
    	foreach ($feat_arr as $feat) {

    		$list .= '<li>'.$feat['name'].'</li>';
    	}
    }

if(!empty($page_bookings->url) && ($resbook_id != null || $booking_engine_url != null))
{
   $active_btn_cls = ($page_bookings->id == $page_id) ? ' active' : '';
   if(!empty($resbook_id))
   {
        $booknow  = '<a href="'.$page_bookings->url.'" title="" class="booking-btn'.$active_btn_cls.'">'.$ctaTourBookingBtnText.'</a>';
   }elseif(!empty($booking_engine_url))
   {
        $booknow   = '<a href="'.$booking_engine_url.'" target="_blank" title="" class="booking-btn'.$active_btn_cls.'">'.$ctaTourBookingBtnText.'</a>';
   }
}else{
    $booknow  = '';
}




    $tags_arr['tours_view']  = <<<HTML
	  	<section class="section section--accom">
		  	<div class="container">
		  		<div class="accom--wrapper">
		            <div class="row accom--content">
		     			<div class="col-xs-12 col-sm-6 col-md-4 col-price">
							<div class="price-quicklink">
								<div class="price-bg">
									From {$currencyIconView} {$from_price} <span class="currency_text">{$currencyText}</span>
								</div>
								<p class="price-des">per person</p>
							</div>
		     			</div>
	            	</div>
	        	</div>
		  		<div class="features--wrapper">
		            <div class="row features--content">
		                <div class="col-xs-12 col-heading">
		     				<h2 class="feature-heading">Inclusions</h2>
		     			</div>
		     			<div class="col-xs-12 col-list">
							<ul class="features--list">
								{$list}
							</ul>
		     			</div>
	            	</div>
	        	</div>
	        	<div class="col-xs-12">
	        		<div class="acco-btn-wrapper">
	        			<div class="col-enquire">
		        			<div class="enquire-btn">
		        				<a href="{$page_contact->full_url}" class="btn btn-grey">{$ctaTourEnquireBtnText}</a>
		        			</div>
		        		</div>
		        		<div class="col-booknow">
		        			<div class="booknow-btn">
		        				{$booknow}
		        			</div>
		        		</div>
	        		</div>
	        	</div>
	        </div>
    	</section>
HTML;

require_once 'views/nav.php';
require_once 'gallery.php';

}




?>
