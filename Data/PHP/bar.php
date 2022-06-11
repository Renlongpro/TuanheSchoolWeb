<div class="top">
        <ul class="nav">
            <li>
                <a href="/index.php">首页</a>
            </li>
            <li style="float: right;">
                <?php
                require($_SERVER['DOCUMENT_ROOT'].'/Data/PHP/Base.php');
                if(!CheckLogin($sql,-1)){
                    echo '<a href="/Data/PHP/Person.php">个人中心</a>';
                }else{
                    echo '<a href="/Data/HTML/login.html">登陆</a>';
                }
                ?>
            </li>
            <li>
                <a href="/Data/HTML/comm.html">社区（未完善）</a>
            </li>
        </ul>
</div>