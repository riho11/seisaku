<style>
header{
    padding: 10px 20px;
    background: #f8dcea;
}

.taiju{
    width: 200px;
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
            <h1><a href="index.php"><img class="taiju" src="img/taijulogo.png" alt="ひよこ体重計"></a></h1>
            <!-- <p>ログアウト</p>
            <p>〇〇さん、頑張りましょう</p> -->
    </header>
<!-- ナビ部分 -->
        <nav class="title">
            <div class="cp_navi">
                <ul id="list">
                    <li class="list"><a class="line" href="regist.php">新規登録</a></li>
                    <li class="list"><a class="line" href="login.php">ログイン</a></li>
                    <li class="list"><a class="line" href="q&a.php">Q&A</a></li>
                    <li class="list"><a class="line" href="firstinquiry.php">お問合せ</a></li>
                </ul>
            </div>
        </nav>