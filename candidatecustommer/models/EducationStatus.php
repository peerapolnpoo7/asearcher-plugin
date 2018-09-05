<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * Education_Status Model
 */
class EducationStatus extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'education_status';

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
