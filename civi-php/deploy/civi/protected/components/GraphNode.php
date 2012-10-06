<?php

/**
 * Node representation for VoteGraph. Each User becomes a Node.
 */
class GraphNode
{
	public $id;
	public $vote;
	public $seen = false;
	public $inCycle = false;
	public $cycleSize = NULL;
	public $weight = 1;
	public $fanIn = 0; // fan-in: number of people voting for us (not weight!)

	/**
	 * Create a GraphNode with a User ID and an optional vote for another User ID.
	 * @param integer $id User ID of voter
	 * @param integer $vote optional User ID voted for
	 */
	public function __construct($id, $vote=NULL)
	{
		$this->id = $id;
		$this->vote = $vote;
	}
}
