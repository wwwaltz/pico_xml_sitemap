<?php
/**
* Output sitemap XML. If you want, output to sitemap.xml
* @author	Yuki Watanabe
* @link		http://github.com/wwwaltz
* @license	http://opensource.org/licenses/MIT
*/
class pico_xml_sitemap
{
	private $fpath		= true; // If true, output sitemap.xml to pico root.
	private $is_ignored	= true; // If true, no output sitemap I

	//-----------------------------------------------
	//-----------------------------------------------
	public function __construct()
	{
		$this->fpath = CONTENT_DIR."../sitemap.xml";
		if( !is_writable( dirname($this->fpath) ) )
		{
			$this->fpath = null;
		}
	}

	//-----------------------------------------------
	//-----------------------------------------------
	public function request_url( &$url )
	{
		if( count($_GET) == 1 && array_key_exists( "sitemap", $_GET ) )
		{
			$this->is_ignored = false;
		}
	}

	//-----------------------------------------------
	//-----------------------------------------------
	public function get_pages( &$pages, &$current_page, &$prev_page, &$next_page )
	{
		global $config;
		if( !$this->is_ignored )
		{
			$xml = "";

			// about each content.
			$lasttime = -1;
			foreach( $pages as $page )
			{
				$time = strtotime( $page["date"] );
				if( $time > $lasttime ){ $lasttime = $time; }

				$xml_url = "";
				$xml_url.="<url>";
				$xml_url.="<loc>".$page["url"]."</loc>";
				$xml_url.="<lastmod>".date('Y-m-d', $time)."</lastmod>";
				$xml_url.="<priority>1.0</priority>";
				$xml_url.="</url>";
				$xml.= $xml_url;
			}

			// about top.
			$xml_url = "";
			$xml_url.= "<url>";
			$xml_url.= "<loc>".$config["base_url"]."</loc>";
			$xml_url.= "<lastmod>".date('Y-m-d', $lasttime)."</lastmod>";
			$xml_url.= "<priority>1.0</priority>";
			$xml_url.= "</url>";

			$xml = "<?xml version='1.0' encoding='UTF-8'?>\n<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>".$xml_url.$xml."</urlset>";
			if( $this->fpath )
			{
				file_put_content( $this->fpath, $xml );
			}

			header("Content-Type: text/xml");
			die($xml);
		}
	}
}
//?>