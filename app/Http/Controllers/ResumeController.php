<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use Smalot\PdfParser\Parser;

class ResumeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,txt'
        ]);

        $file = $request->file('resume');

        // file save
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        $text = '';

        try {
            $parser = new Parser();
            $pdf = $parser->parseFile(public_path('uploads/' . $fileName));
            $text = $pdf->getText();
        } catch (\Exception $e) {
            $text = file_get_contents(public_path('uploads/' . $fileName));
        }

        // clean text
        $text = strtolower($text);
        $text = preg_replace('/\s+/', ' ', $text);

        $keywords = [
            'skills',
            'education',
            'contact',
            'experience',
            'php',
            'aws',
            'linux',
            'apache',
            'git',
            'visual studio'
        ];

        $count = 0;
        $matched = [];
        $missing = [];

        foreach ($keywords as $word) {
            if (strpos($text, $word) !== false) {
                $count++;
                $matched[] = $word;
            } else {
                $missing[] = $word;
            }
        }

        $totalKeywords = count($keywords);
        $score = round(($count / $totalKeywords) * 100);

        // status and message
        $status = 'rejected';
        $message = 'Your resume is rejected because it did not match all required keywords.';

        if ($score == 100) {
            Resume::create([
                'file_name' => $fileName,
                'matched_keywords' => $count,
                'score' => $score,
            ]);

            $status = 'selected';
            $message = 'Congratulations! Your resume matched all keywords and has been saved in the database.';
        } elseif ($score >= 80) {
            $message = 'Your resume is rejected because a few important keywords are missing.';
        } elseif ($score >= 50) {
            $message = 'Your resume is rejected because many important keywords are missing.';
        } else {
            $message = 'Your resume is rejected because most required keywords are missing.';
        }

        return view('index', compact(
            'score',
            'count',
            'matched',
            'missing',
            'status',
            'message',
            'totalKeywords'
        ));
    }
}