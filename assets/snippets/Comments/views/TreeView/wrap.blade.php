<div id="comments">
    @if($data['count'] == 0)
        <div class="comments-count-wrap uk-text-lead uk-margin-medium-bottom hidden">Комментариев: <span class="comments-count">0</span></div>
        <div class="no-comments">Ваш комментарий будет первым.</div>
    @else
        <div class="comments-count-wrap uk-text-lead uk-margin-medium-bottom">Комментариев: <span class="comments-count">{{ $data['count'] }}</span></div>
        {!! $data['wrap'] !!}
    @endif
</div>
