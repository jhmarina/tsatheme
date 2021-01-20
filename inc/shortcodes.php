<?php

function instagram_embed($atts, $content = null) {
	return '<iframe class="instagram-media instagram-media-rendered" id="instagram-embed-0" src="'.$content.'embed/?cr=1&amp;v=12&amp;wp=658" allowtransparency="true" allowfullscreen="true" frameborder="0" height="862" data-instgrm-payload-id="instagram-media-payload-0" scrolling="no" style="background: white; max-width: 658px; width: calc(100% - 2px); border-radius: 3px; border: 1px solid rgb(219, 219, 219); box-shadow: none; display: block; margin: 0px 0px 12px; padding: 0px;"></iframe>';
}
add_shortcode('instagram_embed','instagram_embed');

function xadvice($atts, $content = null) {
	$atts = shortcode_atts([
		'icon' => 'fa-quote-left',
        'title' => '',
        'name'=> '',
    ], $atts, 'xadvice');

	return '<div class="xadvice_shorcode">
<div class="xadvice_icon"><i class="fa '.$atts['icon'].'" aria-hidden="true"></i></div>
<div class="xadvice_content"><span class="xadvice_name">'.$atts['name'].'</span><span class="xadvice_title">'.$atts['title'].'</span><p></p>
<div class="xadvice_main">'.$content.'</div>
</div>
</div>';
}
add_shortcode('xadvice','xadvice');

function shortcode_note($atts, $content = null) {

	return '<div class="shortcode_note">
<div class="shortcode_note_icon no-underline"> <img src="'.get_template_directory_uri().'/images/foco.png" alt="foco"><p></p></div>
<div class="shortcode_note_content">'.$content.' </div>
<p></p></div>';
}
add_shortcode('shortcode_note','shortcode_note');



function i2_pros_and_cons($atts, $content = null)
{

	$atts = shortcode_atts([
		'pros' => '',
        'cons' => '',
        'show_title'=> false,
        'title' => '',
        'show_button'=> false,
        'link_text' => '',
        'link' => '',
        'pros_title' => __('Pros','paperback'),
        'cons_title' =>  __('Cons', 'paperback'),
        'button_icon'=>'',
        'pros_icon' => '',
        'cons_icon' => '',
        'heading_pros_icon' => '',
        'heading_cons_icon' => '',
        'use_heading_icon' => '',
        'className'=>'',
        'button_display_block'=> false
    ], $atts, 'i2_pros_and_cons');

    $prosIcon = 'fa fa-thumbs-o-up';
    $consIcon = 'fa fa-thumbs-o-down';

   if(strlen($content) > 10){
     $data = explode ("###ER##GF####", do_shortcode($content), 2);
     $atts['pros'] = $data[0];
     $atts['cons'] = $data[1];
   }

    $data  = '<div class="i2-pros-cons-icons i2-pros-cons-main-wrapper">';

    if($atts['show_title'] == 'true') {
        $data .= '<div class="i2pctitle">' . $atts['title']  .'</div>';
    }

    $data .= '<div class="i2-pros-cons-wrapper"><div class="i2-pros">';
    /*if($useHeadingIcon == 1){
        $data .= "<div class='heading-icon'><i class='{$headingProsIcon}'></i></div>";
    }*/
    $data .= '<div class="i2-pros-title">' . $atts['pros_title']  .'</div>';
    $data .= '<div class="section">';
    $data .= i2_pros_cons_list($atts['pros'], TRUE , $prosIcon);
    $data .= '</div></div>';

    $data .= '<div class="i2-cons">';
    /*if($useHeadingIcon == 1){
        $data .= "<div class='heading-icon'><i class='{$headingConsIcon}'></i></div>";
    }*/
    $data .= '<div class="i2-cons-title">' . $atts['cons_title']  .'</div>';
    $data .= '<div class="section">';
    $data .= i2_pros_cons_list($atts['cons'], TRUE , $consIcon);
    $data .= '</div></div></div>';

    $data .= '</div>';

    return $data;
}
add_shortcode('i2_pros_and_cons', 'i2_pros_and_cons');


function i2_pros_cons_list($data, $useIcon, $icon){
    $useIconClass = $useIcon == 1? "has-icon" : "no-icon";
    $lines = explode("\n", $data);
    if(empty($lines[1])) {
        $lines = explode("|", $data);
    }

    $list = "<ul class='{$useIconClass}'>";
     foreach ($lines as $key => $value) {
         if(strlen(trim(strip_tags($value))) > 0){
           $list .= "<li>" . ($useIcon == 1 ? "<i class='{$icon}'></i>" : "") . $value . "</li>";
         }
     }
      return	$list . '</ul>';
}


