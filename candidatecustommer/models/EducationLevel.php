<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * EducationLevel Model
 */
class EducationLevel extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'education_level';

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
