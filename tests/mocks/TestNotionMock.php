<?php

namespace Pangolia\ServicesTests\Mocks;

use Pangolia\Services\Notion;

class TestNotionMock {
	protected Notion $notion;

	public function __construct() {
		$this->notion = new Notion( $GLOBALS['credentials']['notion'] );
	}

	public function createPage() {
		return $this->notion->create_page( [
			'parent'     => [ 'database_id' => $GLOBALS['credentials']['tests']['notion_database_id'] ],
			'properties' => $this->getProperties(),
		] );
	}

	public function getProperties(): array {
		return [
			'Date'           => [
				'date' => [
					'start' => date( 'Y-m-d' ) . 'T' . date( 'H:i:s' ) . 'Z',
				],
			],
			'Site'           => [
				'relation' => [
					[
						'id' => $GLOBALS['credentials']['tests']['notion_relation_id'],
					],
				],
			],
			'Type'           => [
				'select' => [
					'name' => 'Plugin',
				],
			],
			'Action'         => [
				'select' => [
					'name' => 'Updated',
				],
			],
			'Plugin version' => [
				'title' => [
					[
						'text' => [
							'content' => 'The page name',
						],
					],
				],
			],
			'Description'    => [
				'rich_text' => [
					[
						'text' => [
							'content' => 'Updated the plugin ***./n Updated version: 2.0.0',
						],
					],
				],
			],
		];
	}
}