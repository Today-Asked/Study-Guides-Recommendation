# 參考書推薦平台
![image](https://user-images.githubusercontent.com/63833544/215646605-b6bfff17-7f71-44eb-878c-59f5376daa30.png)
[點我進入網站](https://study-guides.dstw.dev/)
## 介紹
參考書推薦平台致力於提供一個線上的資訊流通空間，學長姊可以在上面撰寫對於參考書的評論供學弟妹參考，使下屆考生能夠花費更少的時間找到自己想要的參考書，透過使用者的互助互利，讓彼此從中受益。
### 特色
- 沒有任何商業利益導向，一切評論都是由熱心學長姐自主填寫
- 評論皆是經過人工審核、評斷為對其他使用者有幫助後，才會出現在網頁上
- 目前我們也正在跟書愛流動-二手書交換平台合作，希望能讓使用者有更完善的體驗。(下方指引中，灰色引言內是這次的合作內容)
## 使用方法
### 一、瀏覽評論
從搜尋頁面查找想要的書，再從列表中任意選取一本瀏覽其評價。<BR>
![image](https://user-images.githubusercontent.com/63833544/215644619-5a749dd2-d0cb-4fb7-b636-dd75f258365d.png)
![image](https://user-images.githubusercontent.com/63833544/215636154-d3d9ab72-04c4-4db3-b2da-00dbefe0dca7.png)
量化評分項目包含內容豐富程度、難易度、詳解詳細程度、排版/美編/顏色等，從多方面來評估一本書的價值。<BR>
在此之下還有其他評價，能夠更完整地得知一本書的內容。
>曾經在書愛流動平台捐書或取書的用戶，其撰寫的評論將會有特別徽章標記，使該則評論更具有可信度。
### 二、撰寫回饋
從側邊面板或是書籍評價最下方跳轉到填寫評論頁面
![image](https://user-images.githubusercontent.com/63833544/215637419-dfe80d3a-40e5-4d3a-9dda-d3ea5e151464.png)
若是不知道要寫什麼的話，在下方也有提供一些小指引喔。
![image](https://user-images.githubusercontent.com/63833544/215645422-87f49c00-a247-43c4-ba52-9a14eead3255.png)
>待評論審核通過後，使用者便能獲取知識貨幣，至書愛流動兌換書籍。
### 三、留下心情
![image](https://user-images.githubusercontent.com/63833544/215644426-575d99af-66df-4890-8254-4ec7fc184c62.png)
無論是讀書技巧分享、或是壓力好大需要找人取暖，都歡迎在留言板留下想說的話！
>即日起在留言版留言，審核通過後便能得到知識貨幣，至書愛流動兌換書籍。
注意留言必須有意義，也不能發表具有攻擊性、冒犯性以及歧視性等字眼，這樣審核是不會通過的喔！
## 開源相關
### 資料表
我們總共有三個資料表，Questionnaire 放每則評論的資訊，Book 放書籍基本資料，msgBoard 內有留言內容。以下為各資料表的欄位。
#### 1. Questionnaire 
##### 基本資料
* Id 流水號
* Date 評論上傳日期
* Book 評論的書本編號(對應Book的Id)

##### 評分（1-5 顆星）
* Overall 綜合評分 
* Content 內容豐富程度
* Difficulty 難易度
* Answer 詳解詳細程度
* Layout 排版 / 顏色 / 美編
##### 文字欄位
* Comment 對這本書的其他評價


#### 2. Book
##### 基本資料
* Id 流水號
* Subject 科目
* Name 書本完整名稱
* Exam 學測 / 指考 / 會考 / 段考 / 多益 / 英檢
* Category 工具書 / 題庫 / 講義
* Publisher 出版社
* Picture 圖片的黨名
* dataAmount 評論筆數
##### 評分的平均值
* Overall 綜合評分 
* Content 內容豐富程度
* Difficulty 難易度
* Answer 詳解詳細程度
* Layout 排版 / 顏色 / 美編

#### 3. msgBoard
- id 流水號
- time 時間
- category 心情 / 讀書技巧
- msg 內容
- review 審核
- redeemCode 兌換碼

### LICENSE
~~雖然我們很想說自己是啤酒軟體~~但我們最後採用 MIT License，見 [LICENSE](https://github.com/Today-Asked/Study-Guides-Recommendation/blob/main/LICENSE)
## Contact us
參考書推薦平台感謝您的蒞臨！有任何指教也歡迎填寫 [意見回饋表單](https://docs.google.com/forms/d/e/1FAIpQLSeViVaUA45k-oR1S5p593Mw2yjy55vACfNlcOCuwWN57kDwhw/viewform)，或是私訊 [IG粉專](https://www.instagram.com/study_guides_recommend/) 或 [email](mailto:study.guides.recommend@gmail.com) 讓我們可以變得更好！
