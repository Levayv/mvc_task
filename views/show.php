<div>View - article show</div>

<?php
echo '<div>test</div>';
echo '<div>';
//echo($params['article']['title']);
echo (($params['article'])->title);
echo '</div>';
echo '<div>';
//echo($params['article']['excerpt']);
echo($params['article']->excerpt);
echo '</div>';


echo($params['article']->tableName);
