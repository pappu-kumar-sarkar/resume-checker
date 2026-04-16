<!DOCTYPE html>
<html>
<head>
    <title>Resume ATS Checker</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            flex-direction: column;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            width: 420px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        h4 {
            margin-top: 15px;
            color: #333;
            text-align: left;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            background: #667eea;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #5a67d8;
            transform: scale(1.05);
        }

        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 20px auto;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .text {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }

        .highlight {
            color: #667eea;
            font-weight: bold;
        }

        ul {
            margin-top: 8px;
            text-align: left;
            padding-left: 20px;
        }

        li {
            margin-bottom: 6px;
            color: #444;
        }

        header {
            padding: 15px 30px;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer {
            text-align: center;
            padding: 10px;
            color: white;
            font-size: 14px;
        }

        .status-box {
            margin-top: 15px;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 15px;
        }

        .selected {
            background: #e6ffed;
            color: #0f8a36;
        }

        .rejected {
            background: #ffe8e8;
            color: #d93025;
        }

        .reason {
            margin-top: 12px;
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            text-align: left;
        }
    </style>
</head>

<body>

<header>
    🚀 Resume ATS Checker
</header>

<div class="main">
    <div class="card">

        <h2>Upload Your Resume</h2>

        <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="resume" required>
            <br>
            <button class="btn">Check ATS Score</button>
        </form>

        @if(isset($score))
            <div class="score-circle">
                {{ $score }}%
            </div>

            <p class="text">
                Matched Keywords:
                <span class="highlight">{{ $count }}/{{ $totalKeywords }}</span>
            </p>

            @if($status == 'selected')
                <div class="status-box selected">
                    ✅ Resume Selected
                </div>
            @else
                <div class="status-box rejected">
                    ❌ Resume Rejected
                </div>
            @endif

            <div class="reason">
                <strong>Reason:</strong> {{ $message }}
            </div>

            <h4>✅ Matched Keywords:</h4>
            @if(count($matched) > 0)
                <ul>
                    @foreach($matched as $word)
                        <li>{{ $word }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text">No keywords matched.</p>
            @endif

            <h4>❌ Missing Keywords:</h4>
            @if(count($missing) > 0)
                <ul>
                    @foreach($missing as $word)
                        <li>{{ $word }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text">All keywords matched.</p>
            @endif
        @endif

    </div>
</div>

<footer>
    © 2026 Resume Checker | Built with Laravel 💻
</footer>

</body>
</html>