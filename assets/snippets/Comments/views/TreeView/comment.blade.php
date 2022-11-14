@php

    $replies = isset($data['#childNodes']) ? count($data['#childNodes']) : 0;

    switch($data['createdby']){
        case -1:
            $author['name'] = $DocLister->translate('admin');
            break;
        case 0:
            $author['name'] = $DocLister->translate('guest') . ' ' . $data['name'];
            $author['email'] = $data['email'];
        break;
        default:
            $author['name'] = !empty($data['user.fullname.createdby']) ? $data['user.fullname.createdby'] : ($data['user.username.createdby'] ?? $DocLister->translate('deleted_user'));
            $author['email'] = $data['user.email.createdby'] ?? '-';
        break;
    }

    switch($data['updatedby']){
        case -1:
            $editor['name'] = $DocLister->translate('admin');
            break;
        default:
            $editor['name'] = $data['user.fullname.updatedby'] ?? $DocLister->translate('deleted_user');
            $editor['email'] = $data['user.email.updatedby'] ?? '-';
        break;
    }

@endphp

<div class="comment {{ implode(' ', ($data['classes'] ?? [])) }}" data-id="{{ $data['id'] }}" data-level="{{ $data['level'] }}" id="comment-{{ $data['id'] }}" @if(!empty($data['edit-ttl'])) data-edit-ttl="{{ $data['edit-ttl'] }}" @endif >
    <div class="comment-wrap">
        @if($data['deleted'] and !$DocLister->isModerator())
        <div class="comment-body">
            {{ $DocLister->translate('deleted_comment') }}
        </div>
        @elseif($data['published'] == 0 and !$DocLister->isModerator())
        <div class="comment-body">
            {{ $DocLister->translate('unpublished_comment') }}
        </div>
    @else
        <div class="comment-head">
            <div class="userdata">
                <span class="username">{{ $author['name'] }} @if($DocLister->isModerator()) ({{ $author['email'] ?: '-' }}) @endif </span>
                <span class="createdon">{{ Carbon\Carbon::parse($data['createdon'])->format($DocLister->translate('dateFormat')) }}</span>
            </div>
            <div class="comment-links">
                <span class="comment-link">
                    <a href="{{ evo()->makeUrl($data['thread']) .  '#comment-'  . $data['id'] }}">#</a>
                    @if($data['idNearestAncestor'] && $data['level'])
                    <a href="{{ evo()->makeUrl($data['thread']) .  '#comment-'  . $data['idNearestAncestor'] }}">↑</a>
                    @endif
                </span>
            </div>
            @if($data['rateable'])
            <div class="rating">
                <a href="#" class="dislike">&minus;</a>
                <span class="rating-count">{{ $data['rating']['count'] ?? 0 }}</span>
                <a href="#" class="like">+</a>
            </div>
            @endif
        </div>
        <div class="comment-body">

            {!! $data['content'] !!}

            @if($data['updatedon'])
                <div class="small">{{ $DocLister->translate('edited_by') }} {{ $editor['name'] }} {{ Carbon\Carbon::parse($data['updatedon'])->format($DocLister->translate('dateFormat')) }}</div>
            @endif
        </div>

        @if($DocLister->isModerator())
        <div class="comment-moderation">
            @if($DocLister->hasPermission('comments_publish'))<a href="#" class="comment-publish btn btn-xs btn-primary" data-id="{{ $data['id'] }}">{{ $DocLister->translate('publish') }}</a>@endif
            @if($DocLister->hasPermission('comments_unpublish'))<a href="#" class="comment-unpublish btn btn-xs btn-default" data-id="{{ $data['id'] }}">{{ $DocLister->translate('unpublish') }}</a>@endif
            @if($DocLister->hasPermission('comments_delete'))<a href="#" class="comment-delete btn btn-xs btn-warning" data-id="{{ $data['id'] }}">{{ $DocLister->translate('delete') }}</a>@endif
            @if($DocLister->hasPermission('comments_undelete'))<a href="#" class="comment-undelete btn btn-xs btn-info" data-id="{{ $data['id'] }}">{{ $DocLister->translate('undelete') }}</a>@endif
            @if($DocLister->hasPermission('comments_remove'))<a href="#" class="comment-remove btn btn-xs btn-danger" data-id="{{ $data['id'] }}">{{ $DocLister->translate('remove') }}</a>@endif
            @if($DocLister->hasPermission('comments_edit'))<a href="#" class="comment-edit btn btn-xs btn-success" data-id="{{ $data['id'] }}">{{ $DocLister->translate('edit') }}</a>@endif
        </div>
        @endif

            @if($DocLister->isNotGuest())
                <div class="comment-footer">
                    <a href="#" class="comment-reply btn btn-primary" data-id="{{ $data['id'] }}">{{ $DocLister->translate('reply') }}</a>
                @if(!empty($data['editable']))
                    <a href="#" class="comment-update btn btn-success" data-id="{{ $data['id'] }}">{{ $DocLister->translate('change') }}</a>
                @endif
                </div>
            @endif
    @endif
    </div>
    {!! $data['dl.wrap'] ?? '' !!}
</div>

