<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('video_reels', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('embed_code');
            $table->string('thumbnail')->nullable()->after('video_file');
        });
    }

    public function down()
    {
        Schema::table('video_reels', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'thumbnail']);
        });
    }
};
