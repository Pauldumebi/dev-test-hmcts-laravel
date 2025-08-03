<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Requests\UpdateTaskRequest;

class UpdateTaskRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorize(): void
    {
        $this->assertTrue((new UpdateTaskRequest)->authorize());
    }

    public function test_rules(): void
    {
        $request = new UpdateTaskRequest;

        $this->assertEquals([
            'status_id' => 'required|integer|exists:status,id',
        ], $request->rules());
    }
}
