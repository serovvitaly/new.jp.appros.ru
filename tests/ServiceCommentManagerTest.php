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

        $user = \App\User::find(8);
    }

    /**
     * @depends testRestMakeComment
     */
    public function testRestGetComment()
    {
        //
    }

    /**
     * @depends testRestGetComment
     */
    public function testRestRemoveComment()
    {
        //
    }
}