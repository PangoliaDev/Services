<?php

namespace Pangolia\ServicesTests\Unit;


use Pangolia\ServicesTests\Mocks\TestCloudflareMock;
use Pangolia\ServicesTests\Mocks\TestNotionMock;
use Pangolia\ServicesTests\Mocks\TestSlackMock;

/**
 * Start tests with command "vendor/bin/phpunit" or use "run" by PHPStorm
 */
class ServicesTest extends ServicesTestCase {

	public function testSlackSendMessage() {
		$slack = new TestSlackMock();
		$response = $slack->sendMessage(); // Should send a message to the Slack channel
		$this->assertSame( 'ok', $response ); // Success response should return "ok"
	}

	public function testCloudflarePurgeCache() {
		$cloudflare = new TestCloudflareMock();
		$response = $cloudflare->purgeCache();
		$response = json_decode( $response, true );
		$this->assertTrue( $response['success'] ); // Success response should return true
		$this->assertEmpty( $response['errors'] ); // Success response should return zero errors
		$this->assertCount(
			count( $GLOBALS['credentials']['tests']['cloudflare_files'] ),
			$response['result']
		); // Success response should have same results
	}

	public function testNotionCreatePage() {
		$notion = new TestNotionMock();
		$response = $notion->createPage(); // Should create a page in the designated database
		$response = json_decode( $response, true );
		if ( $response['object'] === 'error' ) {
			fwrite( STDERR, print_r( $response, true ) );
		}
		$this->assertSame( 'page', $response['object'] ); // Success response should return page
		$this->assertNotSame( 'error', $response['object'] ); // Success response should not return error
		$this->assertSame(
			$notion->getProperties()['Plugin version']['title'][0]['text']['content'],
			$response['properties']['Plugin version']['title'][0]['text']['content']
		); // Success response should return same page title
	}
}