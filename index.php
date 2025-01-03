
	<?php 

        session_start();
        require('lib/coreFunction.php');
        require('config/route.php');
        require('config/path.php');
        $s = new CoreFunction();
        require('partial/header.php');
    
    ?>	
		<div class="row content">
            <?php 
                // require('pages/user/contact.php');
                // require('pages/user/registration.php');
                if(!isset($_GET['page'])){
                    $page='';
                }else{
                    $page=$_GET['page'];
                }
                foreach($route as $key => $value){
                    if($key==$page){
                        require($value);
                    }
                }
            ?> 
		</div>
    <?php 
        require('partial/footer.php');
    ?>	
