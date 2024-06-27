<?php

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $fillable = [
        'poster_id',
        'title',
        'description',
        'salary',
        'salary_type',
        'job_location',
        'latitude',
        'longitude',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'duration',
        'job_status',
        'number_of_people_need',
        'job_type',
        'file',
        'post_status',
        'people_applied',
        'people_viewed',
        'people_joined',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'created_time',
        'updated_time',
    ];

}
