<?

class HeadersManager {
	
	public function charset () {
		header("Content-type: text/html;charset=utf-8");
		return $this;
	}
	
	public function noCache () {
		//запрет кэширования
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Cache-Control: post-check=0,pre-check=0", false);
		header("Cache-Control: max-age=0", false);
		header("Pragma: no-cache");
		return $this;
	}
	
	public function notFound404 () {
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		return $this;
	}
	
}
?>