<div class="comments-header">
    <h3>Комментарии и обсуждение</h3>
    @if(\Auth::guest())
        <p>Вы должны <a href="/auth/login">авторизоваться</a>, что бы оставить комментарий</p>
    @elseif(\Auth::user()->can('product-comments-add'))
        <p id="commentFormTextBox">
            <textarea name="description" class="form-control" rows="3" placeholder="введите текст комментария..." style="margin-bottom: 5px"></textarea>
            <button class="btn btn-default btn-sm" disabled onclick="pushComment(); return false;">Отправить</button>
        </p>
        <script>
            $('#commentFormTextBox textarea').on('keyup', function(){
                if ($(this).val() == '') {
                    $('#commentFormTextBox button').attr('disabled', 'disabled');
                } else {
                    $('#commentFormTextBox button').attr('disabled', null);
                }
            });
            function pushComment(){
                var commentFormTextElement = $('#commentFormTextBox textarea');
                $('#commentFormTextBox button').attr('disabled', 'disabled');
                $.ajax({
                    url: '/rest/comment',
                    type: 'post',
                    data: {
                        _token: __TOKEN__,
                        target_id: '{{ $target_id }}',
                        target_type: '{{ $target_type }}',
                        answer_to_id: 0,
                        content: commentFormTextElement.val()
                    },
                    success: function(data){
                        commentFormTextElement.val('');

                        $(".comments-wrapper").loadTemplate($("#commentTemplate"), {
                            content: data.content,
                            created_at: data.created_at_ago
                        }, {
                            prepend: true
                        });

                    }
                });
            }
        </script>
        <script type="text/html" id="commentTemplate">
            <div class="comment-item">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img width="50" height="50" src="http://cs421320.vk.me/v421320600/dd16/L0_MNmRYFCo.jpg">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ \Auth::user()->name }}</h4>
                        <div data-content="content"></div>
                        <div class="media-footer">
                            <span class="comment-published">только что</span>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    @else
        <p style="color: red">У вас нет прав для добавления комментариев, обратитесь к администратору</p>
    @endif

    <span class="stars-small">
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
    </span>

</div>

<div class="comments-wrapper">

    @foreach(\App\Helpers\CommentsHelper::getCommentsForTarget($target_id, $target_type) as $comment)

        <div class="comment-item">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img width="50" height="50" src="http://cs421320.vk.me/v421320600/dd16/L0_MNmRYFCo.jpg">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $comment->user->name }}</h4>
                    <div>{{ $comment->content }}</div>
                    <div class="media-footer">
                        <span class="comment-published">{{ \App\Helpers\DateHelper::getDateAgoStr($comment->created_at) }}</span>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

</div>

<div class="comments-footer">
    <a href="#" class="button button-block button-rounded button-flat" onclick="return false;">показать еще</a>
</div>