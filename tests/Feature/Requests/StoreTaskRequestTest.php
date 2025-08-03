<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Requests\StoreTaskRequest;

class StoreTaskRequestTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_authorize(): void
    {
        $this->assertTrue((new StoreTaskRequest)->authorize());
    }

    public function test_rules(): void
    {
        $request = new StoreTaskRequest;

        $this->assertEquals([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|integer|exists:status,id',
            'due_date' => 'required|date_format:j/n/Y|after_or_equal:today',
        ], $request->rules());
    }
}
