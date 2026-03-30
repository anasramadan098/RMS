
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Somi Cafe Spin Wheel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      height: 100vh;
      background: #1e1e2f;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .wheel-container {
      position: relative;
      width: 400px;
      height: 400px;
    }
    @media (max-width: 767px) {
        .wheel-container {
            width: 90%;
        }
    }

    canvas {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }

    .spin-btn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 12px 25px;
      background: #ff5722;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 18px;
      transition: 0.3s;
    }

    .spin-btn:hover {
      background: #e64a19;
    }

    .popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 20px 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      text-align: center;
      display: none;
    }

    .popup h2 {
      margin: 0 0 15px;
      font-size: 22px;
    }

    .popup button {
      padding: 10px 20px;
      background: #4caf50;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    .popup button:hover {
      background: #45a049;
    }
    .logo {
      max-width: 100%;
      height: 150px;
      margin-bottom: 30px;
    }
            .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.35);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
            &.active {
                display : flex;
            }
        }
        .client-auth {
            position: fixed;
            width: 100%; 
            height: 100%; 
            justify-content: center;
            align-items:center;
            border-radius: 8px;
            display: none;
            &.active {
                display : flex;
            }
            form {
                padding: 20px 30px;
                background: #fff;
                display: flex;
                flex-direction: column;
                gap: 25px;
                min-width: 50%;
                i {
                    font-size: 1.2em;
                    color : red;
                }
                input {
                    text-align: left;
                }
                button {
                    background: #0e6030;
                    color : #fff; 
                }
                span {
                  font-size: 1.5em; color: #0e6030;
                }
            }
        }
  </style>
</head>
<body>
  <header>
    <img src="{{asset('img/logo.png')}}" alt="Somi Cafe Logo" class="logo">
  </header>
  <div class="wheel-container">
    <canvas id="wheel"></canvas>
    <button class="spin-btn" id="spinBtn">Spin Now</button>
  </div>
  <div class="popup" id="popup">
    <h2 id="prizeText">You won!</h2>
    <button id="prize-btn">Claim Prize</button>
  </div>
  <div class="client-auth overlay">
    <form action="{{route('client_menu')}}" data-go="false" method="POST">
        <i class="fa-solid fa-xmark close"></i>
        @csrf
        <input type="text" required name="name" class="form-control" placeholder="Enter Your Name">
        <input type="tel" required name="phone" class="form-control" placeholder="Enter Your Phone">
        <input type="number" required name="t_n" max="50" min="1" maxlength="2" minlength="1" class="form-control" placeholder="Enter Your Table Number">
        <input type="hidden" name="per">
        <input type="hidden" name="app">
        <input type="hidden" name="client_data">
        <p>
        </p>
        <button  class="form-control">Follow</button>
    </form>
</div>
    <script src="{{asset('js/saveClient.js')}}"></script>
  <script>
    if (client.spin) {
          location.replace('/menu')
      }
      
    const canvas = document.getElementById('wheel');
    const ctx = canvas.getContext('2d');
    const popup = document.getElementById('popup');
    const prizeText = document.getElementById('prizeText');
    const spinBtn = document.getElementById('spinBtn');
    const prizeBtn = document.getElementById('prize-btn');

    const segments = ['10% Offer', 'Free Coffe', '5% Discount', '20% Discount' , 'Try Again !'];
    const colors = ['#FF6B6B', '#F7B801', '#6BCB77', '#4D96FF', '#9D4EDD', '#FF9671'];

    let startAngle = 0;
    const arc = Math.PI / (segments.length / 2);
    let spinAngleStart = 0;
    let spinTime = 0;
    let spinTimeTotal = 0;

    canvas.width = 400;
    canvas.height = 400;

    let isSpinning = false;

    function drawWheel() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let i = 0; i < segments.length; i++) {
        const angle = startAngle + i * arc;
        ctx.fillStyle = colors[i % colors.length];

        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        ctx.arc(canvas.width / 2, canvas.height / 2, canvas.width / 2, angle, angle + arc);
        ctx.fill();

        ctx.save();
        ctx.fillStyle = 'white';
        ctx.translate(canvas.width / 2, canvas.height / 2);
        ctx.rotate(angle + arc / 2);
        ctx.textAlign = 'right';
        ctx.font = 'bold 20px Arial';
        ctx.translate(-5, 10);
        ctx.fillText(segments[i], canvas.width / 2 - 10, 0);
        ctx.restore();
      }
    }

    function rotateWheel() {
      spinTime += 30;
      if (spinTime >= spinTimeTotal) {
        stopRotateWheel();
        return;
      }
      const spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
      startAngle += (spinAngle * Math.PI / 180);
      drawWheel();
      requestAnimationFrame(rotateWheel);
    }

    function stopRotateWheel() {
      const degrees = startAngle * 180 / Math.PI + 90;
      const arcd = arc * 180 / Math.PI;
      const index = Math.floor((360 - (degrees % 360)) / arcd);

      prizeText.textContent = `You won: ${segments[index]}!`;
      popup.style.display = 'block';
      isSpinning = false;
    }

    function easeOut(t, b, c, d) {
      const ts = (t /= d) * t;
      const tc = ts * t;
      return b + c * (tc + -3 * ts + 3 * t);
    }

    spinBtn.addEventListener('click', () => {
      if (isSpinning) return;
      isSpinning = true;
      spinAngleStart = Math.random() * 3000 + 2000;
      spinTime = 0;
      spinTimeTotal = Math.random() * 3000 + 4000;
      rotateWheel();
    });

    prizeBtn.addEventListener('click', () => {
        closePopup();
        const prize = prizeText.textContent.replace('You won: ', '').replace('!', '');
        afterWin(prize);
    })

    function closePopup() {
      popup.style.display = 'none';
    }

    function slowRotate() {
      if (isSpinning) return;
      startAngle += 0.002;
      drawWheel();
      requestAnimationFrame(slowRotate);
    }
    function afterWin(prize) {
        let isCoffe = false;
        result = prize;
        if (prize.toLowerCase() == 'free coffe') {
            isCoffe = true;
            result = 'free coffe';
        }
      
        if (prize == segments[segments.length - 1]) {
          return;
        }
        
        overlay.classList.add('active');
        clientAuth.classList.add('active');

        

        

    } 

    drawWheel();
    slowRotate();
  </script>

</body>
</html>
