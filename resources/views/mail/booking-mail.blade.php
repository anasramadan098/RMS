<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Notification</title>
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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--page);
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, var(--green), var(--light-green));
            color: var(--white);
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .booking-card {
            background-color: var(--page);
            border-left: 4px solid var(--light-brown);
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .booking-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .detail-item {
            background-color: var(--white);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--light-brown);
        }
        .detail-label {
            font-weight: bold;
            color: var(--dark-brown);
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            color: var(--green);
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .alert-box {
            background-color: var(--page);
            border: 1px solid var(--light-brown);
            color: var(--dark-brown);
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, var(--green), var(--light-green));
            color: var(--white);
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background-color: var(--dark-brown);
            color: var(--white);
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .cafe-info {
            background: linear-gradient(135deg, var(--light-brown), var(--dark-brown));
            color: var(--white);
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }
        @media (max-width: 600px) {
            .booking-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 New Booking Alert!</h1>
            <p>You have received a new reservation for your cafe</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="cafe-info">
                <h2 style="margin: 0 0 10px 0;">
                    {{ env('APP_NAME') }}
                </h2>
                {{-- <p style="margin: 0; opacity: 0.9;">{{ $booking->cafe->address ?? 'Cafe Address' }}</p> --}}
            </div>

            <div class="alert-box">
                <strong>📋 Booking Alert!</strong><br>
                Please review the booking details below and confirm the reservation.
            </div>

            <div class="booking-card">
                <h3 style="margin: 0 0 15px 0; color: #8B4513;">Customer Information</h3>
                
                <div class="booking-details">
                    <div class="detail-item">
                        <div class="detail-label">Customer Name</div>
                        <div class="detail-value">{{ $booking->name ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Phone Number</div>
                        <div class="detail-value">{{ $booking->phone ?? 'N/A' }}</div>
                    </div>
                    
                    
                    <div class="detail-item">
                        <div class="detail-label">Count of Guests</div>
                        <div class="detail-value">{{ $booking->guests ?? 'N/A' }} people</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Booking Date</div>
                        <div class="detail-value">{{ $booking->datetime ? date('F j, Y', strtotime($booking->datetime)) : 'N/A' }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-label">Booking Time</div>
                        <div class="detail-value">{{ $booking->datetime ? date('g:i A', strtotime($booking->datetime)) : 'N/A' }}</div>
                    </div>
                    
                    <div class="detail-item full-width">
                        <div class="detail-label">Event (Seem Have Additional Info) </div>
                        <div class="detail-value">{{ $booking->event }}</div>
                    </div>
                    
                    
                    <div class="detail-item">
                        <div class="detail-label">Booking ID</div>
                        <div class="detail-value">#{{ $booking->id ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/bookings/' . ($booking->id ?? '')) }}" class="action-button">
                    View & Manage Booking
                </a>
            </div>

            <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                <h4 style="color: #8B4513; margin: 0 0 15px 0;">📞 Next Steps:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #666;">
                    <li>Review the booking details carefully</li>
                    <li>Contact the customer if you need to confirm any details</li>
                    <li>Update the booking status in your admin panel</li>
                    <li>Prepare your cafe for the upcoming reservation</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">© {{ date('Y') }} Restaurant Management System | ICODE </p>
        </div>
    </div>
</body>
</html>
