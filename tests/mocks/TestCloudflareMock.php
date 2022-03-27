<?php

namespace Pangolia\ServicesTests\Mocks;

use Pangolia\Services\Cloudflare;

class TestCloudflareMock {
	protected Cloudflare $cloudflare;

	public function __construct() {
		$this->cloudflare = new Cloudflare( $GLOBALS['credentials']['cloudflare'] );
	}

	public function purgeCache() {
		return $this->cloudflare->purge_cache( [
			'files' => $GLOBALS['credentials']['tests']['cloudflare_files'],
		] );
	}
}