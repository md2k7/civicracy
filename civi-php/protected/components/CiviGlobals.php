<?php 

/**
 * Global variables that do not change between different deployments.
 */
class CiviGlobals {
	public static $buttonClass = array('class' => 'btn btn-primary btn-civi'); // CSS class for buttons
	public static $buttonClassWarning = array('class' => 'btn btn-primary btn-civi btn-warning'); // CSS class for buttons with warning
	public static $infoboxClass = array('class' => 'alert alert-error'); // CSS class for form error infoboxes

	// for now, store config parameters for voting here...
	public static function getSustainTimeParameters() {
		return array(
			'R_max' => (100), // (empirical) maximum representation, from experience
			'T_max' => ((14) * (60 * 60 * 24)), // representation should be stable for this interval (in seconds)
		);
	}
}
