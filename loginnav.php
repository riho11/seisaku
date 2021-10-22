
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
    width:10%;
    height:10%;
}

/* ナビ全体部分 */
.cp_navi {
	background-color: #fa788b;
    font-size: 1.5em;
	padding: 10px;
}

.title{
    z-index: 999;
	position: sticky;
	top: 0;
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
    width: 50%;
    margin: 0 auto;
}
</style>

<!-- *****↓html記載↓***** -->
<header>
    <h1><a href="mypage.php"><img class="taiju" src="img/taijulogo.png" alt="ひよこ体重計"></a></h1>
    <p><?php echo $_SESSION['namae']; ?>さん、頑張りましょう</p>
    <p class="firsticon"><img class="icon" src="<?php echo $_SESSION["img"]; ?>" alt="アイコン画像"></p>
</header>
<!-- ナビ部分 -->
<nav class="title">
    <div class="cp_navi">
        <ul id="list">
            <li class="list"><a class="line" href="mypage.php">マイページ</a></li>
            <li class="list">
                <a class="line" href="weight.php">記録 <span class="caret"></span></a>
                <div>
                    <ul>
                        <li class="menu"><a href="weight.php">体重</a></li>
                        <li class="menu"><a href="menu.html">食事</a></li>
                        <li class="menu"><a href="menu.html">運動</a></li>
                    </ul>
                </div>
            </li>
            <li class="list"><a class="line" href="access.html">Q&A</a></li>
            <li class="list"><a class="line" href="inquiry.php">お問合せ</a></li>
            <li class="list"><a class="line" href="logout.php">ログアウト</a></li>
        </ul>
    </div>
</nav>