<?php namespace Asearcher\CandidateCustommer\Models;

use Model;

/**
 * RequirementEmployment Model
 */
class RequirementEmployment extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'requirement_employment';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idRequirement_Employment';
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
