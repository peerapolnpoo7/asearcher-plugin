<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * BloodGroup Model
 */
class BloodGroup extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'blood_group';

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
