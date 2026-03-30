<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assignment</title>
    <style>
        :root {
            --green : #102721;
            --light-green: #4b6343;
            --page : #cbba9e;
            --light-brown : #89633f;
            --dark-brown: #4c2c17;
            --white : #fffcf1;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #2C3E50;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #89633f 0%, #4c2c17 100%);
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .header {
            background: linear-gradient(135deg, #102721 0%, #4b6343 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            margin: -30px -30px 30px -30px;
            position: relative;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            padding: 10px;
        }
        .task-details {
            background: linear-gradient(135deg, #F8FAFE 0%, #E8F4FD 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid #E3F2FD;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #E3F2FD;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #34495E;
        }
        .value {
            color: #5D6D7E;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-pending {
            background: linear-gradient(135deg, #F39C12 0%, #E67E22 100%);
            color: white;
        }
        .status-in-progress {
            background: linear-gradient(135deg, #3498DB 0%, #2980B9 100%);
            color: white;
        }
        .status-completed {
            background: linear-gradient(135deg, #27AE60 0%, #229954 100%);
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E3F2FD;
            color: #7F8C8D;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #4b6343 0%, #102721 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        .description-box {
            background: linear-gradient(135deg, #F8FAFE 0%, #E8F4FD 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #102721;
        }
        .notes-box {
            background: linear-gradient(135deg, #E8F8F5 0%, #D5F4E6 100%);
            color: #1B4F3F;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #27AE60;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Company Logo" class="logo">
            <h1>🎯 New Task Assignment</h1>
            <p>You have been assigned a new task</p>
        </div>

        <div class="content">
            <p>Hello {{ $user->name ?? 'Team Member' }},</p>
            
            <p>You have been assigned a new task in the Resource Management System. Please review the details below:</p>

            <div class="task-details">
                <h3 style="color: #4A90E2; margin-top: 0;">📋 Task Details</h3>
                
                <div class="detail-row">
                    <span class="label">Task Content:</span>
                                    <br>
                    <span class="value">{{ $task->content }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Assigned To:</span>
                                    <br>
                    <span class="value">{{ $user->name ?? 'N/A' }} ({{ $user->email ?? 'N/A' }})</span>
                </div>

                <div class="detail-row">
                    <span class="label">Due Date:</span>
                                    <br>
                    <span class="value">{{ \Carbon\Carbon::parse($task->ended_at)->format('F j, Y \a\t g:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">Status:</span>
                                    <br>
                    <span class="value">
                        @if($task->status)
                            @php
                                $statusClass = 'status-pending';
                                if(strtolower($task->status) === 'in progress') $statusClass = 'status-in-progress';
                                elseif(strtolower($task->status) === 'completed') $statusClass = 'status-completed';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $task->status }}</span>
                        @else
                            <span class="status-badge status-pending">Pending</span>
                        @endif
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">Time Remaining:</span>
                    <br>
                    <span class="value">
                        @php
                            $dueDate = \Carbon\Carbon::parse($task->ended_at);
                            $now = \Carbon\Carbon::now();
                            $isOverdue = $dueDate->isPast();
                        @endphp
                        @if($isOverdue)
                            <span style="color: #E74C3C; font-weight: bold;">⚠️ Overdue by {{ $now->diffForHumans($dueDate, true) }}</span>
                        @else
                            <span style="color: #27AE60; font-weight: 600;">{{ $now->diffForHumans($dueDate, true) }} remaining</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="description-box">
                <h4 style="color: #4A90E2; margin-top: 0;">📝 Task Description</h4>
                <p>{{ $task->content }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url( route('dashboard') ) }}" class="btn">View Task in System</a>
            </div>

            <div class="notes-box">
                <strong>💡 Important Notes:</strong>
                <ul style="margin: 15px 0; padding-left: 20px;">
                    <li>Please acknowledge receipt of this task assignment</li>
                    <li>Contact your supervisor if you have any questions</li>
                    <li>Update task status regularly in the system</li>
                    <li>Notify management if you anticipate any delays</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>This email was sent automatically by the Resource Management System.</p>
            <p>If you have any questions, please contact your supervisor or system administrator.</p>
            <p><small>© {{ date('Y') }} Resource Management System. All rights reserved.</small></p>
        </div>
    </div>
</body>
</html>
