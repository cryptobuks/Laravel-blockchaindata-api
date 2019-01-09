<?php

/*
 * This file is part of the Laravel blockchain package.
 *
 * (c) Famurewa Taiwo <famurewa_taiwo@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Waygood\BlockchainData;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Waygood\BlockchainData\Exceptions\BlockchainDataException;
use Auth;

class BlockchainData
{
	/**
     * An Instance of Client
     * @var Client
     */
    protected $client;
	protected $format = 'array'; // raw, decoded, array
	protected $placeholder;

	/**
	* This is the base url for blockchain
	*/
	protected $base_url = 'https://blockchain.info/';
	/**
     *  Response from requests made to blockchain
     * @var mixed
     */
    protected $response;

 	public function __construct() {
 		$this->setClientRequestOptions();
 	}   
 	/**
     * Set options for making the Client request
     */
    private function setClientRequestOptions()
    {
        $this->client = new Client(
            [
                'base_uri' => $this->base_url,
            ]
        );
    }
    /**
     * @param string $relative_url
     * @param string $method
     * @param array $body
     * @return 
     * @throws 
     */
    private function setResponse($relative_url, $method, $body = [])
    {	
    	if(count($body) == 0) {
    		$this->response = $this->client->request($method, $relative_url, ['http_errors' => false]);
    	}else{
    		$this->response = $this->client->request($method, $relative_url, ['http_errors' => false, 'query' => $body]);
    	}
        return $this;
	}
 	/**
     * Get the whole response from a get operation, decoded according to the set format
     * @return array
     */
    private function getResponse()
    {
		if (intval($this->response->getStatusCode())>=400) {
			return false;
		}
		switch ($this->format) {
			case 'raw':
				return $this->response->getBody();
				break;
			case 'decode':
				return json_decode($this->response->getBody());
				break;
			case 'array':
			default:
				return json_decode($this->response->getBody(), true);
				break;
		}
	}
    private function setFormat($format)
    {	
    	if (in_array($format, ['raw','decoded','array'])) {
    		$this->format = $format;
    	}
        return $this;
	}
    /**
    * @return This returns an array of currencies
    */
	public function getBlock($block_hash, $format='JSON') {
		$uri = '/rawblock/'.urlencode($block_hash);
		if ($format!='JSON') $uri = '?format=hex';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
    /**
    * @return This returns an array of currencies
    */
	public function getTransaction($tx_hash, $format='JSON') {
		$uri = '/rawtx/'.urlencode($tx_hash);
		if ($format!='JSON') $uri = '?format=hex';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function getChart($chart_type) {
		$uri = '/charts/'.urlencode($chart_type) . '?format=json';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function blocksAtHeight($block_height) {
		$uri = '/charts/'.urlencode($block_height) . '?format=json';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function getAddress($bitcoin_address, $limit=50, $offset=0) {
		switch ($bitcoin_address) {
			case 'next':
				// get call data
				$get = $placeholder[__METHOD__];
				$get['offset'] = $get['offset'] + $get['limit'];
				$placeholder[__METHOD__] = $get;
				// reset call data
				$bitcoin_address = $get['bitcoin_address'];
				unset($get['bitcoin_address']);
				break;
			case 'previous':
				// get call data
				$get = $placeholder[__METHOD__];
				$get['offset'] = $get['offset'] - $get['limit'];
				$placeholder[__METHOD__] = $get;
				// reset call data
				$bitcoin_address = $get['bitcoin_address'];
				unset($get['bitcoin_address']);
				break;
			default:
				// prepare call data
				$get = [];
				$get['limit']  = intval($limit);
				$get['offset'] = intval($offset);
				if (!is_scalar($bitcoin_address)) {
					$bitcoin_address = implode('|', $bitcoin_address);
				}
				// save call data
				$placeholder[__METHOD__] = $get;
				$placeholder[__METHOD__]['bitcoin_address'] = $bitcoin_address;
				break;
		}
		$uri = '/multiaddr?active='.urlencode($bitcoin_address).'&'.http_build_query($get);

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function unspentAddress($bitcoin_address, $limit=50, $offset=0) {
		switch ($bitcoin_address) {
			case 'next':
				// get call data
				$get = $placeholder[__METHOD__];
				$get['offset'] = $get['offset'] + $get['limit'];
				$placeholder[__METHOD__] = $get;
				// reset call data
				$bitcoin_address = $get['bitcoin_address'];
				unset($get['bitcoin_address']);
				break;
			case 'previous':
				// get call data
				$get = $placeholder[__METHOD__];
				$get['offset'] = $get['offset'] - $get['limit'];
				$placeholder[__METHOD__] = $get;
				// reset call data
				$bitcoin_address = $get['bitcoin_address'];
				unset($get['bitcoin_address']);
				break;
			default:
				// prepare call data
				$get = [];
				$get['limit']  = intval($limit);
				$get['offset'] = intval($offset);
				if (!is_scalar($bitcoin_address)) {
					$bitcoin_address = implode('|', $bitcoin_address);
				}
				// save call data
				$placeholder[__METHOD__] = $get;
				$placeholder[__METHOD__]['bitcoin_address'] = $bitcoin_address;
				break;
		}
		$uri = '/unspent?active='.urlencode($bitcoin_address).'&'.http_build_query($get);

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function balanceAddress($bitcoin_address) {
		if (!is_scalar($bitcoin_address)) {
			$bitcoin_address = implode('|', $bitcoin_address);
		}
		$uri = '/balance?active='.urlencode($bitcoin_address);

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function latestBlock() {
		$uri = '/latestblock';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function unconfirmedTransactions() {
		$uri = '/unconfirmed-transactions?format=json';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function dailyBlocks($timestamp) {
		$uri = '/blocks/'.urlencode($timestamp).'?format=json';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}
	/**
    * @return This returns an array of currencies
    */
	public function poolBlocks($pool_name) {
		$uri = '/blocks/'.urlencode($pool_name).'?format=json';

		$response = $this->setResponse($uri, 'GET')->getResponse();
		return $response;
	}

}
