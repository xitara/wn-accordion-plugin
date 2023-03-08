<?php

namespace Xitara\Accordion\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateTextListsTable extends Migration
{
    public function up()
    {
        Schema::create('xitara_accordion_text_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 511)->nullable();
            $table->mediumtext('textlist')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xitara_accordion_text_lists');
    }
}
