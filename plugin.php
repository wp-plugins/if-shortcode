<?php
/*
Plugin Name: If Shortcode
Author: geomagas
Description: Provides an "if" shortcode to conditionally render content
Text Domain: if-shortcode
Version: 0.2.0
*/

$if_shortcode_filter_prefix='evaluate_condition_';
$if_shortcode_block=NULL;

add_shortcode('if','process_if_shortcode');

function process_if_shortcode($atts,$content)
	{
	global $if_shortcode_filter_prefix;
	$false_strings=array('0','','false','null','no');
	$atts=normalize_empty_atts($atts);
	$result=false;
	foreach($atts as $condition=>$val) 
		{
		$mustbe=!in_array($val,$false_strings,true); // strict, or else emty atts don't work as expected
		$evaluate=apply_filters("{$if_shortcode_filter_prefix}{$condition}",false);
		$result|=$evaluate==$mustbe;
		}
	global $if_shortcode_block;
	$save_block=$if_shortcode_block;
	$if_shortcode_block=array('result'=>$result,'else'=>'',);
	$then=do_shortcode($content);
	$else=$if_shortcode_block['else'];
	$if_shortcode_block=$save_block;
	return $result?$then:$else;
	}
	
add_shortcode('else','process_else_shortcode');

function process_else_shortcode($atts,$content)
	{
	global $if_shortcode_block;
	if($if_shortcode_block&&!$if_shortcode_block['result'])
		$if_shortcode_block['else'].=do_shortcode($content);
	return '';
	}
	
add_shortcode('eitherway','process_eitherway_shortcode');

function process_eitherway_shortcode($atts,$content)
	{
	$content=do_shortcode($content);
	global $if_shortcode_block;
	if($if_shortcode_block) $if_shortcode_block['else'].=$content;
	return $content;
	}
	
// add supported conditional tags
add_action('init','if_shortcode_conditional_tags');

function if_shortcode_conditional_tags()
	{
	$supported=array(
		'is_single',
		'is_singular',
		'is_page',
		'is_home',
		'is_front_page',
		'is_category',
		'is_tag',
		'is_tax',
		'is_sticky',
		'is_author',
		'is_archive',
		'is_year',
		'is_month',
		'is_day',
		'is_time',
		'is_feed',
		'is_search',
		'comments_open',
		'pings_open',
		'is_404',
		'is_user_logged_in',
		'is_super_admin',
		);
	global $if_shortcode_filter_prefix;
	foreach($supported as $tag)
		add_filter("{$if_shortcode_filter_prefix}{$tag}",function()use($tag){return $tag();});
	}

// normalize_empty_atts found here: http://wordpress.stackexchange.com/a/123073/39275
function normalize_empty_atts($atts) 
	{
	foreach($atts as $attribute=>$value) 
		{
		if(is_int($attribute))
			{
			$atts[strtolower($value)]=true;
			unset($atts[$attribute]);
			}
		}
	return $atts;
	}
	


