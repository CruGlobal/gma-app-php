<?php namespace GlobalTechnology\GlobalMeasurements {

	class ProxyTicketServiceStorage extends \CAS_PGTStorage_AbstractStorage {

		function getStorageType() {
			return 'proxy-ticket-service';
		}

		function getStorageInfo() {
			return 'proxy-ticket-service';
		}

		function read( $pgt_iou ) {
			$response = \Httpful\Request::post(
				ProxyTicketServiceURL,
				array(
					'Username' => ProxyTicketServiceUsername,
					'Password' => ProxyTicketServicePassword,
					'PGTIOU'   => $pgt_iou,
				), \Httpful\Mime::FORM )
				->addHeader( 'Content-Type', 'application/x-www-form-urlencoded' )
				->send();
			$dom      = new \DOMDocument();
			$dom->loadXML( $response->raw_body );
			return $dom->documentElement->textContent;
		}
	}
}
