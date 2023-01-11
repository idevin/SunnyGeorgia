<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOptionsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options_groups', function (Blueprint $table) {
            $table->dropColumn('options');
        });
        DB::statement('ALTER TABLE options RENAME COLUMN group_id to options_group_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options_groups', function (Blueprint $table) {
            $table->boolean('options')->default(false);
        });
        DB::statement('ALTER TABLE options RENAME COLUMN options_group_id to group_id');
    }
}
