<?php namespace Asearcher\CandidateCustommer\Models;

use Model;

/**
 * TransportationDetail Model
 */
class TransportationDetail extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'transportation_detail';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
