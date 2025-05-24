# DataBaseManagement

本專案為大學「資料庫管理」課程之實作專題，目的是建置一個電影院系統，提供 **使用者端操作介面** 與 **管理端後台介面**。使用 HTML/CSS/JavaScript 製作前端，並以 PHP 撰寫後端，與資料庫進行連動，於本地端 XAMPP 環境運行。

- 前端：使用 **HTML / CSS / JavaScript** 撰寫介面  
- 後端：使用 **PHP** 與資料庫進行溝通

---

## 專案結構

- `movie_back`：管理端  
  初始網頁：`/main.html`
  

- `movie_user`：使用者端  
  初始網頁：`/home.html`
  登入驗證：`/Login.php`
  電影資訊：`/movies-information.php`
  選擇時段、票種：`/test1.php`
  劃位：`/choose.php`
  訂單明細：`/detail.php`
  電影詳細資訊：`/movie_details.php`
  評論：`/comment.php`
  
  

  
---

## 執行方式

可使用 [XAMPP](https://www.apachefriends.org/) 運行本專案：

1. 將整個專案資料夾放入 `xampp/htdocs/` 路徑下
2. 啟動 XAMPP 中的 Apache & MySQL 模組
3. 將final.sql 匯入至MySQL裡
4. 使用以下網址在本地瀏覽器開啟：

### 使用者端網址
127.0.0.1:Apache開放的port/專案名稱/movie_user/home.html

### 管理者端網址
127.0.0.1:Apache開放的port/專案名稱/movie_back/main.html

> 此專案僅能在本地端運行，請確認 XAMPP 已正確設定並啟動 Apache & MySQL。

## 備註

- 確保 PHP 與資料庫設定正常
- 建議使用 Google Chrome 或 Firefox 瀏覽器測試
