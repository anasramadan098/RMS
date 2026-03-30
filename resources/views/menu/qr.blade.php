<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Discount !</title>
    <meta name="description" content="Get Discount By Follow Our Page On Social Media">
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            min-height: 100px;
            background:#0e6030;
            display : flex;
            justify-content: center;
            align-items: center;
            img {
                max-width: 100%;
                height: 150px;
            }
        }

        section.icons {
            margin-top: 35px;
            padding : 50px 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            justify-items: center;
            align-items: center;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            .icon {
                
                background: #f1f1f1;
                border-radius: 12px;
                padding: 34px 45px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                position: relative;
                transition: transform 0.2s, box-shadow 0.2s;
                cursor: pointer;
                border: 1px solid #ddd;
                &.not-allowed {
                    pointer-events :none;
                    opacity : 0.5;
                    filter : grayscale(80%);
                    cursor : not-allowed;
                    position: relative;
                    &::after {
                        content:"";
                        position: absolute;
                        width: 100%;
                        height: 5px;
                        background-color: #000;
                        transform: rotate(45deg);
                        top: 40%;
                        right: 0;
                    }
                }
            }
            .icon:hover {
                transform: translateY(-6px) scale(1.05);
                box-shadow: 0 6px 24px rgba(0,0,0,0.12);
            }
            .icon i {
                font-size: 3rem;
                color: var(--c, #333);
                margin-bottom: 12px;
            }
            .icon::after {
                content: attr(data-number);
                position: absolute;
                top: -15%;
                left: 50%;
                transform: translateX(-50%);
                background: #0e6030;
                color: #fff;
                font-size: 1rem;
                padding: 4px 10px;
                border-radius: 8px;
                font-weight: bold;
                box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            }
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
            }
        }
    </style>
</head>
<body>

    <header>
            <img src="{{asset('img/logo.png')}}" alt="Somi Cafe Logo" class="logo">
    </header>

    <section class="icons">
        <div class="icon" data-number="10%" data-name="face" data-link="https://www.facebook.com/somicafe#">
            <i class="fa-brands fa-facebook-f" style="--c: #1877F2"></i>
        </div>
        <div class="icon" data-number="10%" data-name="insta" data-link="https://www.instagram.com/somicafe.eg/">
            <i class="fa-brands fa-instagram" style="--c: #833ab4"></i>
        </div>
        <div class="icon" data-number="10%" data-name="google" data-link="https://www.google.com/maps/place/Somi+Cafe+-+%D8%B3%D9%88%D9%85%D9%8A+%D9%83%D8%A7%D9%81%D9%8A%D9%87%E2%80%AD/@29.9515263,31.2681424,17z/data=!3m1!4b1!4m6!3m5!1s0x14583956b48a2aeb:0xc8f6916c71535817!8m2!3d29.9515217!4d31.2655675!16s%2Fg%2F11ydcd3m1h?authuser=0&entry=ttu&g_ep=EgoyMDI1MDcwNi4wIKXMDSoASAFQAw%3D%3D">
            <i class="fa-brands fa-google" style="--c: #4285F4"></i>
        </div>
        <div class="icon" data-number="10%" data-name="tiktok" data-link="https://www.tiktok.com/@somicafe.eg">
            <i class="fa-brands fa-tiktok" style="--c: #000"></i>
        </div>
    </section>


    <div class="client-auth overlay">
        <form action="{{route('client_menu')}}" method="POST">
            <i class="fa-solid fa-xmark close"></i>
            @csrf
            <input type="text" required name="name" class="form-control" placeholder="Enter Your Name">
            <input type="tel" required name="phone" class="form-control" placeholder="Enter Your Phone">
            <input type="number" required name="t_n" max="50" min="1" maxlength="2" minlength="1" class="form-control" placeholder="Enter Your Table Number">
            <input type="hidden" name="r_link">
            <input type="hidden" name="per">
            <input type="hidden" name="app">
            <input type="hidden" name="client_data">
            <button  class="form-control">Follow</button>
        </form>
    </div>
    <script src="{{asset('js/saveClient.js')}}"></script>
    <script>


        if (client) {
            if (!client.reload) {
                location.reload();
                client.reload = true;
                localStorage.setItem('somi_client', JSON.stringify(client));
            }
        }
        
        let hoursEnded = false;


        let targetDate = new Date(client.lastFollow); // غيّره للتاريخ اللي انت عايزه

        // تاريخ النهارده
        let today = new Date();
        

        
        // نخلّي الاتنين نفس التوقيت عشان المقارنة تكون دقيقة (نصفر الوقت)
        targetDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);
        
        if (targetDate > today) {
            hoursEnded = true;
        }


        document.querySelectorAll('.icons .icon').forEach(icon => {
            icon.addEventListener('click' , () => {

                if (client) {
                    
                    
                    if (!hoursEnded) {
                        // Bootstrap alert for waiting 24 hours
                        let alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-warning alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alertDiv.style.zIndex = 2000;
                        alertDiv.role = 'alert';
                        alertDiv.innerHTML = `
                            يجب عليك الذهاب إلى الكافيه بعد 24 ساعة للحصول على الخصم.
                        `;
                        document.body.appendChild(alertDiv);
                        setTimeout(() => {
                            alertDiv.classList.remove('show');
                            alertDiv.classList.add('hide');
                            setTimeout(() => alertDiv.remove(), 2000);
                        }, 4000);
                        return;
                    }
                }


                overlay.classList.add('active');
                clientAuth.classList.add('active');

                document.querySelector('input[name="r_link"]').value = icon.dataset.link;
                document.querySelector('input[name="per"]').value = icon.dataset.number;
                document.querySelector('input[name="app"]').value += `,${icon.dataset.name}`;

            })

            if (client) {
                client.app.map(e => {
                    if (icon.dataset.name == e) {
                        icon.classList.add('not-allowed')
                    }
                })
                
            
            
            }
        })


    </script>



</body>
</html>