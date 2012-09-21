<?php

class RichUsernameEverywhere_Thread extends XFCP_RichUsernameEverywhere_Thread
{
	/**
	 * Checks the 'join' key of the incoming array for the presence of the FETCH_x bitfields in this class
	 * and returns SQL snippets to join the specified tables if required
	 *
	 * @param array $fetchOptions containing a 'join' integer key build from this class's FETCH_x bitfields
	 *
	 * @return array Containing selectFields, joinTables, orderClause keys.
	 * 		Example: selectFields = ', user.*, foo.title'; joinTables = ' INNER JOIN foo ON (foo.id = other.id) '; orderClause = ORDER BY x.y
	 */
	public function prepareThreadFetchOptions(array $fetchOptions)
	{
		$thread = parent::prepareThreadFetchOptions($fetchOptions);

		$thread['selectFields'] .= ',
			user_rue.display_style_group_id AS last_post_display_style_group_id';
		$thread['joinTables'] .= '
			LEFT JOIN xf_user AS user_rue ON
				(user_rue.user_id = thread.last_post_user_id)';

		return array(
			'selectFields' => $thread['selectFields'],
			'joinTables'   => $thread['joinTables'],
			'orderClause'  => $thread['orderClause']
		);
	}

	/**
	 * Prepares a thread for display, generally within the context of a specific forum.
	 *
	 * @param array $thread Thread to prepare
	 * @param array $forum Forum thread is in
	 * @param array|null $nodePermissions
	 * @param array|null $viewingUser
	 *
	 * @return array Prepared version of thread
	 */
	public function prepareThread(array $thread, array $forum, array $nodePermissions = null, array $viewingUser = null)
	{
		$thread = parent::prepareThread($thread, $forum, $nodePermissions, $viewingUser);

		if(isset($thread['last_post_display_style_group_id']))
		{
			$thread['lastPostInfo']['display_style_group_id'] = $thread['last_post_display_style_group_id'];
		}
		
		return $thread;
	}
}