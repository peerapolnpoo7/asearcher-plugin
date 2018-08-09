<?php namespace Asearcher\Candidatecustommer\Models;

use Model;

/**
 * SkillLanguage Model
 */
class SkillLanguage extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'skill_language';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    protected $primaryKey = 'idSkill_Language';
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
