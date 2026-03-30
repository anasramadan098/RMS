@extends('layouts.menu')

@section('styles')
    <style>
        .offers{
            padding: 50px 0;
            min-height: 100vh;
            .no {
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                gap: 30px;
            }
        }
        .offer {
            width: 100%;
            background-color: #fff;
            margin-top: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            padding : 50px 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        .offer img {
            width: 100%;
            height: 100%;
            max-height: 150px;
            border-radius: 10px;
        }
        .offer h4{
            font-size: 14px;
            font-weight: bold;
            color: #000;
            width: 100%;
            text-align: right;
        }
        .pop-up-offer {
            position: fixed;
            top: 15px;
            left: 0;
            width: 100%;
            min-height: calc(100vh - 110px);
            z-index: 1000000;
            background: #fff;
            transform: translate(100%);
            transition: .3s;
            &.active {
                transform: translate(0);
            }
            .close {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                padding: 10px;
                background: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: 5px;
                right: 10px;
            }
            .content {
                .img {
                    padding: 20px;
                    img {
                        max-width: 100%;
                        border-radius: 20px;
                    }
                }
                .text { 
                    margin-top: 10px;
                    padding: 0 20px;
                    > h3 {
                        font-size: 1.22em;
                        font-weight: bold;
                    }
                    > p {
                        font-size: .94em;
                        line-height: 1.5;
                    }
                    ul {
                        list-style: none;
                        padding-left: 15px;
                        li {
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            padding: 0px 0 15px;
                            p {
                                margin-bottom: 0; 
                            }
                            span {
                                display: inline-block;
                            }
                            &:not(:last-child) {
                                border-bottom: 1px solid #ddd;
                            }
                        }
                    }
                    a.terms {
                        font-size: 14px;
                    }
                    a.how {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        gap: 10px;
                        margin: 20px 0;
                        padding: 10px;
                        border: 2px solid #999;
                        border-radius: 6px;
                        text-decoration: none;
                        color: #333;
                    }
                }

            }
        }

        .ar {
            display: none;
            &.active {
                display: block;
            }
        }
        .en {
            display: none;
            &.active {
                display: block;
            }
        }
    </style>
@endsection
@section('content') 

<div class="offers">
    <div class="container">  
        @if (isset($ads) and count ($ads ) > 0)
            @foreach ($ads as $ad)
                <div class="offer">
                    <img src="{{asset($ad->path)}}" alt="{{$ad->name_ar}}">
                    {{-- Name --}}
                    <h4 class="ar">
                        {{$ad->name_ar}}
                    </h4>
                    <h4 class="en">
                        {{$ad->name_en}}
                    </h4>

                    {{-- Desc --}}
                    <p class="ar" style="display: none;">
                        {{$ad->description_ar}}
                    </p>
                    <p class="en" style="display: none;">
                        {{$ad->description_en}}
                    </p>
                    <div style="display: none;">
                        <span class="start">
                            {{$ad->start_time}}
                        </span>
                        <span class="end">
                            {{$ad->end_time}}
                        </span>
                    </div>
                </div>
            @endforeach
        @else 
                <div class="col-md-12 no">
                    <h3 class="ar">لا يوجد عروض حاليا</h3>
                    <h3 class="en">No Offers Yet</h3>
                </div>
        @endif
    </div>
</div>
<div class="pop-up-offer">
    <div class="close">
        {{-- Arrow Right Icon --}}
        <i class="fas fa-arrow-right"></i>
    </div>
    <div class="content">
        <div class="img">
            <img src="" alt="">
        </div>
        <div class="text">
            <h3 class="ar">
                
            </h3>
            <h3 class="en">
                
            </h3>
            <p class="ar">
                
            </p>
            <p class="en">
               
            </p>
            <ul>
                <li>
                    <i class="fas fa-clock"></i>
                    <p>
                        <span class="start">
                            
                        </span>
                        <span>
                            -
                        </span>
                        <span class="end">
                            
                        </span>
                    </p>
                </li>
            </ul>
            <a href="#" class="terms" data-text="terms">
                الشروط و الأحكام
            </a>
            <a href="#" class="how">
                <div class="start">
                    <i class="fas fa-question"></i>
                    <span data-text="howWork">
                        كيف تعمل
                    </span>
                </div>
                <div class="end">
                    <i class="fas fa-arrow-left"></i>
                </div>
            </a>
        </div>
    </div>
</div>





@endsection


@section('js')


<script>

        function updateOffers()
        {
            document.querySelectorAll(`.${currentLanguage}`).forEach(el => el.classList.add('active'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const popUp = document.querySelector('.pop-up-offer');
            // Click Input To Show Pop UP
            document.querySelectorAll('.offer').forEach(offer => {
                offer.addEventListener('click', function() {


                    // Get Data
                    const img = offer.querySelector('img').getAttribute('src');
                    const name = offer.querySelector(`h4.${currentLanguage}`).textContent;
                    const desc = offer.querySelector(`p.${currentLanguage}`).textContent;

                    const start = new Date(offer.querySelector(`span.start`).textContent).toLocaleTimeString(
                        'en-US',
                        {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        }
                    );
                    const end = new Date(offer.querySelector(`span.end`).textContent).toLocaleTimeString(
                        'en-US',
                            {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        }   
                    );;

                    // Set Pop UP
                    popUp.querySelector('.img img').setAttribute('src', img);
                    popUp.querySelector(`.text h3.${currentLanguage}`).textContent = name;
                    popUp.querySelector(`.text p.${currentLanguage}`).textContent = desc;
                    popUp.querySelector('.text ul li p span.start').textContent = start;
                    popUp.querySelector('.text ul li p span.end').textContent = end;


                    if (currentLanguage == 'en') {
                        popUp.querySelector('.how .end i').style.transform = 'rotate(180deg)';
                    }

                    popUp.classList.add('active');
                })
            })

            popUp.querySelector('.close').addEventListener('click', function() {
                popUp.classList.remove('active');
            })
        });
</script>

@endsection
