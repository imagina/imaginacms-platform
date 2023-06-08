<?php

namespace Modules\Icomments\Services;

use Modules\Icomments\Repositories\CommentRepository;

class CommentService
{

	private $comment;


	public function __construct(
		CommentRepository $comment
	){
		$this->comment = $comment;
	}

	/**
    * Create a Comment
    * @param $model
    * @param $comment
    * @return 
    */
	public function create($model,$data){

		
     	try {

     		$commentData = [
     			"user_id" => $data["user_id"] ?? $model->user_id ?? \Auth::id(),
     			"commentable_type" => $data["commentable_type"] ?? get_class($model),
     			"commentable_id" => $data["commentable_id"] ?? $model->id,
     			"comment" => $data["comment"],
     			"approved" => $data["approved"] ?? !config('comments.approval_required'), // Check if the comment required approval and set the value to approved
     			"internal" => $data["internal"] ?? false
     		];

     		//Validation Gallery
     		if(isset($data["medias_multi"]))
     			$commentData["medias_multi"] = $data["medias_multi"];

     		$comment = $this->comment->create($commentData);

			return $comment;

     	} catch (\Exception $e) {
     		//dd("ERRORR",$e);
     		\Log::error('Icomments: Services|CommentService|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());

      	}

	}


}