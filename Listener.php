<?php
class RichUsernameEverywhere_Listener
{
    public static function loadClassModel($class, array &$extend)
    {
        if($class == 'XenForo_Model_Thread')
        {
        	$extend[] = 'RichUsernameEverywhere_Thread';
        }
        else if($class == 'XenForo_Model_Node')
        {
            $extend[] = 'RichUsernameEverywhere_Node';
        }
    }

}
?>