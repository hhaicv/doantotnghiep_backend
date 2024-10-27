<?php

use App\Models\Information;
use App\Models\NewCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('information_new_category', function (Blueprint $table) {
            $table->foreignIdFor(Information::class)->constrained();
            $table->foreignIdFor(NewCategory::class)->constrained();
            $table->primary(['information_id','new_category_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('information_new_category');
    }
};
