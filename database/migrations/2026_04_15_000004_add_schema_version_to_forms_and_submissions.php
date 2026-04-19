<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->unsignedInteger('schema_version')->default(1)->after('status');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->unsignedInteger('schema_version')->after('payload');
            $table->json('schema_snapshot')->after('schema_version');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['schema_version', 'schema_snapshot']);
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('schema_version');
        });
    }
};
