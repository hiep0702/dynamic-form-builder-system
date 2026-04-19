<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->string('label')->after('type');
            $table->json('default_value')->nullable()->after('label');
            $table->json('validation_rules')->nullable()->after('default_value');
            $table->json('properties')->nullable()->after('validation_rules');
        });
    }

    public function down(): void
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->dropColumn(['label', 'default_value', 'validation_rules', 'properties']);
        });
    }
};