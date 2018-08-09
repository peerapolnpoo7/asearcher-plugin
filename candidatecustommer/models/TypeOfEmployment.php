<?php namespace Asearcher\CandidateCustommer\Models;

use Model;

/**
 * TypeOfEmployment Model
 */
class TypeOfEmployment extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'type_of_employment';

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
