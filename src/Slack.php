<?php
declare( strict_types = 1 );

namespace Pangolia\Services;

class Slack extends AbstractService {

	/**
	 * @var array<string, string>
	 */
	private array $webhooks;

	/**
	 * @var string
	 */
	private string $bot;

	/**
	 * @var string|bool
	 */
	public $response;

	/**
	 * @param array<string, mixed> $config
	 */
	public function __construct( array $config ) {
		$this->webhooks = $config['webhooks'] ?? '';
		$this->bot = $config['bot'] ?? '';
	}

	/**
	 * Send message
	 *
	 * @param string               $webhook
	 * @param string               $message
	 * @param array<string, mixed> $blocks
	 * @param string               $icon
	 * @param string               $custom_username
	 * @return bool|string
	 */
	public function send_message(
		string $webhook,
		string $message,
		array $blocks = [],
		string $icon = ':alien:',
		string $custom_username = ''
	) {
		$this->make_request( $webhook, [
			'username'   => $this->set_name( $custom_username ),
			'text'       => $message,
			'icon_emoji' => $icon,
			'blocks'     => $blocks,
		] );
		return $this->response;
	}

	/**
	 * Sets the username of the message
	 *
	 * @param string $custom_username
	 * @return string
	 */
	private function set_name( string $custom_username ): string {
		return $custom_username ?? "{$this->bot} Bot";
	}

	/**
	 * Post curl
	 *
	 * @param string               $webhook
	 * @param array<string, mixed> $data
	 * @return void
	 */
	private function make_request( string $webhook, array $data ) {
		$ch = \curl_init( $this->webhooks[ $webhook ] );

		if ( is_resource( $ch ) ) {
			\curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			\curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			\curl_setopt( $ch, CURLOPT_POST, true );
			\curl_setopt( $ch, CURLOPT_POSTFIELDS, [ 'payload' => json_encode( $data ) ] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
			$this->response = \curl_exec( $ch );
			\curl_close( $ch );
		} else {
			$this->log_error( '$ch expects resource, resource|false given.' );
		}
	}
}
