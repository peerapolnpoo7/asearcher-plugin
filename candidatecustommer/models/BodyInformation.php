<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * BodyInformation Model
 */
class BodyInformation extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'body_information';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idBody_Information';
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
