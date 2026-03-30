<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير المرتبات - {{ $monthName }} {{ $selectedYear }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        
        .header h2 {
            color: #666;
            margin: 5px 0;
            font-size: 18px;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-item .label {
            font-weight: bold;
            color: #666;
            font-size: 12px;
        }
        
        .summary-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .employee-name {
            text-align: right;
            font-weight: bold;
        }
        
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .no-print {
                display: none !important;
            }
            
            table {
                font-size: 11px;
            }
            
            th, td {
                padding: 6px;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">طباعة التقرير</button>
    
    <div class="header">
        <h1>{{ config('app.name', 'نظام إدارة المطاعم') }}</h1>
        <h2>تقرير المرتبات الشهري</h2>
        <p><strong>{{ $monthName }} {{ $selectedYear }}</strong></p>
        <p>تاريخ الإنشاء: {{ $generatedAt }}</p>
    </div>

    @if($salaryReports->count() > 0)
        <!-- Summary Section -->
        <div class="summary">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="label">عدد الموظفين</div>
                    <div class="value">{{ $totalEmployees }}</div>
                </div>
                <div class="summary-item">
                    <div class="label">إجمالي الساعات</div>
                    <div class="value">{{ number_format($totalHours, 2) }}</div>
                </div>
                <div class="summary-item">
                    <div class="label">إجمالي المرتبات</div>
                    <div class="value">{{ number_format($totalSalary, 2) }} جنيه</div>
                </div>
                <div class="summary-item">
                    <div class="label">متوسط الراتب</div>
                    <div class="value">{{ number_format($totalSalary / $totalEmployees, 2) }} جنيه</div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <table>
            <thead>
                <tr>
                    <th>اسم الموظف</th>
                    <th>أيام الشهر</th>
                    <th>أيام الحضور</th>
                    <th>أيام الغياب</th>
                    <th>الساعات المطلوبة</th>
                    <th>الساعات الفعلية</th>
                    <th>الساعات الإضافية</th>
                    <th>الساعات الناقصة</th>
                    <th>الراتب النهائي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaryReports as $report)
                <tr>
                    <td class="employee-name">{{ $report->employee->name }}</td>
                    <td>{{ $report->days_in_month }}</td>
                    <td>{{ $report->attendance_days }}</td>
                    <td>{{ $report->absence_days }}</td>
                    <td>{{ number_format($report->required_hours, 2) }}</td>
                    <td>{{ number_format($report->actual_hours, 2) }}</td>
                    <td>{{ number_format($report->extra_hours, 2) }}</td>
                    <td>{{ number_format($report->missing_hours, 2) }}</td>
                    <td>{{ number_format($report->final_salary, 2) }} جنيه</td>
                </tr>
                @endforeach
                
                <!-- Total Row -->
                <tr class="total-row">
                    <td>الإجمالي</td>
                    <td>-</td>
                    <td>{{ $salaryReports->sum('attendance_days') }}</td>
                    <td>{{ $salaryReports->sum('absence_days') }}</td>
                    <td>{{ number_format($salaryReports->sum('required_hours'), 2) }}</td>
                    <td>{{ number_format($salaryReports->sum('actual_hours'), 2) }}</td>
                    <td>{{ number_format($salaryReports->sum('extra_hours'), 2) }}</td>
                    <td>{{ number_format($salaryReports->sum('missing_hours'), 2) }}</td>
                    <td>{{ number_format($salaryReports->sum('final_salary'), 2) }} جنيه</td>
                </tr>
            </tbody>
        </table>

        <!-- Calculation Formula -->
        <div class="summary">
            <h3 style="margin-top: 0;">معادلة حساب الراتب:</h3>
            <p><strong>الراتب النهائي = (الساعات الفعلية × قيمة الساعة) + (الساعات الإضافية × قيمة الساعة × 1.25) - (الساعات الناقصة × قيمة الساعة)</strong></p>
            <ul style="margin: 10px 0; padding-right: 20px;">
                <li>الساعات الإضافية تُحسب بمعدل 1.25 من قيمة الساعة العادية</li>
                <li>الساعات الناقصة تُخصم من الراتب بقيمة الساعة العادية</li>
                <li>أيام الجمعة لا تُحسب كأيام عمل</li>
                <li>الحد الأدنى للراتب هو صفر (لا يمكن أن يكون سالباً)</li>
            </ul>
        </div>

    @else
        <div class="no-data">
            <h3>لا توجد تقارير للفترة المحددة</h3>
            <p>{{ $monthName }} {{ $selectedYear }}</p>
        </div>
    @endif

    <div class="footer">
        <p>تم إنشاء هذا التقرير بواسطة نظام إدارة الموارد البشرية</p>
        <p>{{ config('app.name', 'نظام إدارة المطاعم') }} - {{ date('Y') }}</p>
    </div>

    <script>
        // Auto-print when opened in new window
        if (window.location.search.includes('auto_print=1')) {
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            };
        }
    </script>
</body>
</html>
