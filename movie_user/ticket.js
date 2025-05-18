//載入時先去資料庫要資料
window.onload = function () {
    fetch('get_showtimes.php')
        .then(response => response.json())
        .then(showtimes => {
            // 將 showtimes 儲存為全域變數，方便其他函式使用
            window.showtimes = showtimes;
        });

    fetch('get_ticket.php')
        .then(response => response.json())
        .then(ticket => {
            // 將 ticket 儲存為全域變數，方便其他函式使用
            window.ticket = ticket;
        });
}


function showTimes(date) {
    const showtimeButtons = document.getElementById('showtime-buttons-1');
    showtimeButtons.innerHTML = ''; // 清空原有的時段按鈕

    let previousButton1 = null;
    window.showtimes[date].forEach(time => {

        const button = document.createElement('button');
        button.innerText = time;
        button.onclick = () => showTicket();
        showtimeButtons.appendChild(button);
        button.addEventListener('click', function () {
            if (previousButton1 !== null) {
                previousButton1.style.backgroundColor = '';
            }
            this.style.backgroundColor = '#a5dbfc';
            //將時間存進localstorage方便記錄劃位的資料
            localStorage.setItem("time", button.innerText);
            previousButton1 = this;
        });
    });
}



//讓按鈕顏色保持直到點其他按鈕
let previousButton = null;

document.querySelectorAll('.date-selection button').forEach(button => {
    button.addEventListener('click', function () {
        if (previousButton !== null) {
            previousButton.style.backgroundColor = '';
        }
        this.style.backgroundColor = '#a5dbfc';
        previousButton = this;
    });
});

//點擊時間按鈕顯示票種資訊
window.showTicket = function () {

    let itemDiv = document.querySelector('.choose_ticket');
    // 如果 itemDiv 不存在，創建新的 itemDiv
    if (!itemDiv) {

        const ticketRows = document.getElementById('table');

        ticketRows.innerHTML = `
            <p>選取票種：</p>
            <div class="row header" id="row header">
                <div class="cell">票種</div>
                <div class="cell price">單價</div>
                <div class="cell quantity">數量</div>
                <div class="cell subtotal">小計</div>
            </div>
        `;

        if (window.ticket && window.ticket.tickets) {
            window.ticket.tickets.forEach((item) => {
                console.log(`票種名稱: ${item.Name}, 價格: ${item.price}, 內容: ${item.description}`);
                //撰寫html 參考order.html
                const ticketRows = document.getElementById('table');

                const row = document.createElement('div');
                row.classList.add('row');
                row.innerHTML = `
                    <div class="cell">
                        ${item.Name}
                        <div class="info">內容:${item.description}</div>
                    </div>
                    <div class="cell price">$${item.price}</div>
                    <div class="cell quantity">
                        <select class="quantity-select" data-price="${item.price}" data-name="${item.Name}">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="cell subtotal">$0</div>
                    `;
                ticketRows.appendChild(row);

                row.querySelector('.quantity-select').addEventListener('change', updateSubtotals);
            });
        }

    }


}


//計算位置數量
document.querySelectorAll('.quantity-select').forEach(select => {
    select.addEventListener('change', updateSubtotals);
});

function updateSubtotals() {
    let total = 0;
    let totalCount = 0;
    let buyItems = [];

    document.querySelectorAll('.quantity-select').forEach(select => {
        const price = parseFloat(select.getAttribute('data-price'));
        const quantity = parseInt(select.value);
        const name = select.getAttribute('data-name');
        const subtotal = price * quantity;
        select.closest('.row').querySelector('.subtotal').innerText = `$${subtotal}`;
        total += subtotal;
        totalCount += quantity;
        if (quantity > 0) {
            buyItems.push(`${name}*${quantity}`);
        }
    });
    const floatingButton = document.getElementById('floatingButton');
    floatingButton.innerText = `可選取 ${totalCount} 個位置`;
    floatingButton.style.display = totalCount > 0 ? 'block' : 'none';
    localStorage.setItem("totalCount", `${totalCount}`);
    localStorage.setItem("buyItems", buyItems.join(', '));
    localStorage.setItem("totalprice", `${total}`)
}

