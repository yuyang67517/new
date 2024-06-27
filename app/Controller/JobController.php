<?php

namespace App\Controller;

use App\Model\Job;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Utils\Context;
/**
 * @AutoController()
 */
class JobController
{
    protected $validator;

    public function __construct(ValidatorFactoryInterface $validator)
    {
        $this->validator = $validator;
    }

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        // Validate incoming request data (example)
        $validation = $this->validator->make(
            $request->all(),
            [
                'poster_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'salary' => 'required|numeric',
                'salary_type' => 'required|in:hourly,daily,monthly',
                'job_location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'job_type' => 'required|in:full-time,part-time,freelance',
                // Add more validation rules as needed
            ]
        );

        if ($validation->fails()) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validation->errors()->all()
            ], 422);
        }

        // Create the job
        $data = $request->all();
        $job = Job::create($data);

        // Return response
        return response()->json($job);
    }

    public function show(ServerRequestInterface $request, int $id): ResponseInterface
    {
        $job = Job::findOrFail($id);
        return response()->json($job);
    }

    public function update(ServerRequestInterface $request, int $id): ResponseInterface
    {
        $data = $request->getParsedBody();
        $job = Job::findOrFail($id);
        $job->update($data);
        return response()->json($job);
    }

    public function destroy(ServerRequestInterface $request, int $id): ResponseInterface
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json(['message' => 'Job deleted']);
    }
}
