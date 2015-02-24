<?php namespace GlobalTechnology\GlobalMeasurements {
	$wrapper = ApplicationWrapper::singleton();
	$ticket  = $wrapper->getAPIServiceTicket();
	if ( false === $ticket ) {
		header( 'Content-Type: text/html; charset=UTF-8', true, 400 );
		echo '<html><head><title>Refresh Ticket Error</title></head><body></body></html>';
	}
	else {
		header( 'Content-type: application/json; charset=utf-8', true, 200 );
		echo json_encode( array(
			'service_ticket' => $ticket
		) );
	}
	exit();
}