add_shortcode('i2pc','i2_pros_and_cons');
function i2_cons_sc($attr, $content = null) {
    return  $content;
}
function i2_pros_sc($attr, $content = null) {
    return  $content . "###ER##GF####";
}
add_shortcode('i2pros','i2_pros_sc');
add_shortcode('i2cons','i2_cons_sc');



function shortcode_amazon($atts, $content = null) {
	$atts = shortcode_atts([
		'template' => 'link',
		'code' => '',
		'image' => '',
		'title' => '',
		'buy_text' => 'Comprar en Amazon',
		'ribbon' => 'AMAZON',
		'link' => '',
		'new_dti' => '',
		'amazon_country' => ((! empty(trim( get_option( 'paperback_amazon_country' ) ))) ? trim( get_option( 'paperback_amazon_country' ) ): 'amazon.es'),
        'tag' => trim( get_option( 'paperback_amazon_tag' ) ),
    ], $atts, 'shortcode_amazon');

	$longTitle = $atts['title'];

    if(get_option('dti_text_button_amazon_box') != false)
        $atts['buy_text'] = get_option('dti_text_button_amazon_box');

    if(get_option('dti_text_title_product_lenght') != false)
        $atts['title'] = substr($atts['title'], 0, get_option('dti_text_title_product_lenght'));
    else
        $atts['title'] = substr($atts['title'], 0, 60);

    if(get_option('dti_text_title_product_lenght') != false)
        $review = get_option('dti_text_button_review_box');
    else
        $review = 'VER OPINIONES EN AMAZON';

	if($atts['template'] == 'box') {

        $h3Box = $atts['new_dti'] == "yes" ?'<h3 class="h3body">'.trim($atts['title']).'</h3>':'';

        $box = '<div class="aawp">
<div class="aawp-product aawp-product--horizontal aawp-product--ribbon aawp-product--sale" data-aawp-product-id="' . $atts['code'] . '" data-aawp-product-title="' . $atts['title'] . '">
<p>    <span class="aawp-product__ribbon aawp-product__ribbon--sale">' . $atts['ribbon'] . '</span></p>
<div class="aawp-product__thumb">
        <a class="aawp-product__image-link no-underline" href="' . ((empty($atts['link'])) ? "https://www." . $atts['amazon_country'] . "/dp/" . $atts['code'] . "?tag=" . $atts['tag'] : $atts['link']) . '" title="' . $atts['title'] . '" rel="nofollow" target="_blank">
            <img class="aawp-product__image" src="' . $atts['image'] . '" alt="' . $atts['title'] . '">
        </a><p></p></div>
<div class="aawp-product__content">
        <a class="aawp-product__title" href="' . ((empty($atts['link'])) ? "https://www." . $atts['amazon_country'] . "/dp/" . $atts['code'] . "?tag=" . $atts['tag'] : $atts['link']) . '" title="' . $atts['title'] . '" rel="nofollow" target="_blank"><br>
            ' . $atts['title'] . '        </a><p></p>
<div class="aawp-product__description">
                    </div>
<p></p></div>
<div class="aawp-product__footer">

<p>                <a class="aawp-button" href="' . ((empty($atts['link'])) ? "https://www." . $atts['amazon_country'] . "/dp/" . $atts['code'] . "?tag=" . $atts['tag'] : $atts['link']) . '" title="' . $atts['buy_text'] . '" target="_blank" rel="nofollow">🛒 ' . $atts['buy_text'] . '</a>
            </p></div>
</div>
</div>';

        $reviewH3 = $atts['new_dti'] == "yes" ?'<div class="botonamazon"><a href="' . ((empty($atts['link'])) ? "https://www." . $atts['amazon_country'] . "/dp/" . $atts['code'] . "?tag=" . $atts['tag'] : $atts['link']) . '" target="_blank" rel="nofollow noopener noreferrer">'.$review.'</a></div>':'';

        $longTitle = $atts['new_dti'] == "yes" ?$longTitle:'';

        return $h3Box . $box . $longTitle . $reviewH3;
	}

	if($atts['template'] == 'button')
		return '<a href="https://www.'.$atts['amazon_country'].'/dp/'.$atts['code'].'?tag='.$atts['tag'].'" class="aawp-button" target="_blank">🛒 '.$atts['buy_text'].'</a>';

	if($atts['template'] == 'href')
		return 'https://www.'.$atts['amazon_country'].'/dp/'.$atts['code'].'?tag='.$atts['tag'];
	else
		return '<a href="https://www.'.$atts['amazon_country'].'/dp/'.$atts['code'].'?tag='.$atts['tag'].'" target="_blank">'.$atts['buy_text'].'</a>';
}
add_shortcode('shortcode_amazon','shortcode_amazon');


