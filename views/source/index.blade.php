<div>View - article index</div>

<div>test</div>
<table>
    <tbody>
    {{- foreach ($articles as $article) { }}
    <tr>
        <td> {{ $article->id }}</td>
        <td> {{ $article->title }}</td>
        <td> {{ $article->excerpt }}</td>
    </tr>
    {{- } }}
    </tbody>
</table>
