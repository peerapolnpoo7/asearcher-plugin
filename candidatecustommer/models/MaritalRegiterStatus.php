<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * Marital_regiter_status Model
 */
class MaritalRegiterStatus extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'marital_register_status';

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