function shortcode_ranking($atts, $content = null) {
    $data = do_shortcode($content);

    $sticky_class = '';
    if( ! empty($atts['sticky']) && get_option('dti_sticky') == "yes")
    	$sticky_class = ' js_sticky';

    $exit = '';
    if( ! empty($atts['exit'])  && get_option('dti_modal_exit') == "yes") {
    	preg_match_all('/<a class="link-wrap".*href="(.*)".*<div class="col-0 ">(.*)<.*<div class="product">.*src="(.*)".*<p class="partner-name">(.*)<.*class="partner-link">(.*)</siU', $data, $matches);
    	if( ! empty($matches[1][0])) {
    		$exit = '<div id="ouibounce-modal">
          <div class="underlay"></div>
            <div class="modal">

<div class="modal-title">
<span><b>'.__( 'HERE ARE THE TWO BEST PRODUCTS', 'paperback' ).'</b><br>'.__( '(8 out of 10 visitors take advantage of these offers)', 'paperback' ).'</span>
<strong>'.__( 'HERE IS THE BEST', 'paperback' ).'</strong>
                </div>
                <div class="modal-body">
                    <div id="product-grid" style="margin: 0px;"> <div class="row row-products">
<div class="col-sm-6 col-product" style="border-bottom:none; border-right: 1px solid #e5e5e5 !important;"> <a href="'.$matches[1][0].'" target="_blank" class="link-block e-click"> <div class="tagline-prodotto tagline-prodotto-blue" style="margin: 0px 5px;font-size: 12px;">'.$matches[2][0].'</div> <img class="img-responsive" src="'.$matches[3][0].'" style="display: inline-block;"> <p class="title" style="color: #282e35; font-size: 16px;min-height: 77px;">'.$matches[4][0].'</p></span><a href="'.$matches[1][0].'" target="_blank" style="border-radius: 20px;" class="btn btn-success btn-rounded btn-less-padding e-click "> <span>'.$matches[5][0].'</span></a></div>
<div class="col-sm-6 col-product product2" style="border-bottom:none; border-right: 1px solid #e5e5e5 !important;"> <a href="'.$matches[1][1].'" target="_blank" class="link-block e-click"> <div class="tagline-prodotto tagline-prodotto-yellow" style="margin: 0px 5px;font-size: 12px;">'.$matches[2][1].'</div> <img class="img-responsive" src="'.$matches[3][1].'" style="display: inline-block;"> <p class="title" style="color: #282e35; font-size: 16px;min-height: 77px;">'.$matches[4][1].'</p></a><a href="'.$matches[1][1].'" target="_blank" style="border-radius: 20px;" class="btn btn-success btn-rounded btn-less-padding e-click "> <span>'.$matches[5][1].'</span></a></div> </div> </div>
                </div>

                <div class="modal-footer">
                    <p onclick="document.getElementById(\'ouibounce-modal\').style.display = \'none\';">'.__( 'No Thanks', 'paperback' ).'</p>
                </div>
            </div>
        </div>';
    	}
    }

	return $exit.'<div class="ranking-table-outer" style="margin-bottom: 20px;"><div class="ranking-table'.$sticky_class.'">
'.$data.'
</div></div>';
}
add_shortcode('shortcode_ranking','shortcode_ranking');



