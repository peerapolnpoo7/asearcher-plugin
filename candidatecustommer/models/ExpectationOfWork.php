<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * ExpectationOfWork Model
 */
class ExpectationOfWork extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'expectation_of_work';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idExpectation_of_Work';
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
