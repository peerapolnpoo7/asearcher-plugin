<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * Presentation Model
 */
class Presentation extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'presentation';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idPresentation';
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
