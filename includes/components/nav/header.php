<?php

include_once "{$classdir}/mobile_detect.php";


if( !function_exists('main_navigation') )
{
    $level = 0;



    function main_navigation($parent = 0, $current_page = '')
    {

        global $max_pages, $max_pages_generation, $level, $page_arr, $rootfull, $static_map_img, $page_tours,$page_tours;


        $sql = "SELECT gp.`id` AS page_id, pmd.`menu_label`, pmd.`title`, pmd.`full_url`, pmd.`url`, gp.`parent_id`
        FROM general_pages gp
        LEFT JOIN `page_meta_data` pmd
        ON(pmd.`id` = gp.`page_meta_data_id`)
        WHERE pmd.`status` = 'A'
        AND gp.`parent_id` = '$parent'
        AND (pmd.`menu_label` != '')
        ORDER BY pmd.`rank` ASC";

        $pages  = fetch_all($sql);


        $html   = '';

        if( !empty($pages) )
        {
            $total_pages = count($pages);

            foreach ($pages as $page)
            {

                $page_id              = $page['page_id'];

                $item_cls             = ($page['url'] === $current_page || $page_id === $page_arr['parent_id']) ? 'active' : '';
                $url                  = $page['full_url'];


                $sub_menu = '';
                $icon     = '';
                $icon2    = '';
                $home_cls = '';

                $sub_menu_links = main_navigation($page_id, $current_page );
                
                if (!empty($sub_menu_links)) {

                    $sub_menu = '<ul class="header__nav__sub-list">';
                    $sub_menu .= $sub_menu_links;
                    $sub_menu .= '</ul>';
                } else{
                  
                    // $sub_menu = '<ul>';
                    // $sub_menu .= $sub_menu_links;
                    // $sub_menu .= '</ul>';   
                }

                //this one is for the sub nav items for tours&activities
                if($page_id == $page_tours->id)
                {

                    //make sub menu from tourss
                    $sql2 = "SELECT pmd.`menu_label`,pmd.`title`,pmd.`full_url`
                           FROM `tours` t
                            LEFT JOIN `page_meta_data` pmd
                            ON(t.`page_meta_data_id` = pmd.`id`)
                            WHERE pmd.`status` = 'A'
                            AND pmd.`menu_label` != ''
                            ORDER BY pmd.`rank`";

                   $tours_arr = fetch_all($sql2);

                   $sub_menu = '<ul class="toggle-sub-nav header__nav__sub-list">';
                    foreach ($tours_arr as $tours) {
                        $sub_menu .= '<li class="header__nav__sub-item"><a href="'.$tours['full_url'].'" title="'.$tours['title'].'" class="header__nav__sub-link">'.$tours['menu_label'].'</a></li>';
                    }
                    $sub_menu .= '</ul>';
                }
                //end
                if( $sub_menu )
                {
                    $icon = '<span class="header__nav__list-toggle"><i class="fa fa-angle-down"></i></span>';    

                    $item_cls .= ' has-sub';
                }
                
                if($item_cls) $item_cls = trim($item_cls);

                $html .= '<li class="header__nav__item '.$item_cls.'">';
                $html .= $icon;
                $html .= '<a href="'.$url.'" title="'.$page['title'].'">'.$page['menu_label'].'</a>';
                $html .= $sub_menu;

                $html .= '</li>';


            }

            return sprintf('%s', $html);

        }

        return $html;
    }
}

$menu = main_navigation(0, $page);

$tags_arr['nav-main'] = ($menu) ? '<ul class="header__nav__list">'.$menu.'</ul>' : '';

?>