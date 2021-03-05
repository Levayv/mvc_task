<div>View - home</div>

<?php
    echo '<div>test</div>';
    echo '<ul>';
    foreach ($params['articles'] as $article){
        echo '<li>' . $article . '</li>';
    }
    echo '</ul>';