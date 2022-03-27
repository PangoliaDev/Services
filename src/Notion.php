<?php
declare( strict_types = 1 );

namespace Pangolia\Services;

class Notion extends AbstractService {

	/**
	 * @var string
	 */
	protected string $secret_token;

	/**
	 * @var string
	 */
	protected string $version = '2022-02-22';

	/**
	 * @var string
	 */
	protected string $url = 'https://api.notion.com';

	/**
	 * @var string|bool
	 */
	public $response;

	/**
	 * @param array<string, mixed> $config
	 */
	public function __construct( array $config ) {
		$this->secret_token = $config['secret_token'] ?? '';
	}

	/**
	 * Create a page in notion.
	 *
	 * @param array<int|string, mixed> $fields
	 * @return bool|string
	 */
	public function create_page( array $fields = [] ) {
		$this->make_request(
			[
				'query'  => '/v1/pages',
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
	private function make_request( array $data ) {
		$ch = \curl_init();
		\curl_setopt_array( $ch, [
			CURLOPT_URL            => $this->create_request_url( $data['query'] ),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'POST',
			CURLOPT_POSTFIELDS     => $this->create_post_fields( $data['fields'] ),
			CURLOPT_HTTPHEADER     => $this->create_http_headers(),
		] );
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
		$http_header[] = "Authorization: Bearer {$this->secret_token}";
		$http_header[] = "Notion-Version: {$this->version}";
		return $http_header;
	}
}
