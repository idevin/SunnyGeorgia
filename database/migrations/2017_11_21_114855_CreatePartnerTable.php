<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('logo_image_id')->nullable();

            $table->text('description')->nullable();

            $table->boolean('vat')->default(false);

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();

            $table->string('llc')->nullable();
            $table->string('reg_type', 50)->default('');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('postcode')->nullable();
            $table->boolean('address_confirmed')->default(false);

            $table->string('bank_name')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('bank_number')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('bank_address1')->nullable();
            $table->string('bank_address2')->nullable();
            $table->string('bank_recipient')->nullable();

            $table->string('website')->nullable();
            $table->integer('legal_status_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');

    }
}
