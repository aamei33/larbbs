<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
    protected $casts =[
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function category(){
        //一个帖子数据一个分类
        return  $this->belongsTo(Category::class);
    }

    public function user(){
        //一个帖子属于一个用户
        return $this->belongsTo(User::class);
    }

}
