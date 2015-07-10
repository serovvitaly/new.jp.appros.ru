<?php

namespace App\Services\CommentManager;


use App\Services\CommentManager\Models\Comment;
use App\Services\ServiceManager;

/**
 * Предназначен для работы с Комментариями
 *
 * @package App\Services\CommentManager
 */
class CommentManager extends ServiceManager
{
    /**
     * Создание комментария
     * @param $content
     * @param $target_type
     * @param $target_id
     * @param int $additional_target_id
     * @param int $answer_to_id
     * @param null $user_ip
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response|static
     */
    public function make($content, $target_type, $target_id, $additional_target_id = 0, $answer_to_id = 0, $user_ip = null)
    {
        if ( !$this->user ) {
            return \App\Helpers\RestHelper::exceptionAccessDenied();
        }

        /**
         * TODO: проверка прав пользователя на добавление комментариев
         */
        if (0) {
            return \App\Helpers\RestHelper::exceptionAccessDenied();
        }

        $comment = Comment::create([
            'content' => $content,
            'target_type' => $target_type,
            'target_id' => $target_id,
            'additional_target_id' => $additional_target_id,
            'answer_to_id' => $answer_to_id,
            'user_ip' => $user_ip,
            'user_id' => $this->user->id
        ]);

        return $comment;
    }

    /**
     * Создание комментария на основе Запроса
     * @param \Illuminate\Http\Request $request
     * @return CommentManager|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response|static
     */
    public function makeViaRequest(\Illuminate\Http\Request $request = null)
    {
        if (!$request) {
            $request = $this->request;
        }
        // TODO: можек как то по другому проверку сделать?
        if (!$request) {
            return null;
        }

        $validator = \Validator::make($request->all(), [
            'target_id' => 'required|integer',
            'additional_target_id' => 'integer',
            'target_type' => 'required|min:4',
            'answer_to_id' => 'integer',
            'content' => 'required|max:' . Comment::MAXIMUM_CHARACTERS
        ]);

        if ($validator->fails()) {
            return \App\Helpers\RestHelper::exceptionInvalidData($validator->errors()->all());
        }

        $comment = $this->make(
            $request->get('content'),
            $request->get('target_type'),
            $request->get('target_id'),
            $request->get('additional_target_id'),
            $request->get('answer_to_id'),
            $request->getClientIp()

        );

        return $comment;
    }

    /**
     * Возвращает комментарии для определенного объекта
     * @param $target_id - ID объекта
     * @param $target_type - тип объекта, смотреть в константах модели \App\Services\CommentManager\Models\Comment
     * @param int $limit
     * @return mixed
     */
    public function getCommentsForTarget($target_id, $target_type, $limit = 10)
    {
        $comments = Comment::where('target_id', '=', $target_id)
            ->where('target_type', '=', $target_type)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return $comments;
    }

    /**
     * Выводит количество комментариев для определенного объекта
     * @param $target_id
     * @param $target_type
     * @return mixed
     */
    public function getCommentsCountForTarget($target_id, $target_type)
    {
        return Comment::where('target_id', '=', $target_id)
            ->where('target_type', '=', $target_type)
            ->count();
    }
}