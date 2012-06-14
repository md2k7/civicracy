<?php

/**
 * Graph class for calculations of voter weights.
 */
class VoteGraph
{
	/**
	 * Create a new VoteGraph instance with 
	 * @param array $votes array of Vote models of the relevant Category only
	 */
	public function __construct($votes)
	{
		// ...
	}

	/**
	 * Calculate weights of all voters
	 * @return array associative array (indexed by User id) of weights
	 */
	public function getWeights()
	{
		return array(8 => 1);
	}
}
