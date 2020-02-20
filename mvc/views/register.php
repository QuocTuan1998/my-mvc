
<div class="d-flex justify-content-center align-items-center h-100">
    <div style="max-width:400px">
        <!-- logo - title -->
        <div class="text-center">                  
            <i class="fa fa-film" style="font-size: 100px"></i>
            <h1>
                <p> Register user</p>
            </h1>
        </div>                
        
        <!-- form login -->    
        <form id="login" action="/mvc/Login/submitRegister" method="post">  
            <input type="hidden" name="_method" value="post"/>
            <!-- email -->
            <div class="d-flex align-items-center w-100 p-2 mt-4">      
                <i class="fa fa-envelope mr-2"></i>          
                <input id="username" name="username" class="form-control" placeholder="username">
            </div>

            <!-- password -->
            <div class="d-flex align-items-center w-100 p-2 mt-3">      
                <i class="fa fa-key mr-2"></i>                      
                <input id="password" type="password" name="password" class="form-control" placeholder="password" value="<?=$password??''?>">            
            </div>

            <!-- button login -->
            <div class="d-flex justify-content-center mt-5" >                
                <input  id="btnLogin" type="submit" name="btnSubmit" value="Login" class="btn btn-outline-dark" style="max-width:150px; width:150px; font-size:1.3rem" onClick="login()">
            </div>
        </form>

        <!-- warning message -->
        <div id="warningMessageContainer" class="<?=isset($msg)?'':'d-none'?> text-danger text-center mt-4"><i id="warningMessage" class="fa fa-exclamation-circle font-italic"> <?=$msg??''?></i></div>        
    </div>
</div>