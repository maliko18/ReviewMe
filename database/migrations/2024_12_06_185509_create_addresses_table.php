<?php

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('state');
            $table->string('zip');
            $table->json('coordinates')->nullable();
            $table->json('meta')->nullable();
            $table->integer('addressable_id');
            $table->string('addressable_type');
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->foreignIdFor(Country::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
