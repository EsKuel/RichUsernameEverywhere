<?php

class RichUsernameEverywhere_Node extends XFCP_RichUsernameEverywhere_Node
{
	/**
	 * Gets all the node data required for a node list display
	 * (eg, a forum list) from a given point. Returns 3 pieces of data:
	 * 	* nodesGrouped - nodes, grouped by parent, with all data integrated
	 *  * nodeHandlers - list of node handlers by node type
	 *  * nodePermissions - the node permissions passed on
	 *
	 * @param array|false $parentNode Root node of the tree to display from; false for the entire tree
	 * @param integer $displayDepth Number of levels of nodes to display below the root, 0 for all
	 * @param array|null $nodePermissions List of node permissions, [node id] => permissions; if null, get's current visitor's permissions
	 *
	 * @return array Empty, or with keys: nodesGrouped, parentNodeId, nodeHandlers, nodePermissions
	 */
	public function getNodeDataForListDisplay($parentNode, $displayDepth, array $nodePermissions = null)
	{
		$nodeData = parent::getNodeDataForListDisplay($parentNode, $displayDepth, $nodePermissions);

		if (!empty($nodeData['nodesGrouped']))
		{			
			$nodeData['nodesGrouped'] = $this->_addDisplayStyleGroupdId($nodeData['nodesGrouped']);
							
			return $nodeData;
		}
		else
		{
			return array();
		}
	}
	
	protected function _addDisplayStyleGroupdId(array $nodes)
	{
		$styles = array();

		foreach($nodes as &$depthNodes)
		{
			foreach ($depthNodes AS &$node)
			{
				if (isset($node['lastPost']['user_id']))
				{
					$styles[$node['lastPost']['user_id']] = array();
				}
			}
		}
		
		if (!empty($styles))
		{
			$styles = $this->_getDisplayStyleGroupdId(array_keys($styles));

			foreach($nodes as &$depthNodes)
			{
				foreach ($depthNodes AS &$node)
				{
					if (($node['node_type_id'] == "Forum" OR $node['node_type_id'] == "Category") and isset($node['lastPost']['user_id'])
						and !empty($styles[$node['lastPost']['user_id']]))
					{
						$node['lastPost']['display_style_group_id'] = $styles[$node['lastPost']['user_id']]['display_style_group_id'];
					}
				}
			}
		}

		return $nodes;
	}
	
	protected function _getDisplayStyleGroupdId($userIds)
	{
		if (!$userIds) {
			return array();
		}

		return $this->fetchAllKeyed('
					SELECT user.user_id, user.display_style_group_id
					FROM xf_user AS user
					WHERE user.user_id IN (' . $this->_getDb()->quote($userIds) . ')
			', 'user_id');
	}
}
