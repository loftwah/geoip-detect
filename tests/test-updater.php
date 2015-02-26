<?php

class UpdateTest extends WP_UnitTestCase_GeoIP_Detect {

	function setUp() {
		parent::setUp();
		
		
		// unlink uploads file if exists
		if (function_exists('geoip_detect_get_database_upload_filename')) {
			$filename = geoip_detect_get_database_upload_filename();
			if (file_exists($filename))
				@unlink($filename);
		}
	}
	
	/**
	 * @group external-http
	 */
	function testUpdate() {
		$this->markTestSkipped('This test should not be executed by Travis.');
		if (!function_exists('geoip_detect_update'))
			$this->markTestSkipped('updater.php is not included, so not update test possible.');
		
		$this->assertTrue( geoip_detect_update() );

		$record = geoip_detect2_get_info_from_ip(GEOIP_DETECT_TEST_IP);
		$this->assertValidGeoIP2Record($record, GEOIP_DETECT_TEST_IP);
	}

	function testUpdaterFileFilter() {
		if (!function_exists('geoip_detect_update'))
			$this->markTestSkipped('updater.php is not included, so not update test possible.');
		
		$this->assertEquals('', geoip_detect_get_database_upload_filename_filter(''));
		$this->assertContains('/upload', geoip_detect_get_database_upload_filename());
	}
}