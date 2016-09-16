<?php
/**
 * Use for capturing products by UPC codes.
 * $apikey is an injected argument and needs to be handled at the service.
 */

namespace Treetop1500\Util;
use GuzzleHttp\Client;


class GuzzleWalmart
{

	protected $apiKey;

	/**
	 * WalmartProducts constructor.
	 * @param $apiKey
	 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;
	}

	/**
	 * @param array $upcs
	 * @return array
	 */
	public function getProducts(Array $upcs) {

		$products = array();

		// Api currently doesn't support multiple upc code parameters, so do each individually :(

		foreach($upcs as $code) {
			$endpoint = "http://api.walmartlabs.com/v1/items?upc=$code&apiKey=$this->apiKey&format=json";
			$client = new Client();
			try {
				$res = $client->get($endpoint);
			} catch(\Exception $e) {
				// todo add some logging here
			}
			if (isset($res) && $res->getStatusCode() == 200) {
				$content = json_decode($res->getBody()->getContents());
				array_push($products,$content->items[0]);
			}
		}

		return $products;
	}
}