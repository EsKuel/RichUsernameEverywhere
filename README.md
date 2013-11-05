# RichUsernameEverywhere

## Description

This addon add the possibility to user rich username in the last post section on forum index and thread list.

## Installation

* Upload contents of upload folder to Xenforo root directory
* Install addon-RichUsernameEverywhere.xml
* Edit your templates

## Templates modifications

Template *node_category_level_2* (forum index)

1. Search `<xen:username user="$category.lastPost" />`
2. Replace by `<xen:username user="$category.lastPost" rich="true" />`

Template *node_forum_level2* (forum index)

1. Search `<xen:username user="$forum.lastPost" />`
2. Replace by `<xen:username user="$forum.lastPost" rich="true" />`

Template *thread_list_item* (thread list)

1. Search `<xen:username user="$thread.lastPostInfo" />`
2. Replace by `<xen:username user="$thread.lastPostInfo" rich="true" />`

If you also want to add rich username to thread author (under topic name), edit the same template *thread_list_item* (that's a XenForo feature)

1. Search `<xen:username user="$thread" title="{xen:phrase thread_starter}" />`
2. Replace by `<xen:username user="$thread" title="{xen:phrase thread_starter}" rich="true" />`

## Thanks

Thanks to Jake Bunce, Waindigo, bubbl3 and Luke Foreman for their help.
