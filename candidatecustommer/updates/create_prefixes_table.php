<?php namespace Asearcher\Candidatecustommer\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePrefixesTable extends Migration
{
    public function up()
    {
        Schema::create('asearcher_candidatecustommer_prefixes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asearcher_candidatecustommer_prefixes');
    }
}
