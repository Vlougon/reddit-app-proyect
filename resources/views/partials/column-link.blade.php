<h1>Community</h1>
@foreach ($links as $link)
<li>
    <a href="{{ $link->link }}" target="_blank">
        {{ $link->title }}
    </a>
    <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>
    <span class="label label-default" style="background: {{ $link->channel->color }}">
        {{ $link->channel->title }}
    </span>
</li>
@endforeach