
                        
                   
                           <?php
                            $dilgetir = $db->query("SELECT * FROM dil order by id desc");
                            foreach($dilgetir as $d){?>
                           <a href="#" onclick="doGTranslate('tr|<?=$d['kodu']?>');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;"title="<?=$d['title']?>" class="nturl"><img src="../resimler/<?=$d['resim']?>" height="<?=$d['height']?>" width="<?=$d['width']?>" alt="<?=$d['alt']?>" /></a>
                            <?php } ?>
                             <a href="#" onclick="doGTranslate('tr|tr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;"title="Turkish" class="nturl"><img src="../resimler/tr.png" height="32" width="32" alt="turkish" /></a>
<?php          
include("dil/dil.js");
include("dil/dil.css");
?>


  