<h1><a class="link-offset-2 link-underline link-underline-opacity-0" href="/community/">Community</a>{{$channel ? " - $channel->title" : ''}}</h1>
@foreach ($links as $link)
<li>
    <a href="{{ $link->link }}" target="_blank">
        {{ $link->title }}
    </a>
    <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}. Votos: {{$link->users()->count()}}</small>
    <span class="label label-default" style="background: {{ $link->channel->color }}">
        <a class="text-decoration-none text-white" href="/community/{{ $link->channel->slug }}">
            {{ $link->channel->title }}
        </a>
    </span>
</li>
@endforeach