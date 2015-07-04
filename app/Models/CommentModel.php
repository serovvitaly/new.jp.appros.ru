<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model {

    const TARGET_TYPE_SELLER   = 'seller';

    const TARGET_TYPE_PRODUCT  = 'product';

    const TARGET_TYPE_PRODUCT_IN_PURCHASE  = 'product_in_purchase';

    const TARGET_TYPE_PURCHASE = 'purchase';

    const MAXIMUM_CHARACTERS = 500;

    protected $table = 'comments';

    protected $fillable = ['target_id', 'target_type', 'content', 'user_id', 'user_ip', 'answer_to_id'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}