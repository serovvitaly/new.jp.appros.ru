<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;

use Illuminate\Http\Request;

class CommentController extends RestController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
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

        $validator = \Validator::make($request->all(), [
            'target_id' => 'required|integer',
            'target_type' => 'required|min:4',
            'answer_to_id' => 'integer',
            'content' => 'required|max:' . \App\Models\CommentModel::MAXIMUM_CHARACTERS
        ]);

        if ($validator->fails()) {
            return \App\Helpers\RestHelper::exceptionInvalidData($validator->errors()->all());
        }

        $comment = \App\Models\CommentModel::create([
            'target_id' => $request->get('target_id'),
            'target_type' => $request->get('target_type'),
            'content' => $request->get('content'),
            'user_id' => $this->user->id,
            'user_ip' => $request->getClientIp(),
            'answer_to_id' => $request->get('answer_to_id')
        ]);

        $comment_array = $comment->toArray();

        $comment_array['created_at_ago'] = \App\Helpers\DateHelper::getDateAgoStr($comment_array['created_at']);

        return $comment_array;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
