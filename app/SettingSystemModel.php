<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingSystemModel extends Model {

	protected $table="setting_system";
	protected $fillable=["fullname",
						"alias",
						"article_perpage",						
						"product_perpage",
						"product_width",
						"product_height",
						"currency_unit",
						"smtp_host",
						"smtp_port",
						"encription",
						"authentication",
						"smtp_username",
						"smtp_password",
						"email_from",
						"email_to",
						"from_name",
						"to_name",
						"contacted_phone",
						"address",
						"website",
						"telephone",
						"opened_time",
						"opened_date",
						"contacted_name",
						"facebook_url",
						"twitter_url",
						"google_plus",
						"youtube_url",
						"instagram_url",
						"pinterest_url",
						"slogan_about",
						"map_url",	
						
						"sort_order",
						"status",
						"created_at",
						"updated_at"];		
}
