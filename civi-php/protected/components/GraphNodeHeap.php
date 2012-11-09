<?php

/**
 * Heap of GraphNodes, ordered by fan-in ascending.
 */
class GraphNodeHeap extends SplHeap
{
	public function compare($a, $b)
	{
		if($a->fanIn === $b->fanIn)
			return 0;
		else
			return $a->fanIn < $b->fanIn ? 1 : -1;
	}
}
