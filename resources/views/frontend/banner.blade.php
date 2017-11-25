<?php 

$strImageBanner=url("/upload");

            if(!empty($arrModuleBanner)){

                foreach ($arrModuleBanner as $key => $value) {

                    $arrIDArticle=explode(",", $value["article_id"]);     

                    ?>

                    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1200px; height: 400px; overflow: hidden; visibility: hidden;">       

                        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">

                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>

                            <div style="position:absolute;display:block;background:url('<?php echo url("/upload/loading.gif") ?>') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>

                        </div>

                        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1200px; height: 400px; overflow: hidden;"> 

                            <?php 

                                        foreach ($arrIDArticle as $key_1 => $rowArticle_1){                            

                                            ?>

                                            <div data-p="225.00">

                                                <img data-u="image" src="<?php echo $strImageBanner . DS . $rowArticle_1;  ?>" />                                               

                                            </div>                                    

                                            <?php 

                                        }

                                        ?>               

                        </div>        

                        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>

                        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>

                    </div>

                    <?php

                }                                

            }

            ?>  

