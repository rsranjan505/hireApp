<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerReport;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnswerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::with('user', 'question')->latest()->get();

        foreach ($answers as $answer) {
            $answer->report = AnswerReport::where('answer_id', $answer->id)->first();
        }

        return Inertia::render('report/index', ['answers' => $answers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'user_id' => 'required|exists:users,id',
            'answer_id' => 'required|exists:answers,id',
            'comment' => 'required|string|max:500',
            'score' => 'required|integer|min:1|max:10',
        ]);

        $request['reported_by'] = auth()->user()->id;

        AnswerReport::create($request);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnswerReport $answerReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnswerReport $answerReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnswerReport $answerReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnswerReport $answerReport)
    {
        //
    }
}
