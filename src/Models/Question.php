<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;
use \Illuminate\Database\Eloquent\Builder;
use PassThisTest\Models\Taxonomy;
use PassThisTest\Models\History;
use PassThisTest\Models\Relationships;

class Question extends Model {

    protected $table = 'posts';
    protected $primaryKey = 'ID';
    protected $guarded = [ 'ID' ];
    protected $appends = ['answers', 'exp_content'];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('post_type', function (Builder $builder) {
            $builder->where('post_type', '=', 'question')
                    ->where('post_status', '=', 'publish');
        });
    }

    public function getAnswersAttribute()
    {
        $out = $this->meta()->get()->filter(function($item){
            if ($item['meta_key'] == 'answers') {
                return true;
            }
        });
        return $out->first()->meta_value;
    }

    public function getExpContentAttribute()
    {
        $out = $this->meta()->get()->filter(function($item) {
            if ($item['meta_key'] == 'ptt_explanation_content') {
                return true;
            }
        });
        return $out->first()->meta_value;
    }

    public function getTable()
    {
        if( isset( $this->table ) ){
            $prefix =  $this->getConnection()->db->prefix;
            return $prefix . $this->table;

        }

        return parent::getTable();
    }

    public function terms()
    {
        return $this->belongsToMany(
            Term::class,
            'wp_term_relationships',
            'object_id',
            'term_taxonomy_id'
        );
    }

    public function meta()
    {
        return $this->hasMany('PassThisTest\Models\QuestionMeta', 'post_id')
            ->select(['post_id', 'meta_key', 'meta_value']);
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'question_id', 'ID');
    }

    public function correctAnswers()
    {
        return $this->hasMany(History::class, 'question_id', 'ID')->whereIncorrect(NULL);
    }

}