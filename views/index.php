<div>View - article index</div>

<?php
    echo '<div>test</div>';
    echo '<table><tbody>';
    foreach ($params['articles'] as $article){
        echo '<tr>';
        echo '<td>' . ($article->id) . '</td>';
        echo '<td>' . ($article->title) . '</td>';
        echo '<td>' . ($article->excerpt) . '</td>';
        echo '<tr>';
    }
    echo '</tbody></table>';