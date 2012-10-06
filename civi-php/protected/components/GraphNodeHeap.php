<?php

/**
 * Heap of GraphNodes, ordered by fan-in ascending.
 */
class GraphNodeHeap extends SplHeap
{
	public function compare($a, $b)
	{
		if($a === $b)
			return 0;
		else
			return $a < $b ? 1 : -1;
	}
}
