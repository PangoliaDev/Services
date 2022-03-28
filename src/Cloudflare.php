<?php
declare( strict_types = 1 );

namespace Pangolia\Services;

class Cloudflare extends AbstractService {

	/**
	 * @var string
	 */
	protected string $email;

	/**
	 * @var string
	 */
	protected string $api_key;

	/**
	 * @var string
	 */
	protected string $zone_id;

	/**
	 * @var string
	 */
	protected string $url = 'https://api.cloudflare.com';

	/**
	 * @var string|bool
	 */
	public $response;

	/**
	 * @param $config
	 */
	public function __construct( $config ) {
		$this->email = $config['email'] ?? '';
		$this->api_key = $config['api_key'] ?? '';
		$this->zone_id = $config['zone_id'] ?? '';
	}

	/**
	 * Purge the cloudflare cache
	 *
	 * You can also purge specific files like
	 * purge_cache(['files' => ['example.com/styles.css'])
	 *
	 * @param array<string, mixed> $fields
	 * @return bool|string
	 */
	public function purge_cache( array $fields = [ 'purge_everything' => true ] ) {
		$this->make_request(
			[
				'query'  => "/client/v4/zones/{$this->zone_id}/purge_cache",
				'method' => 'DELETE',
				'fields' => $fields,
			]
		);
		return $this->response;
	}

	/**
	 * Post curl
	 *
	 * @param array<string, mixed> $data
	 * @return void
	 */
	private function make_request( array $data ): void {
		$ch = \curl_init();
		\curl_setopt( $ch, CURLOPT_URL, $this->create_request_url( $data['query'] ) );
		\curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $data['method'] );
		\curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->create_http_headers() );
		\curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->create_post_fields( $data['fields'] ) );
		\curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$this->response = \curl_exec( $ch );
		\curl_close( $ch );
	}

	/**
	 * Create the Curl headers
	 *
	 * @return array<int|string, string>
	 */
	private function create_http_headers(): array {
		$http_header = [];
		$http_header[] = 'Content-Type: application/json';
		$http_header[] = "X-Auth-Email: {$this->email}";
		$http_header[] = "Authorization: Bearer {$this->api_key}";
		$http_header[] = 'cache-control: no-cache';
		return $http_header;
	}
}
