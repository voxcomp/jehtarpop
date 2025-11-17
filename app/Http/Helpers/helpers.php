<?php

function getPaymentAgree() {
	return html_entity_decode(getSetting('paymentAgree','editor'));
}

	// ********* SETTINGS
function setSetting($display, $name, $group, $value) {
	$settings = new \App\Http\Repositories\Settings;
	
	return $settings->set($display,$name,$value,$group);
}
function getSetting($name,$group, $default=null) {
	$settings = new \App\Http\Repositories\Settings;
	
	return $settings->get($name,$group,$default);
}
function updateSetting($name,$group,$value) {
	$settings = new \App\Http\Repositories\Settings;
	
	return $settings->update($name,$group,$value);
}
