<?php

namespace Pangolia\ServicesTests\Mocks;

use Pangolia\Services\Slack;

class TestSlackMock {
	protected Slack $slack;

	public function __construct() {
		$this->slack = new Slack( [
			'webhooks' => $GLOBALS['credentials']['slack'],
			'bot'      => 'SlackMockeryBot',
		] );
	}

	public function sendMessage() {
		return $this->slack->send_message(
			'webhook',
			'This is the message title',
			$this->getMessageBlock(),
			':dog:',
			'Mr. Doggy'
		);
	}

	public function getMessageBlock(): array {
		return [
			[
				'type'     => 'context',
				'elements' => [
					[
						'text' => ':calendar:  *' . date( 'M j Y h:i A' ) . '*',
						'type' => 'mrkdwn',
					],
				],
			],
			[
				'type' => 'divider',
			],
			[
				'type' => 'section',
				'text' => [
					'type' => 'mrkdwn',
					'text' => 'This is the section element',
				],
			],
			[
				'type'     => 'context',
				'elements' => [
					[
						'text' => 'This is a context element',
						'type' => 'mrkdwn',
					],
				],
			],
		];
	}
}