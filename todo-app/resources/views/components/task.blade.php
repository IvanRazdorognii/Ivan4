@props(['task'])
@vite('resources/css/app.css')

<div class="task">
    <h2>{{ $task['title'] }}</h2>
    <p>{{ $task['description'] }}</p>
</div>