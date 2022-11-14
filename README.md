# comments-blade
Comments for evo3.x + blade addon

# Получение дерева комментариев
```
    ...
    $this->data['commentsTree'] = $this->getCommentsTree();
    ...

    protected function getCommentsTree()
    {
        $params = [
            'controller' => 'TreeViewCustom',
            'config'     => 'comments:assets/snippets/Comments/config/',
        ];
        $html = evo()->runSnippet("Comments", $params);
        return $html;
    }
```

# вывод в blade дерева комментариев
```
<div id="comments">
    @if(!empty($commentsTree))
        {!! $commentsTree !!}
    @endif
</div>
```

#получение формы ввода комментария
```
    ...
    $this->data['CommentsForm'] = $this->getCommentsForm();
    ...

    protected function getCommentsForm()
    {
        $params = [
            'config'=>'form:assets/snippets/Comments/config/',
        ];
        $html = evo()->runSnippet("CommentsForm", $params);
        return $html;
    }
```

# вывод в blade формы
```
<div id="comments-form">
    <div class="comments-form-wrap">

        {!! $CommentsForm ?? '' !!}

    </div>
</div>
```


#js на нужной странице
в файле comments_custom.js добавлено новое значение formPosition для возможности вставки в дерево в дополнение к существующим append и prepend
см. строки 173-179
```

    <script src="assets/snippets/Comments/js/comments_custom.js"></script>
    <script>
        function onInitFormCallback() {
            //событие для 
            console.log('onInitFormCallback');
        }
        new Comments({
            formPosition: 'comments-form',
            thread: {{ $documentObject['id'] }},
            lastComment: {{ evo()->getPlaceholder('lastComment') ?? 0 }},
            onInitFormCallback: onInitFormCallback
        });
    </script>
```