function shortcode_ranking_row($atts, $content = null) {
	$atts = shortcode_atts([
		'link' => '/',
        'text_review' => '',
        'link_review' => '',
        'image' => '',
        'top_text' => '',
        'cta_text' => '',
        'title'=> '',
        'description'=> '',
        'description_long'=> '',
        'score_number'=> '',
        'rating'=> '3',
        'li_1_text'=> '',
        'li_2_text'=> '',
        'li_3_text'=> '',
        'li_4_text'=> '',
        'type'=> '',
		'amazon_country' => ((! empty(trim( get_option( 'paperback_amazon_country' ) ))) ? trim( get_option( 'paperback_amazon_country' ) ): 'amazon.es'),
        'tag' => trim( get_option( 'paperback_amazon_tag' ) ),
    ], $atts, 'shortcode_ranking_row');

    $data = do_shortcode($content);

    if($atts['type'] == 'amazon')
    	$atts['link'] = 'https://www.'.$atts['amazon_country'].'/dp/'.$atts['link'].'?tag='.$atts['tag'];

    $col_0 = '';
    if( ! empty($atts['top_text'])){
        if(get_option('dti_text_first_header') != false)
            $atts['top_text'] = str_replace("Mejor opción", get_option('dti_text_first_header'), $atts['top_text']);

        if(get_option('dti_text_second_header') != false)
            $atts['top_text'] = str_replace("Mejor relación calidad precio", get_option('dti_text_second_header'), $atts['top_text']);

        $col_0 = '<div class="col-0 ">'.$atts['top_text'].'</div>';
    }


    $li_1 = '';
    if( ! empty($atts['li_1_text']))
        $li_1 = '<li style="margin: 5px 0">'.$atts['li_1_text'].'</li>';

    $li_2 = '';
    if( ! empty($atts['li_2_text']))
        $li_2 = '<li style="margin: 5px 0">'.$atts['li_2_text'].'</li>';

    $li_3 = '';
    if( ! empty($atts['li_3_text']))
        $li_3 = '<li style="margin: 5px 0">'.$atts['li_3_text'].'</li>';

    $li_4 = '';
    if( ! empty($atts['li_4_text']))
        $li_4 = '<li style="margin: 5px 0">'.$atts['li_4_text'].'</li>';

    if(get_option('dti_stars_product') == "yes" || get_option('dti_stars_product') == false){
        // Calculate the number of each type of star needed
        $full_stars  = floor( $atts['rating'] );
        $half_stars  = ceil( $atts['rating'] - $full_stars );
        $empty_stars = 5 - $full_stars - $half_stars;

            $stars = '<div class="post-ratings">
        '.str_repeat( '<img id="rating_336_2" src="/wp-content/plugins/wp-postratings/images/stars/rating_on.gif" />
            ', $full_stars ).'
        '.str_repeat( '<img id="rating_336_2" src="/wp-content/plugins/wp-postratings/images/stars/rating_half.gif" />
            ', $half_stars ).'
        '.str_repeat( '<img id="rating_336_2" src="/wp-content/plugins/wp-postratings/images/stars/rating_off.gif" />
            ', $empty_stars ).'
        </div>';
    }
    else{
        $stars = '';
    }

    if(get_option('dti_text_button_amazon_list') != false)
        $atts['cta_text'] = get_option('dti_text_button_amazon_list');

    if(get_option('dti_text_title_product_lenght') != false)
        $atts['title'] = substr($atts['title'], 0, get_option('dti_text_title_product_lenght'));
    else
        $atts['title'] = substr($atts['title'], 0, 60);

    if(!empty($li_1) && (get_option('dti_features_product') == "yes" || get_option('dti_features_product') == false)){
        $appendExpand = '<div class="expand-row"><svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1 1.5L8 8.5L15 1.5" stroke="#E5E5E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg><div class="overlay"></div></div>';
    }
    else{
        $appendExpand = '';
    }

	return '<div class="partner-row js_sticky-item"><a class="link-wrap" data-clkposition="1" data-clkname="academic" href="'.$atts['link'].'" target="_blank" rel="nofollow"></a>'.$col_0.'<div class="product"><img src="'.$atts['image'].'" class="logo skip-lazy" alt="logo"><div class="info-wrap"><p class="partner-name">'.$atts['title'].'</p><div class="stars-wrap"><div class="stars">'.$stars.'</div></div><p class="text"></p></div><div class="partner-link">'.$atts['cta_text'].'</div></div><div class="col-2"><div class="linebreak"></div><div class="info-wrap">'.$atts['description_long'].'<ul style="margin: 10px 0; padding: 0 20px;">
	'.$li_1.'
	'.$li_2.'
	'.$li_3.'
	'.$li_4.'
	</ul></div>
	<div class="image-wrap"><img src="'.$atts['image'].'" class="skip-lazy" alt="logo"><a data-clkposition="1" data-clkname="academic" href="'.$atts['link'].'" target="_blank" rel="nofollow" class="link">'.$atts['cta_text'].' &gt;</a></div></div>'.$appendExpand.'</div>';
}
add_shortcode('shortcode_ranking_row','shortcode_ranking_row');

function dti_shortcode_divider( $atts = null, $content = null ) {

	$atts = shortcode_atts( array(
			'top'           => 'yes',
			'text'          => __( 'Go to top', 'paperback' ),
			'style'         => 'default',
			'divider_color' => '#999999',
			'link_color'    => '#999999',
			'size'          => '3',
			'margin'        => '15',
			'class'         => ''
		), $atts, 'divider' );

	// Prepare TOP link
	$top = $atts['top'] === 'yes'
		? '<a href="#" style="color:' . $atts['link_color'] . '">' . do_shortcode( $atts['text'] ) . '</a>'
		: '';

	return '<div class="dti-divider dti-divider-style" style="margin:' . $atts['margin'] . 'px 0;border-width:' . $atts['size'] . 'px;border-color:' . $atts['divider_color'] . '">' . $top . '</div>';

}
add_shortcode('dti_divider','dti_shortcode_divider');

?>
