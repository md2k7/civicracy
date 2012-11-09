<?php

/**
 * Graph class for calculations of voter weights.
 */
class VoteGraph
{
	private $nodes = array();
	private $weightsValid = false;

	/**
	 * Create a new VoteGraph instance from voting data of a specific Category
	 *
	 * @param array $users array of User IDs
	 * @param array $votes array of Vote models of the relevant Category only
	 */
	public function __construct($users, $votes)
	{
		foreach($users as $u)
			$this->putNode(new GraphNode($u));

		foreach($votes as $v) {
			$dst = $v->candidate_id;
			$src = $v->voter_id;

			if($src == $dst)
				$dst = NULL;
			else if(!array_key_exists($dst, $this->nodes))
				$this->putNode(new GraphNode($dst));

			$this->putNode(new GraphNode($src, $dst));
		}
	}

	/**
	 * Calculate weights of all voters
	 * @return array associative array (indexed by User id) of weights
	 */
	public function getWeights()
	{
		$weights = array();
		if(!$this->weightsValid)
			$this->calculateWeights();

		foreach($this->nodes as $n)
			$weights[$n->id] = $n->weight;

		return $weights;
	}

	/**
	 * Find all nodes composing a cycle and set their cycleSize
	 */
	private function findCycles()
	{
		// mark all nodes as unseen and not part of a cycle
		foreach($this->nodes as $n) {
			$n->seen = false;
			$n->inCycle = false;
			$n->cycleSize = NULL;
		}

		$node = $this->getUnseen();
		while($node !== NULL) {
			$this->recursiveFindCycles($node, array($node));
			$node = $this->getUnseen();
		}
	}

	/**
	 * Calculate weights (the actual rating of a User), starting at leaves and working up to the root
	 */
	private function calculateWeights()
	{
		$this->findCycles(); // make sure cycle data is correct
		$this->calculateFanIn(); // make sure fan-in data is correct
		$fnodes = new GraphNodeHeap(); // heap by fan-in ascending (leaves are first)

		foreach($this->nodes as $n) {
			$n->seen = false;
			$n->weight = $n->inCycle ? $n->cycleSize : 1;
			if(!$n->inCycle)
				$fnodes->insert($n);
		}

		while($fnodes->valid()) {
			$node = $fnodes->extract(); // fetch a leaf from the heap

			// make sure we are a leaf
			assert($node->fanIn == 0);

			if($node->vote === NULL)
				continue;

			$vote = $this->nodes[$node->vote];
			if($vote->inCycle)
				$this->cycleAddWeight($vote, $node->weight);
			else
				$vote->weight += $node->weight;
			$vote->fanIn--;
			$fnodes->recoverFromCorruption();
		}

		$this->weightsValid = true;
	}

	/**
	 * Calculate the number of people (not weights) voting for each node.
	 */
	private function calculateFanIn()
	{
		foreach($this->nodes as $n)
			$n->fanIn = 0;

		foreach($this->nodes as $n)
			if($n->vote !== NULL)
				$this->nodes[$n->vote]->fanIn++;
	}

	/**
	 * Add weight to a cycle identified by a participating node.
	 *
	 * @param GraphNode $cycleNode any node from the cycle
	 * @param integer $weight weight to be added to all cycle participants
	 */
	private function cycleAddWeight($cycleNode, $weight)
	{
		assert($cycleNode->inCycle);
		$node = $this->nodes[$cycleNode->vote];
		$cycleNode->weight += $weight;
		while($node != $cycleNode) {
			$node->weight += $weight;
			$node = $this->nodes[$node->vote];
		}
	}

	/**
	 * Find cycles in a depth-first search from $node and mark cycle if found.
	 *
	 * @param GraphNode $node starting node
	 * @param array $component all nodes of the current component
	 */
	private function recursiveFindCycles($node, $component)
	{
		$node->seen = true;
		if($node->vote === NULL)
			return;
		$n = $this->nodes[$node->vote];
		if(in_array($n, $component)) {
			$this->markCycle(array_slice($component, array_search($n, $component)));
		} else {
			$component[] = $n;
			$this->recursiveFindCycles($n, $component);
		}
	}

	private function markCycle($cycle)
	{
		foreach($cycle as $n) {
			$n->inCycle = true;
			$n->cycleSize = count($cycle);
		}
	}

	private function getUnseen()
	{
		foreach($this->nodes as $n)
			if(!$n->seen)
				return $n;
		return NULL;
	}

	private function putNode($node)
	{
		$this->nodes[$node->id] = $node;
	}
}
