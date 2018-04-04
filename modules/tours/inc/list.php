<?php

$sql = "SELECT
		    t.`from_price`,
		    t.`beds`,
		    t.`sqm`,
		    t.`pax`,
		    pmd.`name`,
		    pmd.`short_description`,
		    pmd.`thumb_photo`,
		    pmd.`full_url`
		FROM
		    `tours` t
		LEFT JOIN `page_meta_data` pmd ON
		    (pmd.`id` = t.`page_meta_data_id`)
		WHERE
		    pmd.`status` = 'A'
		ORDER BY
		    pmd.`rank`";

$all_tours = fetch_all($sql);

if(!empty($all_tours))
{	
	$index = 0;

	foreach ($all_tours as $tours) {
		
		$index++;
		$price= $tours['from_price'];
		
		$tours_items .= <<<HTML
			<div class="col-xs-12 grid--row">
				<div class="row">
									
					<div class="col-xs-12 col-sm-5 ql-img">
						<div class="grid--row-image">						
							<a href="{$tours['full_url']}">
								<div class="hero-image" style="background-image:url('{$tours['thumb_photo']}');">
								</div>	
							</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-7">			
						<div class="grid--row-content">
							<div class="details">
								<h2 class="heading"><a href="{$tours['full_url']}"><span>{$tours['name']}</span></a></h2>
								<p class="details__description">{$tours['short_description']}</p>
								

								<div class="find-more hidden-xs"><a class="btn btn-ql-tours" href="{$tours['full_url']}">{$ctaTourDetailsBtnText}</a>
								</div>
								<div class="price">
									<span class="btn price-sticker">FROM <span class="pricetag">$currencyIconView</span><span class="num-p">$price</span><span class="currency_text">$currencyText</span></span>
									<div class="numofpeople">
										<p>per person</p>
									</div>
								</div>

								<div class="find-more hidden-lg hidden-md hidden-sm"><a class="btn btn-ql-tours" href="{$tours['full_url']}">Find Out More</a>
								</div>
							</div>
						</div>
					</div>
				
				</div>	
			</div>
HTML;
	}


	$tours_list = <<<HTML
	

		<section class="activity-list">
			<div class="container grid--wrapper">
				<div class="row">
					{$tours_items}
				</div>
			</div>
		</section>

HTML;

	$tags_arr['mod_view'] = $tours_list;
}


?>