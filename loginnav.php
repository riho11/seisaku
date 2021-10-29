<style>
header{
    padding: 10px 20px;
    background: #f8dcea;
}
.taiju{
    width: 200px;
}
.icon{
    border-radius:50%;
    width:  60px;
    height: 60px;
	margin-right: 40px;
}
.firsticon{
	margin-top: auto;
}
.error-name{
  margin-top: auto;
  margin-bottom: 20px;
}
.header{
	display: flex;
    justify-content: flex-end;
}
.header h1{
    margin-right: auto;
}


/* スマホサイズ */
@media screen and (min-width:0px) and (max-width:1024px){
    * {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}
::before , ::after {
	box-sizing: inherit;
}
button {
	margin: 0;
	padding: 0;
	outline: 0;
	border: 0;
	border-radius: 0;
	background: transparent;
	color: inherit;
	vertical-align: middle;
	text-align: inherit;
	font: inherit;
	-webkit-appearance: none;
	appearance: none;
}
    .btn {
	/* ボタンの配置位置  */
	position: fixed;
	top: 32px;
	right: 16px;
	/* 最前面に */
	z-index: 10;
	/* ボタンの大きさ  */
	width: 48px;
	height: 48px;
}
/***** 真ん中のバーガー線 *****/
.btn-line {
	display: block;
	/* バーガー線の位置基準として設定 */
	position: relative;
	/* 線の長さと高さ */
	width: 100%;
	height: 4px;
	/* バーガー線の色 */
	background-color: #979797;
	transition: .2s;
}
/***** 上下のバーガー線 *****/
.btn-line::before , .btn-line::after {
	content: "";
	/* 基準線と同じ大きさと色 */
	position: absolute;
	width: 100%;
	height: 100%;
	background-color: #979797;
	transition: .5s;
}
.btn-line::before {
	/* 上の線の位置 */
	transform: translateY(-16px);
}
.btn-line::after {
	/* 下の線の位置 */
	transform: translateY(16px);
}
/***** メニューオープン時 *****/
.btn-line.open {
	/* 真ん中の線を透明に */
	background-color: transparent;
}
.btn-line.open::before , .btn-line.open::after {
	content: "";
	background-color: #333;
	transition: .2s;
}
.btn-line.open::before {
	/* 上の線を傾ける */
	transform: rotate(45deg);
}
.btn-line.open::after {
	/* 上の線を傾ける */
	transform: rotate(-45deg);
}
/**************** 以下、メニューのスタイリング ****************/
#list {
	/* メニューを縦に */
	display: flex;
    z-index: 100;
	flex-direction: column;
	position: fixed;
	/* メニューの位置マイナス指定で画面外に */
	right: -70%;
	width: 50%;
	height: 70vh;
	background-color: #fa788b;
	color: #efefef;
	transition: .3s;
}
.list {
	/* メニューテキスト位置をリスト内中心に */
	display: flex;
	align-items: center;
	justify-content: center;
    font-size: 40px;
	width: 100%;
	height: 100%;
}
.list:hover {
	background-color: rgba(255, 255, 255, .5);
	color: #333;
	cursor: pointer;
	transition: .3s;
}
/***** メニューオープン時位置0にして画面内に *****/
#list.open {
	position: fixed;
	right: 0;
}
.line{
    color: white;
}
}

/* PCサイズ */
@media screen and (min-width:1025px){
.btn {
    display: none;
}
.cp_navi {
	background-color: #fa788b;
    font-size: 1.5em;
	padding: 10px;
}

.list{
	list-style-type: none;
    width: 100%;
    text-align: center;
}

.menu{
    text-align: left;
	list-style-type: none;
}

.cp_navi > ul > li > a {
	color: white;
	line-height: 30px;
	position: relative;
	text-decoration: none;
}

.list > a {
  position: relative;
  display: inline-block;
  transition: .3s;
}

.list > a::after {
  position: absolute;
  bottom: 0;
  left: 50%;
  content: '';
  width: 0;
  height: 1px;
  background-color: white;
  transition: .3s;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
}

.list > a:hover::after {
  width: 100%;
}

nav #list{
    display: flex;
}

/* ▽マーク */
.cp_navi > ul > li > a > .caret {
    border-top: 4px solid white;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
    content: '';
    display: inline-block;
    vertical-align: middle;
}

.cp_navi > ul > li > div {
    font-size: 0.9em;
	background-color: #E95885;
    border-radius: 0 0 4px 4px;
    position: absolute;
    visibility: hidden;
}

.cp_navi > ul > li:hover > div {
    visibility: visible;
	z-index: 100;
}

.cp_navi > ul > li > div ul{
    padding: 0;
}

.cp_navi > ul > li > div ul > li > a {
    color: #ffffff;
    display: block;
    padding: 12px 24px;
    text-decoration: none;
}

.cp_navi > ul > li > div ul > li:hover > a {
    background-color: rgba( 255, 255, 255, 0.1);
}

#list{
    width: 70%;
    margin: 0 auto;
}
}
</style>

<!-- *****↓html記載↓***** -->
<div class="nav">
    <header>
		<div class="header">
			<h1><a href="mypage.php"><img class="taiju" src="img/taijulogo.png" alt="ひよこ体重計"></a></h1>
			<p class="error-name"><?php echo $_SESSION['namae']; ?>さん、頑張りましょう</p>
			<a href="img.php" class="firsticon"><img class="icon" src="<?php echo $_SESSION["img"]; ?>" alt="アイコン画像"></a>
		</div>
	</header>
    <!-- ナビ部分 -->
    <button type="button" class="btn js-btn">
        <span class="btn-line"></span>
    </button>
    <nav class="title">
        <div class="cp_navi">
            <ul id="list">
                <li class="list"><a class="line" href="mypage.php">マイページ</a></li>
                <li class="list">
					<a class="line" href="weight.php">記録 <span class="caret"></span></a>
                    <div>
						<ul>
							<li class="menu"><a href="weight.php">体重</a></li>
                            <li class="menu"><a href="meal.php">食事</a></li>
                            <li class="menu"><a href="sports.php">運動</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list"><a class="line" href="q&a.php">Q&A</a></li>
                <li class="list"><a class="line" href="inquiry.php">お問合せ</a></li>
                <li class="list"><a class="line" href="logout.php">ログアウト</a></li>
            </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
</div>

<script>
$(function () {
  $('.js-btn').on('click', function () {        // js-btnクラスをクリックすると、
    $('#list , .btn-line').toggleClass('open'); // メニューとバーガーの線にopenクラスをつけ外しする
  })
});
</script>