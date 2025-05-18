<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選取座位</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            list-style: none;
            background-repeat: no-repeat;
        }

        .con-box {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 0 auto;
        }

        .left {
            width: 60%;
            height: 100vh;
            border-right: 1px dashed #000;
        }

        .left p {
            width: 70%;
            height: 35px;
            line-height: 35px;
            text-align: center;
            margin: 30px auto;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        .seat {
            display: flex;
            width: 80%;
            height: 750px;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: space-around;
            align-content: center;
            margin: 0 auto;
        }

        .seat li {
            width: 8%;
            height: 8%;
            border-radius: 5px;
            background-color: #b9ef9f;
            line-height: 60px;
            text-align: center;
            cursor: pointer;
        }

        .seat li.booked {
            background-color: grey;
            cursor: not-allowed;
        }

        .right {
            width: 35%;
            height: 100vh;
            color: #a79e9f;
            position: relative;
        }

        .right-con {
            width: 350px;
            height: 50vh;
            position: absolute;
            right: 0;
            top: 5%;
            line-height: 28px;
        }


        #seatNumbers {
            width: 240px;
        }

        .seat-number {
            display: inline-block;
            width: 100px;
            height: 30px;
            background-color: #efefef;
            border-radius: 5px;
            text-align: center;
            margin-left: 10px;
            margin-bottom: 10px;
            line-height: 30px;
            color: #000;
            border: #d1d1d1 1px solid;
        }

        .right-con button {
            width: 70px;
            height: 25px;
            margin: 25px 50px;
            background-color: #efefef;
            border: solid 0.5px #000;
            border-radius: 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="con-box">
        <div class="left">
            <p>屏幕</p>
            <ul class="seat"></ul>
        </div>

        <div class="right">
            
        </div>
    </div>

    <script>
        function test() {
            const rightConElement = document.querySelector('.right');
            const test = document.createElement('ul');

            const date = localStorage.getItem('date'); // 假設格式為 "XX:XX"
            const time = localStorage.getItem('time'); // 假設格式為 "HH:MM"
            const buyItem = localStorage.getItem('buyItems');
            const totalprice = localStorage.getItem('totalprice');

            // 將 date 格式化為 "X月X日"
            const [month, day] = date.split('-');
            const formattedDate = `${parseInt(month)}月${parseInt(day)}日`;

            // 將 time 格式化為 "HH:MM"
            const formattedTime = time;

            test.classList.add('right-con');
            test.innerHTML = `
                <li>影片：<span><?php session_start(); echo $_SESSION['name']; ?></span></li>
                <li>時間：<span>${formattedDate} ${formattedTime}</span></li>
                
                <li>座位：<p id="seatNumbers"></p></li>
                <li>票種資訊：<span>${buyItem}</span></li>
                <li>總計：<span>${totalprice}</span></li>
                <button>確認購買</button>
            `;

            rightConElement.appendChild(test);
        }


        //網頁加載完成後 執行
        document.addEventListener('DOMContentLoaded', function () {
            //localStorage.setItem("clicked", parseInt(0));
            test();
            const seatList = document.querySelector('.seat');
            const date = localStorage.getItem("date");
            const time = localStorage.getItem("time");
            const buyItem = localStorage.getItem('buyItems');
            const totalprice = localStorage.getItem('totalprice');

            //發送一個 HTTP 請求到 get_seats.php 這個 PHP 文件
            fetch(`get_seats.php?date=${date}&time=${time}`)
                .then(response => response.json())
                .then(data => {
                    //生成座位編號
                    for (let i = 1; i <= 8; i++) {
                        for (let j = 1; j <= 8; j++) {
                            const li = document.createElement('li');
                            //'1-1'
                            const seatId = `${i}-${j}`;
                            //以下幾句效果為<li data-seat-id='1-1'>1-1</li>
                            li.innerText = seatId;
                            li.setAttribute('data-seat-id', seatId);

                            if (data.bookedSeats.includes(seatId)) {
                                //<li data-seat-id='1-1' class='booked'>1-1</li>
                                li.classList.add('booked');
                            } else {
                                addSeatClick(li);
                            }
                            //相當於把上述的座位標籤添加在<ul class="seat"></ul>底下
                            //<ul class="seat"><li data-seat-id='1-1' class='booked'>1-1</li></ul>
                            seatList.appendChild(li);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            
            const seats = document.querySelectorAll('.seat li'); //所有座位的標籤
            const defaultColor = '#b9ef9f';//預設顏色 可選取顏色
            let selectedSeats = []; //已選定的座位
            const seatNumbers = document.querySelector('#seatNumbers'); //class seatNumbers
            //為座位格子添加點擊事件
            function addSeatClick(seat) {
                seat.addEventListener('click', () => {
                    //如果被訂購了 就不再添加點擊事件
                    if (seat.classList.contains('booked')) {
                        return;
                    }

                    if (seat.style.backgroundColor === 'red') {
                        seat.style.backgroundColor = defaultColor;
                        //選擇的座位位置在陣列的哪裡
                        const seatIndex = selectedSeats.indexOf(seat.innerText);
                        if (seatIndex !== -1) {
                            //移除它
                            selectedSeats.splice(seatIndex, 1);
                        }
                        updateSelectedSeats();
                    } else {
                        if(selectedSeats.length != localStorage.getItem("totalCount")){
                            seat.style.backgroundColor = 'red';
                            selectedSeats.push(seat.innerText);
                            updateSelectedSeats();
                        }
                    }
                });
            }

            function updateSelectedSeats() {
                seatNumbers.innerHTML = '';
                selectedSeats.forEach(seat => {
                    let numberP = document.createElement('p');
                    numberP.classList.add('seat-number');
                    let seatInfo = document.createTextNode(`${seat.split('-')[0]}排${seat.split('-')[1]}座`);
                    numberP.appendChild(seatInfo);
                    seatNumbers.appendChild(numberP);
                });
                localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            }

            //購買被點擊
            document.querySelector('button').addEventListener('click', () => {
                fetch(`order.php?date=${date}&time=${time}&buyItem=${buyItem}&totalprice=${totalprice}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        selectedSeats: selectedSeats
                    })
                })
                .catch(error => console.error('Error:', error));

                fetch(`book_seats.php?date=${date}&time=${time}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        selectedSeats: selectedSeats
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('購買成功！');
                        window.location.reload();
                        window.location.href='detail.php';
                        localStorage.setItem("totalCount", 0);
                    } else {
                        alert('購買失敗，請重試。');
                    }
                })
                .catch(error => console.error('Error:', error));

            });
        });
    </script>
</body>
</html>