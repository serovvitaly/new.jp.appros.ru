<?php

/**
 * Created by PhpStorm.
 * User: albano
 * Date: 10.07.2015
 * Time: 15:55
 */
class ServiceCommentManagerTest extends TestCase
{
    public function testRestMakeComment()
    {
        \Session::start();

        $user = \App\User::find( \Config::get('tests.user_id') );

        $product_id = '101';
        $purchase_id = '202';
        $answer_to_id = '303';
        $target_type = 'product_in_purchase';
        $content = 'Тектс тестового комментария';

        $response = $this->actingAs($user)
            ->post('/rest/comment', [
                '_token' => \Session::token(),
                'target_id' => $product_id,
                'additional_target_id' => $purchase_id,
                'answer_to_id' => $answer_to_id,
                'target_type' => $target_type,
                'content' => $content,
            ],[
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->seeJson([
                'target_id' => $product_id,
                'additional_target_id' => $purchase_id,
                'answer_to_id' => $answer_to_id,
                'target_type' => $target_type,
                'content' => $content,
                'user_id' => $user->id
            ])
            ->response;

        $this->assertResponseOk();

        $comment_mix = json_decode($response->content());

        $comment_id = $comment_mix->id;

        $comment = \App\Services\CommentManager\Models\Comment::find($comment_id);

        $this->assertNotNull($comment);

        $this->assertEquals($product_id, $comment->target_id);
        $this->assertEquals($purchase_id, $comment->additional_target_id);
        $this->assertEquals($answer_to_id, $comment->answer_to_id);
        $this->assertEquals($target_type, $comment->target_type);
        $this->assertEquals($content, $comment->content);

        $this->assertEquals($user->id, $comment->user_id);

        return $comment_mix->id;
    }

    /**
     * @depends testRestMakeComment
     * @param $comment_id
     * @return int
     */
    public function testRestGetComment($comment_id)
    {
        return $comment_id;
    }

    /**
     * @depends testRestGetComment
     * @param $comment_id
     */
    public function testRestRemoveComment($comment_id)
    {
        $comment = \App\Services\CommentManager\Models\Comment::find($comment_id);

        $this->assertNotNull($comment);

        $comment->delete();
    }
}