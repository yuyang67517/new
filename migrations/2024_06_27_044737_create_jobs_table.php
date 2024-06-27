<?php

use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('poster_id');
            $table->string('title');
            $table->text('description');
            $table->decimal('salary', 10, 2);
            $table->enum('salary_type', ['hourly', 'daily', 'monthly']);
            $table->string('job_location');
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Allow NULL for optional end date
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration')->nullable();
            $table->enum('job_status', ['draft', 'open', 'closed'])->default('draft');
            $table->integer('number_of_people_need')->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'freelance']);
            $table->string('file')->nullable();
            $table->enum('post_status', ['draft', 'published'])->default('draft');
            $table->integer('people_applied')->default(0);
            $table->integer('people_viewed')->default(0);
            $table->integer('people_joined')->default(0);
            $table->timestamps();

            // Define foreign key
            $table->foreign('poster_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
}
