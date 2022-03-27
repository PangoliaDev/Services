<?php
declare( strict_types = 1 );

namespace Pangolia\Services;

abstract class AbstractService {

	/**
	 * @var string
	 */
	protected string $url;

	/**
	 * Create valid post fields for the Curl request
	 *
	 * @param array<int|string, mixed> $fields
	 * @return false|string
	 */
	protected function create_post_fields( array $fields ) {
		return \json_encode( $fields ); // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
	}

	/**
	 * @param string $query
	 * @return string
	 */
	protected function create_request_url( string $query ): string {
		return $this->url . $query;
	}

	/**
	 * Log error
	 *
	 * @param string $message
	 * @return void
	 */
	protected function log_error( string $message ) {
		error_log( get_called_class() . ": {$message}" );
	}
}
