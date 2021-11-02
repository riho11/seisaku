<style>
footer{
    padding: 30px 50px;
    background: #e16577;
}

#footer{
    width: 70%;
    margin: 0 auto;

}

a{
    text-decoration: none;    
}

.a_footer{
    color: white;  
    padding:0 25px;
    line-height: 30px;
    font-size:150%;
}

.a_footer:hover{
    text-decoration: underline;
}

.p_footer{
    text-align: center;
    display:flex;
}

.copyright{
    width: 100%;
    font-size: 20px;
    text-align: right;
}

.img_footer{
    text-align: right;
}


@media screen and (min-width:0px) and (max-width:1024px){
.copyright{
    font-size: 15px;
} 
.a_footer{
    font-size:120%;
    padding:0 7px;
}
}
</style>

<!-- html記載 -->
<footer>
    <div id="footer">
        <ul class="p_footer">
            <li><a class="a_footer" href="site.html">サイトについて</a></li>
            <li><a class="a_footer" href="inquiry.php">お問合せ</a></li>
        </ul>
        <div class="img_footer">
            <a href=""><img src="img/facebook.png" alt="フェイスブック" width="50px"></a>
            <a href=""><img src="img/line.png" alt="LINE" width="50px"></a>
            <a href=""><img src="img/tweetbird.png" alt="Twitter" width="50px"></a>
        </div>
        <p class="copyright">(C)2021　ゆるゆるdiet　All Rights Reserved</p>
    </div>
</footer>