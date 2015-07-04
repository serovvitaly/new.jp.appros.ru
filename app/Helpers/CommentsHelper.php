<?php namespace App\Helpers;


class CommentsHelper {

    /**
     * Возвращает комментарии для определенного объекта
     * @param $target_id - ID объекта
     * @param $target_type - тип объекта, смотреть в константах модели \App\Models\CommentModel
     * @param int $limit
     * @return mixed
     */
    public static function getCommentsForTarget($target_id, $target_type, $limit = 10)
    {
        $comments = \App\Models\CommentModel::where('target_id', '=', $target_id)
            ->where('target_type', '=', $target_type)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return $comments;
    }

    public static function getCommentsCountForTarget($target_id, $target_type)
    {
        return \App\Models\CommentModel::where('target_id', '=', $target_id)
            ->where('target_type', '=', $target_type)
            ->count();
    }

}